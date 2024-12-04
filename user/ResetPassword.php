<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ResetPassword</title>
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/slick.css">
    <link rel="stylesheet" href="assets/css/slick-theme.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/Profile/Info.css">
    <script src="assets/js/jquery-3.2.1.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/slick.min.js"></script>

    <style>
        /* Thêm khoảng cách phía trên và dưới cho container */
        .container-custom {
            width: 100%;
            margin-top: 50px;
            margin-bottom: 50px;
            text-align: center;
        }

        .container-custom input {
            width: 500px;
            text-align: left;
            margin-left: 500px;
        }

        .form-group label {
            margin-right: 409px;

        }
    </style>
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
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-md-8 container-custom">
                        <section>
                            <h1 class="title-head margin-top-0">ĐỔI MẬT KHẨU</h1>
                            <div class="form-signup name-account m992">
                                <form action="ResetPass.php" method="POST">
                                    <div class="form-group">
                                        <label for="newPassword">Mật khẩu mới:</label>
                                        <input type="password" name="r_newPassword" id="newPassword" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label style="margin-right:360px" for="confirmPassword">Xác nhận mật khẩu mới:</label>
                                        <input type="password" name="r_confirmPassword" id="confirmPassword" class="form-control" required>
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
            </div>
        </main>
        <!-- END MAINCONTENT -->

        <!-- FOOTER -->
        <?php
        include('layout/footer.php');
        ?>
    </div>
    <!-- END MAINCONTENT -->
    </div>

    <script src="assets/js/slick.min.js"></script>
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