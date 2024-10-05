<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liên Hệ</title>
    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <script src="assets/js/jquery-3.2.1.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="assets/css/slick.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/slick-theme.css" />

    <!-- style -->
    <link rel="stylesheet" type="text/css" href="assets/css/Layout/style_header.css">
    <link rel="stylesheet" type="text/css" href="assets/css/Layout/style_footer.css">
    <link rel="stylesheet" type="text/css" href="assets/css/Product/style_products.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>
<body>
    <?php
    include_once '../core/Connection.php';
    session_start();
    include('layout/header.php');
    ?>
    <div id="maincontent">
        <div class="container">
            <!--ENDMENUNAV-->
            <div class="col-md-12 bor">
                <section class="box-main1">
                    <h3 class="title-main" style="text-align: center;"><a href="javascript:void(0)"> Liên hệ </a> </h3>
                    <img src="../public/images/banner/LienHe.png" style="width: 100%; height: 500px;">
                    <h3 style="margin-bottom: 20px; margin-top: 20px; color: #666;">HỖ TRỢ - TƯ VẤN 24/7</h3>
                    <p style="font-size: 16px;">
                        Không một sản phẩm hay dịch vụ nào là không có giá trị. Thế nhưng với MAXSHOP giá trị chúng tôi 
                        mang đến cho khách hàng phải là giá trị tốt nhất bằng tất cả tâm huyết là lòng đam mê để tạo ra.</p>

                    <h2 style="margin-top: 20px; margin-bottom: 20px; color: #0e763c; font-weight: bold;">Công Ty Cổ Phần MaxShop International</h2>
                    <ul>
                        <li style="font-size: 16px;">Địa chỉ: 140 Lê Trọng Tấn - Tây Thạnh - Tân Phú - TP. Hồ Chí Minh</li>
                        <li style="font-size: 16px;">Showroom: 140 Lê Trọng Tấn - Tây Thạnh - Tân Phú - TP. Hồ Chí Minh</li>
                        <li style="font-size: 16px;">Email: <a href="#" style="font-size: 16px;"> maxmaxshopp@gmail.com</a></li>
                        <li style="font-size: 16px;">HOTLINE: <a href="#" style="font-size: 16px;"> (01) 234 567 89</a> - Fax: <a href="#" style="font-size: 16px;">091 100 07 77</a></li>
                    </ul>
                    <br>
                </section>
            </div>
        </div>
    </div>
    <?php
        include('layout/footer.php');
    ?>
</body>
</html>