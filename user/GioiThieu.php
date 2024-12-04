<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giới Thiệu</title>
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
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
        }
        .content {
            margin: 0 200px;
            
        }
        .content h3 {
            text-align: center;
            margin: 10px;
        }
        .content p, strong, .content ul li {
            margin: 10px 0;
            font-size: 14px;
        }
        .content ul {
            padding-left: 20px;
        }
    </style>
</head>
<body>
    <?php
    include_once '../core/Connection.php';
    session_start();
    include('layout/header.php');
    ?>
    <div id="maincontent">
        <div class="container">
            <div class="col-md-12 bor">
                <h3 class="title-main" style="text-align: center;"><a href="javascript:void(0)"> Giới thiệu </a> </h3>
                <p>Chào mừng đến với <strong>MaxShop.vn</strong> – điểm đến hàng đầu cho mọi nhu cầu về laptop của bạn!</p>
                <p><strong>Về Chúng Tôi</strong></p>
                <p><strong>MaxShop.vn</strong> là nền tảng thương mại điện tử chuyên cung cấp các sản phẩm laptop chất lượng cao từ các thương hiệu nổi tiếng trên thế giới. Chúng tôi tự hào mang đến cho khách hàng những trải nghiệm mua sắm trực tuyến tiện lợi, an toàn và đáng tin cậy.</p>
                <p><strong>Sứ Mệnh Của Chúng Tôi</strong></p>
                <p>- Sứ mệnh của MaxShop.vn là cung cấp các sản phẩm laptop chất lượng với giá cả cạnh tranh, đồng thời mang đến dịch vụ chăm sóc khách hàng chu đáo và chuyên nghiệp. Chúng tôi cam kết:</p>
                <ul>
                    <li><strong>+ Sản Phẩm Đa Dạng:</strong> Cung cấp một loạt các dòng laptop từ các thương hiệu nổi tiếng như Apple, Dell, HP, Lenovo, ASUS, Acer, và nhiều hơn nữa.</li>
                    <li><strong>+ Giá Cả Hợp Lý:</strong> Mang đến giá cả cạnh tranh nhất trên thị trường, kèm theo các chương trình khuyến mãi và giảm giá hấp dẫn.</li>
                    <li><strong>+ Giao Hàng Nhanh Chóng:</strong> Đảm bảo giao hàng nhanh chóng và an toàn đến tay khách hàng.</li>
                    <li><strong>+ Hỗ Trợ Khách Hàng:</strong> Đội ngũ hỗ trợ khách hàng nhiệt tình, sẵn sàng giải đáp mọi thắc mắc và hỗ trợ kỹ thuật, bảo hành sản phẩm.</li>
                </ul>
                <p><strong>Tại Sao Chọn MaxShop.vn?</strong></p>
                <ul>
                    <li><strong>+ Dễ Dàng Tìm Kiếm và Lựa Chọn:</strong> Với công cụ tìm kiếm và lọc sản phẩm thông minh, bạn có thể dễ dàng tìm thấy chiếc laptop phù hợp nhất với nhu cầu của mình.</li>
                    <li><strong>+ So Sánh Sản Phẩm:</strong> Tính năng so sánh giúp bạn dễ dàng đánh giá và lựa chọn sản phẩm tốt nhất.</li>
                    <li><strong>+ Đánh Giá và Nhận Xét:</strong> Xem đánh giá từ những khách hàng khác để có quyết định mua sắm thông minh.</li>
                    <li><strong>+ Thanh Toán Linh Hoạt:</strong> Hỗ trợ nhiều phương thức thanh toán an toàn và tiện lợi.</li>
                </ul>
                <p><strong>Cam Kết Của Chúng Tôi</strong></p>
                <p>- Chúng tôi cam kết không ngừng cải tiến và hoàn thiện dịch vụ, mang đến cho bạn những trải nghiệm mua sắm trực tuyến tuyệt vời nhất. Với MaxShop.vn, bạn hoàn toàn yên tâm về chất lượng sản phẩm và dịch vụ.</p>
                <p><strong>MaxShop.vn</strong> – Điểm đến tin cậy cho mọi nhu cầu về laptop của bạn!</p>
                <p>- Hãy trải nghiệm ngay hôm nay và khám phá thế giới laptop đa dạng, chất lượng cùng chúng tôi.</p>
            </div>
        </div>
    </div>
    <?php
        include('layout/footer.php');
    ?>
</body>
</html>