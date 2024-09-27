<?php
session_start();
require 'Connection.php';

if (!isset($_SESSION['reset_email'])) {
    header('Location: ForgetPassword.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Kiểm tra mật khẩu mới và mật khẩu xác nhận
    $newPassword = $_POST['r_newPassword'];
    $confirmPassword = $_POST['r_confirmPassword'];

    if ($newPassword != $confirmPassword) {
        $_SESSION['change_password_error'] = "Mật khẩu xác nhận không khớp.";
        header("Location: ResetPassword.php");
        exit();
    }

    // Lấy email từ session
    $r_email = $_SESSION['reset_email'];

    // Cập nhật mật khẩu mới vào cơ sở dữ liệu
    $updateStmt = $pdo->prepare("UPDATE user SET MatKhau = :newPassword WHERE Email = :r_email");
    $updateStmt->bindParam(':newPassword', $newPassword);
    $updateStmt->bindParam(':r_email', $r_email);
    $updateStmt->execute();

    // Đổi mật khẩu thành công
    // Xóa session đăng nhập để yêu cầu đăng nhập lại với mật khẩu mới
    unset($_SESSION['mataikhoan']);
    unset($_SESSION['tenkhachhang']);
    unset($_SESSION['username']);

    // Chuyển hướng người dùng đến trang đăng nhập với thông báo thành công
    $_SESSION['change_password_success'] = "Đổi mật khẩu thành công. Vui lòng đăng nhập lại.";
    header('Location: login.php');
    exit();
} else {
    // Nếu không phải phương thức POST, chuyển hướng người dùng
    header('Location: ResetPassword.php');
    exit();
}
?>
