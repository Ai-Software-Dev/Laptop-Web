<!DOCTYPE html>
<html>

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
    <link rel="stylesheet" type="text/css" href="assets/css/Profile/style_profile.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">

</head>

<body>
    <?php
    session_start();
    include('layout/header.php');
    ?>

    <!-- MAINCONTENT -->
    <div id="maincontent">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="block-account">
                        <h5 class="title-account">TRANG TÀI KHOẢN</h5>
                        <p style="font-size: 14px; margin-bottom:20px; margin: 0 0 20px 5px; font-weight:590">Xin chào, <span style="color:#2d2d2d;font-size:17px;font-weight:500"><?php echo $_SESSION['tenkhachhang']; ?></span>&nbsp;!</p>
                        <ul>
                            <li>
                                <a disabled="disabled" class="title-info active" href="javascript:void(0);">Thông tin tài khoản</a>
                            </li>
                            <li>
                                <a class="title-info" href="Orders.php">Đơn hàng của bạn</a>
                            </li>
                            <li>
                                <a class="title-info" href="ChangePassword.php">Đổi mật khẩu</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-8">
                    <h1 class="title-head margin-top-0">THÔNG TIN TÀI KHOẢN</h1>
                    <div class="form-signup name-account">
                        <p><strong style="font-size:16px;margin-left: 10px;font-weight:bold">Họ tên:</strong> <?php echo $_SESSION['tenkhachhang']; ?></p>
                        <p><strong style="font-size:16px;margin-left: 10px;font-weight:bold">Email:</strong> <?php echo $_SESSION['email']; ?></p>

                        <!-- Thêm các thông tin khác của tài khoản ở đây -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- FOOTER -->
    <?php include("layout/footer.php") ?>
</body>

</html>