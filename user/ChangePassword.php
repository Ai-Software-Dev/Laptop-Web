<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đơn hàng của bạn</title>
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
</head>

<body>
    <?php
    session_start();
    ?>

    <div id="wrapper">
        <!---->
        <!--HEADER-->
        <?php
        include('layout/header.php');
        ?>

        <!-- MAINCONTENT -->
        <main id="maincontent">
            <div class="container">
                <div class="row">
                    <aside class="col-md-4" style="padding-right: 20px;">
                        <div class="block-account">
                            <h5 class="title-account">TRANG TÀI KHOẢN</h5>
                            <p style="font-size: 14px; margin-bottom: 20px; margin: 0 0 20px 5px; font-weight: 590;">Xin chào, <span style="color:#2d2d2d; font-size: 17px; font-weight: 500;"><?php echo $_SESSION['tenkhachhang']; ?></span>!</p>
                            <ul>
                                <li><a class="title-info" href="CustomerInfo.php">Thông tin tài khoản</a></li>
                                <li><a class="title-info active" href="Orders.php">Đơn hàng của bạn</a></li>
                                <li><a class="title-info" href="ChangePassword.php">Đổi mật khẩu</a></li>
                            </ul>
                        </div>
                    </aside>
                    <section class="col-md-8" style="padding-left: 60px;">
                        <h1 class="title-head margin-top-0">ĐỔI MẬT KHẨU</h1>
                        <div class="form-signup name-account m992">
                            <form action="ChangePassProcess.php" method="POST">
                                <div class="form-group">
                                    <label for="currentPassword">Mật khẩu hiện tại:</label>
                                    <input type="password" name="currentPassword" id="currentPassword" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="newPassword">Mật khẩu mới:</label>
                                    <input type="password" name="newPassword" id="newPassword" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="confirmPassword">Xác nhận mật khẩu mới:</label>
                                    <input type="password" name="confirmPassword" id="confirmPassword" class="form-control" required>
                                </div>
                                <button type="submit" class="btn btn-primary" style="background-color:#333; font-weight:600;">Đổi mật khẩu</button>
                            </form>
                            <?php
                            // Hiển thị thông báo lỗi nếu có
                            if (isset($_SESSION['change_password_error'])) {
                                echo '<p style="color: red;">' . $_SESSION['change_password_error'] . '</p>';
                                unset($_SESSION['change_password_error']); // Xóa thông báo lỗi sau khi đã hiển thị
                            }
                            ?>
                        </div>
                    </section>

                </div>
            </div>
        </main>
        <!-- END MAINCONTENT -->

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