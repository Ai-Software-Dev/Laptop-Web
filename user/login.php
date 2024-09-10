<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <script src="assets/js/jquery-3.2.1.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="assets/css/slick.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/slick-theme.css" />

    <!-- style -->
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="assets/css/Layout/style_header.css">
    <link rel="stylesheet" type="text/css" href="assets/css/Layout/style_footer.css">
    <link rel="stylesheet" type="text/css" href="assets/css/Login/style_login.css">

    <title>Login</title>
</head>


<?php
include_once '../core/Connection.php';
session_start();

$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Kiểm tra tài khoản tồn tại trong cột TenTaiKhoan
    $sql = "SELECT * FROM user WHERE TenTaiKhoan = :username";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Giả định MatKhau được lưu dưới dạng văn bản đơn giản (điều này không được khuyến khích trong sản xuất)
        // Nếu MatKhau được mã hóa, sử dụng password_verify
        if ($password == $row['MatKhau']) {
            $_SESSION['username'] = $username; // Lưu TenTaiKhoan vào session
            $_SESSION['tenkhachhang'] = $row['TenKhachHang']; // Lưu TenKhachHang vào session
            $_SESSION['mataikhoan'] = $row['MaTaiKhoan']; // Lưu MaTaiKhoan
            $_SESSION['email'] = $row['Email']; //Email
            header("Location: index.php");
            exit();
        } else {
            $error_message = "Mật khẩu không đúng!";
        }
    } else {
        $error_message = "Bạn chưa có tài khoản, cần tạo tài khoản.";
    }
}
?>

<body>
    <?php
        include('layout/header.php');
    ?>
    <div class="container login-container">
        <h3>ĐĂNG NHẬP TÀI KHOẢN</h3>
        <form id="form_login" method="post" action="login.php">
            <p>Tên Tài Khoản: <span class="required">*</span></p>
            <input type="text" name="username" placeholder="Nhập tên tài khoản" required><br>
            <p>Mật Khẩu: <span class="required">*</span></p>
            <input style="margin-bottom: 0" type="password" name="password" placeholder="Mật Khẩu" required><br>
            <p class="forget">Quên mật khẩu? Nhấn vào <a href="ForgetPassword.php">đây.</a></p>
            <input type="submit" class="btn-login" value="Đăng Nhập">
            <?php if ($error_message != "") { ?>
                <div class="alert alert-danger" style=""><?php echo $error_message; ?></div>
            <?php } ?>
        </form>
        <p class="sign_up">Bạn chưa có tài khoản ? <a href="Register.php">Đăng kí tại đây.</a></p>
    </div>

    <?php
    include('layout/footer.php');
    ?>
</body>

</html>