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

        $bills = [];
        if (isset($_GET['id'])) {
            $mahoadon = $_GET['id'];
            $sql = 'SELECT sp.TenSanPham, ct.MaHoaDon, sp.HinhAnh, ct.SoLuong, ct.ThanhTien 
                    FROM sanpham sp 
                    JOIN chitiethoadon ct ON sp.MaSanPham = ct.MaSanPham
                    WHERE ct.MaHoaDon = :mahd';
            $st = $pdo->prepare($sql);
            $st->execute([':mahd' => $mahoadon]);
            $bills = $st->fetchAll(PDO::FETCH_OBJ);
        }

        include("layout/header.php")
    ?>
    <main id="maincontent">
        <div class="container">
            <div class="row">
                <aside class="col-md-4" style="padding-right: 20px;">
                    <div class="block-account">
                        <h5 class="title-account">TRANG TÀI KHOẢN</h5>
                        <p style="font-size: 14px; margin-bottom: 20px; margin: 0 0 20px 5px; font-weight: 590;">
                            Xin chào, <span style="color:#2d2d2d; font-size: 17px; font-weight: 500;"><?php echo $_SESSION['tenkhachhang']; ?></span>!
                        </p>
                        <ul>
                            <li><a class="title-info" href="CustomerInfo.php">Thông tin tài khoản</a></li>
                            <li><a class="title-info active" href="Orders.php">Đơn hàng của bạn</a></li>
                            <li><a class="title-info" href="ChangePassword.php">Đổi mật khẩu</a></li>
                        </ul>
                    </div>
                </aside>
                <section class="col-md-8" style="padding-left: 60px;">
                    <h1 class="title-head margin-top-0">CHI TIẾT ĐƠN HÀNG CỦA BẠN</h1>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Đơn Hàng</th>
                                    <th>Tên Sản Phẩm</th>
                                    <th>Hình Ảnh</th>
                                    <th>Số Lượng</th>
                                    <th>Thành Tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (count($bills) > 0) {
                                    foreach ($bills as $bill) {
                                        echo "<tr>";
                                        echo "<td>" . htmlspecialchars($bill->MaHoaDon) . "</td>";
                                        echo "<td>" . htmlspecialchars($bill->TenSanPham) . "</td>";
                                        echo "<td><img src='../public/images/products/" . htmlspecialchars($bill->HinhAnh) . "' alt='Hình ảnh sản phẩm' width='100'></td>";
                                        echo "<td>" . htmlspecialchars($bill->SoLuong) . "</td>";
                                        echo "<td>" . htmlspecialchars($bill->ThanhTien) . "</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr class='no-orders'><th class='no-border-left' colspan='5' class='text-center'>Không có chi tiết đơn hàng nào.</th></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </div>
    </main>
    <?php
        include("layout/footer.php")
    ?>
</body>
</html>