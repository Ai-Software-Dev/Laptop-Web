<?php
session_start();
include_once '../core/Connection.php'; // Kết nối đến cơ sở dữ liệu
require("./PHPMailer-master/src/PHPMailer.php");
require("./PHPMailer-master/src/SMTP.php");
require("./PHPMailer-master/src/Exception.php");

// use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Kiểm tra xem email có tồn tại trong cơ sở dữ liệu không
    $stmt = $pdo->prepare("SELECT * FROM [users] WHERE Email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Nếu email tồn tại, sinh mã OTP
        $otp = rand(100000, 999999);
        $_SESSION['otp'] = $otp;
        $_SESSION['reset_email'] = $email;

        // Cấu hình và gửi email
        $mail = new PHPMailer\PHPMailer\PHPMailer();
        try {
            $mail->IsSMTP();
            $mail->SMTPDebug = 2;
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = 'ssl';
            $mail->Host = "smtp.gmail.com";
            $mail->Port = 465;
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
            $mail->IsHTML(true);
            $mail->Username = "maxmaxshopp@gmail.com";
            $mail->Password = "rhrg obph rbpg tmsm";
            $mail->SetFrom("maxmaxshopp@gmail.com");
            $mail->Subject = "Mã OTP đặt lại mật khẩu";
            $mail->Body = "<p>Xin chào,</p>
                <p>Mã OTP để đặt lại mật khẩu của bạn là: <strong>$otp</strong></p>
                <p>Vui lòng nhập mã này trên trang để tiếp tục.</p>
                <p>Trân trọng,<br>Your Shop Name</p>";
            $mail->AddAddress($email);

            if ($mail->Send()) {
                $_SESSION['message'] = "Mã OTP đã được gửi đến email $email.";
                header('Location: EnterOTP.php'); // Chuyển hướng tới trang nhập OTP
                exit();
            } else {
                $_SESSION['email_error'] = "Không thể gửi OTP. Vui lòng thử lại sau.";
            }
        } catch (Exception $e) {
            $_SESSION['email_error'] = "Lỗi gửi email: " . $mail->ErrorInfo;
        }
    } else {
        // Nếu email không tồn tại, hiển thị thông báo lỗi
        $_SESSION['email_error'] = "Email không tồn tại trong hệ thống.";
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
    include('layout/footer.php');
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