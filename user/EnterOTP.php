<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $entered_otp = $_POST['otp'];

    if ($entered_otp == $_SESSION['otp']) {
        // Nếu OTP đúng, chuyển hướng đến trang đặt lại mật khẩu
        header('Location: ResetPassword.php');
        exit();
    } else {
        $_SESSION['otp_error'] = "Mã OTP không chính xác.";
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
    <title>Nhập OTP</title>
</head>

<body>
    <?php
    include('layout/header.php');
    ?>
    <div class="container login-container">
        <h3>NHẬP MÃ OTP</h3>
        <form id="form_forgot_password" method="POST" action="EnterOTP.php">
            <p>Nhập mã OTP đã được gửi đến email: <span class="required">*</span></p>
            <input type="text" name="otp" placeholder="Nhập mã OTP" required> <br/>
            <input type="submit" class="btn-login" value="Xác Nhận">
            <?php
            if (isset($_SESSION['otp_error'])) {
                echo '<p style="color: red;">' . $_SESSION['otp_error'] . '</p>';
                unset($_SESSION['otp_error']);
            }
            ?>
        </form>
        <p class="sign_up">Không nhận được OTP? <a href="ForgetPassword.php">Gửi lại.</a></p>
    </div>
    <!-- FOOTER -->
    <?php
    include('layout/footer.php');
    ?>
    </div>
    <!-- END MAINCONTENT -->
    </div>

    <script src="./js/slick.min.js"></script>
</body>

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