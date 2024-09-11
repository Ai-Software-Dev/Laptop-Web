<!DOCTYPE html>
<html>

<head>
    <title>Chi tiết sản phẩm</title>
    <meta charset="utf-8">
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
        .alert {
            padding: 20px;
            background-color: #f44336;
            color: white;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 99999;
            /* Ensure it is above all other elements */
            width: 80%;
            /* Optional: Adjust width as needed */
            max-width: 500px;
            /* Optional: Set a max-width */
            text-align: center;
        }

        .closebtn {
            margin-left: 15px;
            color: white;
            font-weight: bold;
            float: right;
            font-size: 22px;
            line-height: 20px;
            cursor: pointer;
            transition: 0.3s;
        }

        .closebtn:hover {
            color: black;
        }
    </style>

</head>

<body>


    <?php
    include_once '../core/Connection.php';
    session_start();
    include('layout/header.php');

    $masp = null;
    if (isset($_GET["id"])) {
        $masp = (int)$_GET["id"];
    }

    if ($masp !== null) {
        $sql = "SELECT * FROM SANPHAM WHERE MaSanPham = :masp";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['masp' => $masp]);
        $sp = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        // Xử lý khi không có sản phẩm nào được chọn
        echo "Không có sản phẩm nào được chọn.";
        exit;
    }

    function getSoLuongDaBanProduct($pdo, $masp)
    {
        $sqldaban = "SELECT SUM(chitiethoadon.soluong) AS SoLuongDaBan 
                    FROM sanpham 
                    INNER JOIN chitiethoadon ON sanpham.MaSanPham = chitiethoadon.masanpham 
                    WHERE sanpham.MaSanPham = :masp";
        $stmt = $pdo->prepare($sqldaban);
        $stmt->execute(['masp' => $masp]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['SoLuongDaBan'] ?? 0;
    }

    if (isset($_POST["btn_addcart"])) {
        $sql_magiohang = "SELECT MaGioHang FROM GIOHANG WHERE MaTaiKhoan = :mataikhoan";
        $stmt_magiohang = $pdo->prepare($sql_magiohang);
        $stmt_magiohang->execute(['mataikhoan' => $_SESSION["mataikhoan"]]);
        $result = $stmt_magiohang->fetch(PDO::FETCH_ASSOC);

        $magiohang = $result['MaGioHang'];
        $masp = $_POST["masp"];
        $dongia = $_POST["dongia"];
        $soluong = $_POST["soluong"];

        $sql_KTRATonTai = "SELECT * FROM CHITIETGIOHANG WHERE MAGIOHANG = :magiohang AND MASANPHAM = :masp";
        $st_KTRATonTai = $pdo->prepare($sql_KTRATonTai);
        $st_KTRATonTai->execute(['magiohang' => $magiohang, 'masp' => $masp]);

        if ($st_KTRATonTai->rowCount() > 0) {
            // Lấy số lượng hiện tại trong giỏ hàng
            $current_cart_quantity = $st_KTRATonTai->fetch(PDO::FETCH_ASSOC)['SoLuong'];

            // Lấy số lượng hàng còn trong kho của sản phẩm
            $sql_get_stock = "SELECT SoLuong FROM SANPHAM WHERE MaSanPham = :masp";
            $stmt_get_stock = $pdo->prepare($sql_get_stock);
            $stmt_get_stock->execute(['masp' => $masp]);
            $product_stock = $stmt_get_stock->fetch(PDO::FETCH_ASSOC)['SoLuong'];

            // Tính toán số lượng mới sau khi thêm vào giỏ hàng
            $new_quantity = $current_cart_quantity + $soluong;

            if ($new_quantity <= $product_stock) {
                $sql_update_CTGH = "UPDATE CHITIETGIOHANG SET SOLUONG = :soluong, THANHTIEN = :thanhtien WHERE MAGIOHANG = :magiohang AND MASANPHAM = :masp";
                $st_updateCTGH = $pdo->prepare($sql_update_CTGH);
                $st_updateCTGH->execute([
                    'soluong' => $new_quantity,
                    'thanhtien' => $new_quantity * $dongia,
                    'magiohang' => $magiohang,
                    'masp' => $masp
                ]);
            } else {
    ?>
                <div class="alert">
                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                    <p style="font-size: 25px;">Thông báo</p>
                    <p style="font-size: 18px; color:white">Số lượng vượt quá số lượng sản phẩm có sẵn.</p>
                </div>
    <?php
            }
        } else {
            $sql_insert_CTGH = "INSERT INTO CHITIETGIOHANG (MaGioHang, MaSanPham, SoLuong, ThanhTien) VALUES (:magiohang, :masp, :soluong, :thanhtien)";
            $st_insertCTGH = $pdo->prepare($sql_insert_CTGH);
            $st_insertCTGH->execute([
                'magiohang' => $magiohang,
                'masp' => $masp,
                'soluong' => $soluong,
                'thanhtien' => $soluong * $dongia
            ]);
        }
    }
    ?>

    <div id="wrapper">

        <div id="maincontent">
            <?php
            foreach ($sp as $row) {
            ?>
                <div class="container bor" style="overflow: hidden; padding: 20px">
                    <div class="col-md-3">
                        <img src="    ../public/images/products/<?php echo $row["HinhAnh"] ?>" style="width: 100%;">
                    </div>
                    <div class="col-md-9">
                        <h3 style="font-weight: bold;"><?php echo $row["TenSanPham"] ?></h3>
                        <p style="font-size: 14px; margin-bottom: 10px; margin-top: 10px;"><?php echo getSoLuongDaBanProduct($pdo, $row["MaSanPham"]); ?> <span style="font-size: 16px; color:#767676">Đã bán</span></p>
                        <p style="font-size: 16px; margin-bottom: 10px;">Số lượng <span style="font-size: 14px; color:#767676"><?php echo $row["SoLuong"] ?> sản phẩm có sẵn</span></p>
                        <b style="font-size: 25px; margin-bottom: 10px;" class="price"><?php echo number_format($row["GiaBan"], 0, ',', '.') ?>đ</b><br>

                        <?php
                        if (isset($_SESSION["mataikhoan"])) {
                            if ($row["SoLuong"] > 0) {
                        ?>
                                <form method="post" action="ShowDetail.php?id=<?php echo $row["MaSanPham"] ?>">
                                    <input type="hidden" name="masp" value="<?php echo $row["MaSanPham"] ?>">
                                    <input type="hidden" name="dongia" value="<?php echo $row["GiaBan"] ?>">
                                    <input type="hidden" name="soluong" value="1">
                                    <button class="btn btn-danger" name="btn_addcart" value="btn_addcart" style="margin-top: 10px; margin-bottom: 10px; padding: 10px">THÊM VÀO GIỎ HÀNG</button>
                                </form>
                            <?php
                            } else {
                            ?>
                                <button class="btn btn" style="margin-top: 10px; margin-bottom: 10px; padding: 10px; background-color: gray;" disabled>THÊM VÀO GIỎ HÀNG</button>
                            <?php
                            }
                            ?>

                            <?php
                        } else {
                            if ($row["SoLuong"] > 0) {
                            ?>
                                <a href="Login.php">
                                    <button class="btn btn-danger" style="margin-top: 10px; margin-bottom: 10px; padding: 10px">
                                        THÊM VÀO GIỎ HÀNG
                                    </button>
                                </a>
                            <?php
                            } else {
                            ?>
                                <a href="Login.php" style="text-decoration: none; color: white">
                                    <button class="btn btn" style="margin-top: 10px; margin-bottom: 10px; padding: 10px; background-color: gray;">
                                        THÊM VÀO GIỎ HÀNG
                                    </button>
                                </a>
                            <?php
                            }
                            ?>
                        <?php
                        }

                        ?>

                        <div style="line-height: 40px;">
                            <p style="font-size: 17px;">
                                ✔ Bảo hành chính hãng 12 tháng.
                            </p>
                            <p style="font-size: 17px;">
                                ✔ Hỗ trợ đổi mới trong 7 ngày.
                            </p>
                            <p style="font-size: 17px;">
                                ✔ Windows bản quyền tích hợp.
                            </p>
                            <p style="font-size: 17px;">
                                ✔ Miễn phí giao hàng toàn quốc.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="container" style="margin-top: 20px;">
                    <div class="col-md-9 bor" style="padding: 20px">
                        <h4>Thông tin sản phẩm</h4>
                        <h3 style="font-weight: bold; margin-top: 10px; margin-bottom: 10px;">Thông số kỹ thuật</h3>
                        <table style="border: 1px solid #F7F7F7; border-collapse: collapse; width: 100%; table-layout: fixed;">
                            <tr style="padding: 40px">
                                <td style="font-weight: bold; background-color: #F7F7F7; font-size: 16px; width: 20%;">CPU</td>
                                <td style="font-size: 16px; word-wrap: break-word; width: 80%; padding: 10px"><?php echo $row["CPU"] ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold; background-color: #F7F7F7; font-size: 16px; width: 20%;">RAM</td>
                                <td style="font-size: 16px; word-wrap: break-word; width: 80%; padding: 10px"><?php echo $row["Ram"] ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold; background-color: #F7F7F7; font-size: 16px; width: 20%;">Ổ cứng</td>
                                <td style="font-size: 16px; word-wrap: break-word; width: 80%; padding: 10px"><?php echo $row["OCung"] ?></td>
                            </tr>
                            <tr>
                                <th style="font-weight: bold; background-color: #F7F7F7; font-size: 16px; width: 20%;">VGA</th>
                                <td style="font-size: 16px; word-wrap: break-word; width: 80%; padding: 10px"><?php echo $row["VGA"] ?></td>
                            </tr>
                            <tr>
                                <th style="font-weight: bold; background-color: #F7F7F7; font-size: 16px; width: 20%;">Màn hình</th>
                                <td style="font-size: 16px; word-wrap: break-word; width: 80%; padding: 10px"><?php echo $row["ManHinh"] ?></td>
                            </tr>
                            <tr>
                                <th style="font-weight: bold; background-color: #F7F7F7; font-size: 16px; width: 20%;">Hệ điều hành</th>
                                <td style="font-size: 16px; word-wrap: break-word; width: 80%; padding: 10px"><?php echo $row["HeDieuHanh"] ?></td>
                            </tr>
                            <tr>
                                <th style="font-weight: bold; background-color: #F7F7F7; font-size: 16px; width: 20%;">Pin</th>
                                <td style="font-size: 16px; word-wrap: break-word; width: 80%; padding: 10px"><?php echo $row["Pin"] ?></td>
                            </tr>
                            <tr>
                                <th style="font-weight: bold; background-color: #F7F7F7; font-size: 16px; width: 20%;">Trọng lượng</th>
                                <td style="font-size: 16px; word-wrap: break-word; width: 80%; padding: 10px"><?php echo $row["TrongLuong"] ?></td>
                            </tr>
                        </table>
                        <h3 style="font-weight: bold; margin-top: 10px; margin-bottom: 10px;">Đánh giá chi tiết <?php echo $row["TenSanPham"] ?></h3>
                        <p style="font-size: 16px; word-wrap: break-word;"><?php echo $row["MoTa"] ?></p>
                    </div>
                <?php
            }
                ?>
                <div class="col-md-3 bor" style="word-wrap: break-word; padding: 20px;">
                    <h4>Sản phẩm tương tự</h4>
                    <?php
                    include("ShowProductSmiliar.php");
                    ?>
                </div>
                </div>

        </div>
    </div>
    <script src="js/slick.min.js"></script>
    <?php
    include("layout/footer.php");
    ?>
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