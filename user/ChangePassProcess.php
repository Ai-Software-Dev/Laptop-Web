<?php
    session_start();

    if (!isset($_SESSION['mataikhoan'])) {
        header('Location: login.php');
        exit();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Kết nối đến cơ sở dữ liệu
        include_once '../core/Connection.php';

        // Lấy thông tin từ biểu mẫu
        $matk = $_SESSION['mataikhoan'];
        $currentPassword = $_POST['currentPassword'];
        $newPassword = $_POST['newPassword'];
        $confirmPassword = $_POST['confirmPassword'];

        // Kiểm tra mật khẩu hiện tại của người dùng
        $stmt = $pdo->prepare("SELECT * FROM user WHERE MaTaiKhoan = :matk");
        $stmt->bindParam(':matk', $matk);
        $stmt->execute();
        $userData = $stmt->fetch();

        // Kiểm tra xem mật khẩu hiện tại nhập vào có đúng không
        if ($currentPassword != $userData['MatKhau']) {
            // Nếu mật khẩu hiện tại không đúng, chuyển hướng người dùng và thông báo lỗi
            $_SESSION['change_password_error'] = "Mật khẩu hiện tại không đúng";
            header('Location: ChangePassword.php');
            exit();
        }

        // Kiểm tra mật khẩu mới và xác nhận mật khẩu mới có khớp không
        if ($newPassword != $confirmPassword) {
            // Nếu mật khẩu mới và xác nhận mật khẩu mới không khớp, chuyển hướng người dùng và thông báo lỗi
            $_SESSION['change_password_error'] = "Mật khẩu mới và xác nhận mật khẩu mới không khớp";
            header('Location: ChangePassword.php');
            exit();
        }

        // Cập nhật mật khẩu mới vào cơ sở dữ liệu
        $updateStmt = $pdo->prepare("UPDATE user SET MatKhau = :newPassword WHERE MaTaiKhoan = :matk");
        $updateStmt->bindParam(':newPassword', $newPassword);
        $updateStmt->bindParam(':matk', $matk);
        $updateStmt->execute();

        // Đổi mật khẩu thành công
        // Xóa session đăng nhập để yêu cầu đăng nhập lại với mật khẩu mới
        unset($_SESSION['mataikhoan']);
        unset($_SESSION['tenkhachhang']);
        unset($_SESSION['username']);

        // Chuyển hướng người dùng đến trang đăng nhập với thông báo thành công
        $_SESSION['change_password_success'] = "Đổi mật khẩu thành công. Vui lòng đăng nhập lại.";
        // Hiển thị thông báo nếu đổi mật khẩu thành công
        if (isset($_SESSION['change_password_success'])) {
            echo "<script>
                alert('Bạn đã đổi mật khẩu thành công, vui lòng đăng nhập lại với mật khẩu mới.');
                window.location.href = 'login.php';
            </script>";
            unset($_SESSION['change_password_success']); // Xóa thông báo sau khi đã hiển thị
        }
    } else {
        // Nếu không phải phương thức POST, chuyển hướng người dùng
        header('Location: ChangePassword.php');
        exit();
    }
?>
