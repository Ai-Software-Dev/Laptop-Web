<?php
session_start();
require './core/Connection.php'; // Kết nối đến cơ sở dữ liệu

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Kiểm tra xem email có tồn tại trong cơ sở dữ liệu không
    $stmt = $pdo->prepare("SELECT * FROM user WHERE Email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Nếu email tồn tại, lưu email vào session và chuyển hướng đến trang ResetPassword.php
        $_SESSION['reset_email'] = $email;

        // Chuyển hướng người dùng đến trang ResetPassword.php
        header('Location: ResetPassword.php');
        exit();
    } else {
        // Nếu email không tồn tại, hiển thị thông báo lỗi
        $_SESSION['email_error'] = "Email không tồn tại trong hệ thống.";
        header('Location: ForgetPassword.php');
        exit();
    }
}
?>

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

    <!--  -->
    <link rel="stylesheet" type="text/css" href="assets/css/Layout/style_header.css">
    <link rel="stylesheet" type="text/css" href="assets/css/Layout/style_footer.css">
    <link rel="stylesheet" type="text/css" href="assets/css/Home/style_home.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/Login/style_login.css">
    <title>MaxShop_ForgetPassword</title>
</head>

<body>
    <?php
    include('layout/header.php');
    ?>

    <div class="container login-container">
        <h3>QUÊN MẬT KHẨU</h3>
        <form id="form_forgot_password" method="POST" action="ForgetPassword.php">
            <p>Nhập Email của bạn để đặt lại mật khẩu: <span class="required">*</span></p>
            <input style="" type="email" name="email" placeholder="Nhập Email" required><br>
            <input type="submit" class="btn-login" value="Gửi Yêu Cầu">
            <?php
            if (isset($_SESSION['email_error'])) {
                echo '<p style="color: red;">' . $_SESSION['email_error'] . '</p>';
                unset($_SESSION['email_error']);
            }
            ?>
        </form>
        <p class="sign_up">Quay lại trang <a href="login.php">đăng nhập.</a></p>
    </div>

    <!-- FOOTER -->
    <?php
    include('layout/header.php');
    ?>
    </div>
    <!-- END MAINCONTENT -->
    </div>

    <script src="./js/slick.min.js"></script>
</body>

</html>

<script type="text/javascript">
    $(function() {
        $hidenitem = $(".hidenitem");
        $itemproduct = $(".item-product");
        $itemproduct.hover(function() {
            $(this).children(".hidenitem").show(100);
        }, function() {
            $hidenitem.hide(500);
        })
    })
</script>

<script>
    $(function() {
        $(".account-menu").hover(function() {
            $(this).find(".account-menu-content").show();
        }, function() {
            $(this).find(".account-menu-content").hide();
        });
    });
</script>