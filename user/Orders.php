<!DOCTYPE html>
<html lang="en">
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
    <link rel="stylesheet" type="text/css" href="assets/css/Profile/style_profile.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>
<body>
    <?php
        session_start();
        if (!isset($_SESSION['mataikhoan'])) {
            header('Location: Login.php');
            exit();
        }
        
        include_once '../core/Connection.php';
        // Lấy thông tin đơn hàng từ cơ sở dữ liệu
        $matk = $_SESSION['mataikhoan'];
        $stmt = $pdo->prepare("SELECT MaHoaDon, NgayMua, DiaChi, TongTien, TrangThai FROM hoadon WHERE MaTaiKhoan = :matk");
        $stmt->bindParam(':matk', $matk);
        $stmt->execute();
        
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

        include("layout/header.php");
    ?>

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
                    <h1 class="title-head margin-top-0">ĐƠN HÀNG CỦA BẠN</h1>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Đơn Hàng</th>
                                    <th>Ngày</th>
                                    <th>Địa Chỉ</th>
                                    <th>Giá trị đơn hàng</th>
                                    <th>Trạng Thái</th>
                                    <th>Chi tiết</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    if (count($orders) > 0) {
                                    foreach ($orders as $order) {
                                        echo "<tr>";
                                        echo "<td>" . htmlspecialchars($order['MaHoaDon']) . "</td>";
                                        echo "<td>" . htmlspecialchars($order['NgayMua']) . "</td>";
                                        echo "<td>" . htmlspecialchars($order['DiaChi']) . "</td>";
                                        echo "<td>" . htmlspecialchars($order['TongTien']) . "</td>";
                                        echo "<td>" . htmlspecialchars($order['TrangThai']) . "</td>";
                                        echo "<td><a style='font-size: 14px;' href='DetailOrder.php?id=" . htmlspecialchars($order['MaHoaDon']) . "'>Xem chi tiết</a></td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr class='no-orders'><th class='no-border-left' colspan='5' class='text-center'>Bạn chưa có đơn hàng nào.</th></tr>";

                                }   
                                ?>
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </div>
    </main>

    <?php include("layout/footer.php"); ?>
</body>
</html>