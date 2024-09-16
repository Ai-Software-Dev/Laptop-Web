<!DOCTYPE html>
<html>
<head>
    <title>Giỏ hàng</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <script src="assets/js/jquery-3.2.1.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="assets/css/slick.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/slick-theme.css" />

    <!-- style -->
    <link rel="stylesheet" type="text/css" href="assets/css/Layout/style_header.css">
    <link rel="stylesheet" type="text/css" href="assets/css/Layout/style_footer.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="assets/css/Cart/style_cart.css">

    <style>
            button[name="btn_decrease"] {
                width: 25px;
                height: 25px;
                font-size: 30px;  /* Điều chỉnh kích thước font lên 30px */
                line-height: 25px;
                color: white;
                background-color: gray;
                border: none;
                border-radius: 50%;
                text-align: center;
                padding: 0;
                margin: 0;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                vertical-align: middle;
            }
            button[name="btn_increase"] {
                width: 25px;
                height: 25px;
                font-size: 20px;  /* Điều chỉnh kích thước font lên 30px */
                line-height: 25px;
                color: white;
                background-color: gray;
                border: none;
                border-radius: 50%;
                text-align: center;
                padding: 0;
                margin: 0;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                vertical-align: middle;
            }
            .alert {
                padding: 20px;
                background-color: #f44336;
                color: white;
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                z-index: 99999; /* Ensure it is above all other elements */
                width: 80%; /* Optional: Adjust width as needed */
                max-width: 500px; /* Optional: Set a max-width */
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

    // Get the MaGioHang for the current user
    $sql_magiohang = "SELECT MaGioHang FROM GIOHANG WHERE MaTaiKhoan = :mataikhoan";
    $stmt_magiohang = $pdo->prepare($sql_magiohang);
    $stmt_magiohang->execute(['mataikhoan' => $_SESSION["mataikhoan"]]);
    $result = $stmt_magiohang->fetch(PDO::FETCH_ASSOC);
    $magiohang = $result['MaGioHang'];

    // Load cart details
    $sql = "SELECT CHITIETGIOHANG.MASANPHAM, SANPHAM.TENSANPHAM, SANPHAM.HINHANH, SANPHAM.GIABAN, CHITIETGIOHANG.SOLUONG, CHITIETGIOHANG.THANHTIEN, SANPHAM.SOLUONG AS SANPHAM_SOLUONG 
            FROM CHITIETGIOHANG 
            JOIN SANPHAM ON CHITIETGIOHANG.MASANPHAM = SANPHAM.MASANPHAM 
            WHERE CHITIETGIOHANG.MAGIOHANG = :magiohang";
    $st1 = $pdo->prepare($sql);
    $st1->execute(['magiohang' => $magiohang]);
    $chitietgiohang = $st1->fetchAll(PDO::FETCH_OBJ);

    // Delete items with zero quantity
    foreach ($chitietgiohang as $row) {
        if ($row->SANPHAM_SOLUONG == 0) {
            $sql_delete = "DELETE FROM CHITIETGIOHANG WHERE MaGioHang = :magiohang AND MaSanPham = :masp";
            $stmt_delete = $pdo->prepare($sql_delete);
            $stmt_delete->execute(['magiohang' => $magiohang, 'masp' => $row->MASANPHAM]);
        }
    }

    // Reload cart details after deletion
    $st1->execute(['magiohang' => $magiohang]);
    $chitietgiohang = $st1->fetchAll(PDO::FETCH_OBJ);

    if (isset($_POST["btn_increase"]))
    {
        $masp = $_POST["masp"];
        $sl = $_POST["sl"];
        $sl += 1;

        $sql_get_stock = "SELECT SoLuong FROM SANPHAM WHERE MaSanPham = :masp";
        $stmt_get_stock = $pdo->prepare($sql_get_stock);
        $stmt_get_stock->execute(['masp' => $masp]);
        $product_stock = $stmt_get_stock->fetch(PDO::FETCH_ASSOC)['SoLuong'];

        $sql_get_giaban = "SELECT GiaBan FROM SANPHAM WHERE MASANPHAM = :masp";
        $st_get_giaban = $pdo->prepare($sql_get_giaban);
        $st_get_giaban->execute([
            'masp' => $masp
        ]);
        $giaban_product = $st_get_giaban->fetch(PDO::FETCH_ASSOC)["GiaBan"];

        if ($sl <= $product_stock)
        {
            $sql_update_CTGH = "UPDATE CHITIETGIOHANG SET SOLUONG = :soluong, THANHTIEN = :thanhtien WHERE MAGIOHANG = :magiohang AND MASANPHAM = :masp";
            $st_updateCTGH = $pdo->prepare($sql_update_CTGH);
            $st_updateCTGH->execute([
                'soluong' => $sl,
                'thanhtien' => $sl * $giaban_product,
                'magiohang' => $magiohang,
                'masp' => $masp
            ]);
        }
        else if ($sl > $product_stock)
        {
            $sql_update_CTGH = "UPDATE CHITIETGIOHANG SET SOLUONG = :soluong, THANHTIEN = :thanhtien WHERE MAGIOHANG = :magiohang AND MASANPHAM = :masp";
            $st_updateCTGH = $pdo->prepare($sql_update_CTGH);
            $st_updateCTGH->execute([
                'soluong' => 1,
                'thanhtien' => 1 * $giaban_product,
                'magiohang' => $magiohang,
                'masp' => $masp
            ]);
        }
        // Load lại thông tin chi tiết giỏ hàng sau khi cập nhật
        $st1->execute(['magiohang' => $magiohang]);
        $chitietgiohang = $st1->fetchAll(PDO::FETCH_OBJ);
    }
    if (isset($_POST["btn_decrease"]))
    {
        $masp = $_POST["masp"];
        $sl = $_POST["sl"];
        $sl -= 1;

        
        $sql_get_stock = "SELECT SoLuong FROM SANPHAM WHERE MaSanPham = :masp";
        $stmt_get_stock = $pdo->prepare($sql_get_stock);
        $stmt_get_stock->execute(['masp' => $masp]);
        $product_stock = $stmt_get_stock->fetch(PDO::FETCH_ASSOC)['SoLuong'];

        $sql_get_giaban = "SELECT GiaBan FROM SANPHAM WHERE MASANPHAM = :masp";
        $st_get_giaban = $pdo->prepare($sql_get_giaban);
        $st_get_giaban->execute([
            'masp' => $masp
        ]);
        $giaban_product = $st_get_giaban->fetch(PDO::FETCH_ASSOC)["GiaBan"];

        if ($sl > 0)
        {
            if ($sl > $product_stock)
            {
                $sql_update_CTGH = "UPDATE CHITIETGIOHANG SET SOLUONG = :soluong, THANHTIEN = :thanhtien WHERE MAGIOHANG = :magiohang AND MASANPHAM = :masp";
                $st_updateCTGH = $pdo->prepare($sql_update_CTGH);
                $st_updateCTGH->execute([
                    'soluong' => 1,
                    'thanhtien' => 1 * $giaban_product,
                    'magiohang' => $magiohang,
                    'masp' => $masp
                ]);
            }
            else
            {
                $sql_update_CTGH = "UPDATE CHITIETGIOHANG SET SOLUONG = :soluong, THANHTIEN = :thanhtien WHERE MAGIOHANG = :magiohang AND MASANPHAM = :masp";
                $st_updateCTGH = $pdo->prepare($sql_update_CTGH);
                $st_updateCTGH->execute([
                    'soluong' => $sl,
                    'thanhtien' => $sl * $giaban_product,
                    'magiohang' => $magiohang,
                    'masp' => $masp
                ]);
            }
        }
        // Load lại thông tin chi tiết giỏ hàng sau khi cập nhật
        $st1->execute(['magiohang' => $magiohang]);
        $chitietgiohang = $st1->fetchAll(PDO::FETCH_OBJ);
    }

    if (isset($_GET["DeleteItem"]))
    {
        $masp = (int)$_GET["DeleteItem"];

        $sql_deleteitem = "DELETE FROM CHITIETGIOHANG WHERE MASANPHAM = :masp";
        $st_deleteitem = $pdo->prepare($sql_deleteitem);
        $st_deleteitem->execute([
            'masp' => $masp
        ]);
        // Load lại thông tin chi tiết giỏ hàng sau khi cập nhật
        $st1->execute(['magiohang' => $magiohang]);
        $chitietgiohang = $st1->fetchAll(PDO::FETCH_OBJ);
    }
    if (isset($_GET["DeleteAll"]))
    {
        $sql_deleteAllitem = "DELETE FROM CHITIETGIOHANG WHERE MAGIOHANG = :magiohang";
        $st_deleteAllitem = $pdo->prepare($sql_deleteAllitem);
        $st_deleteAllitem->execute([
            'magiohang' => $magiohang
        ]);
        // Load lại thông tin chi tiết giỏ hàng sau khi cập nhật
        $st1->execute(['magiohang' => $magiohang]);
        $chitietgiohang = $st1->fetchAll(PDO::FETCH_OBJ);
    }
    if (isset($_GET["MuaHang"]))
    {
        foreach($chitietgiohang as $row)
        {
            $sql_get_stock = "SELECT SoLuong FROM SANPHAM WHERE MaSanPham = :masp";
            $stmt_get_stock = $pdo->prepare($sql_get_stock);
            $stmt_get_stock->execute(['masp' => $row->MASANPHAM]);
            $product_stock = $stmt_get_stock->fetch(PDO::FETCH_ASSOC)['SoLuong'];
            if ($row->SOLUONG > $product_stock)
            {
            ?>
                <div class="alert">
                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                    <p style="font-size: 25px;">Thông báo</p>
                    <p style="font-size: 18px; color:white">Số lượng vượt quá số lượng sản phẩm có sẵn.</p>
                </div>
            <?php
                break;
            }
            else
            {
                header("Location: CheckOut.php");
                exit();
            }
        }
    }
    function showTongTien($chitietgiohang)
    {
        $total_price = 0;
        foreach($chitietgiohang as $row) 
        {
            $total_price += $row->THANHTIEN; 
        }
        return number_format($total_price, 0, ',', '.');
    }
    ?>
        
    <div id="maincontent">
        <div class="container">
            <div class="col-md-12 bor">
                <section class="box-main1">
                    <h3 class="title-main" style="text-align: center;"><a href="javascript:void(0)"> Giỏ hàng </a> </h3>
                    <?php
                        if (count($chitietgiohang) > 0)
                        {
                    ?>
                            <table class="table">
                                <tr>
                                    <td style="font-size: 16px;">Sản Phẩm</td>
                                    <td style="font-size: 16px;">Đơn Giá</td>
                                    <td style="font-size: 16px;">Số Lượng</td>
                                    <td style="font-size: 16px;">Số Tiền</td>
                                    <td style="font-size: 16px;">Thao Tác</td>
                                </tr>
                                <?php
                                    foreach($chitietgiohang as $row)
                                    {
                                ?>
                                        <tr>
                                            <td style="word-break: break-all; vertical-align: middle;">
                                                <a style="font-size: 16px;" href="ShowDetail.php?id=<?php echo $row->MASANPHAM ?>">
                                                    <img src="../public/images/products/<?php echo $row->HINHANH ?>" width="60" height="60">
                                                    <?php echo $row->TENSANPHAM ?>
                                                </a>
                                            </td>
                                            <td style="font-size: 16px; vertical-align: middle;"><?php echo number_format($row->GIABAN, 0, ',', '.') ?>đ</td>
                                            <td style="font-size: 16px; vertical-align: middle;">
                                                <form style="font-size: 16px;" method="post" action="ShowCart.php">
                                                    <input type="hidden" name="masp" value="<?php echo $row->MASANPHAM ?>">
                                                    <input type="hidden" name="sl" value="<?php echo $row->SOLUONG ?>">
                                                    <button name="btn_decrease" value="btn_decrease">-</button>
                                                    &nbsp;<?php echo $row->SOLUONG ?>&nbsp;
                                                    <button name="btn_increase" value="btn_increase">+</button>
                                                </form>
                                            </td>
                                            <td style="font-size: 16px; vertical-align: middle;" class="price"><?php echo number_format($row->THANHTIEN, 0, ',', '.') ?>đ</td>
                                            <td style="vertical-align: middle;"><a style="font-size: 16px;" href="ShowCart.php?DeleteItem=<?php echo $row->MASANPHAM ?>">Xóa</a></td>
                                        </tr>
                                <?php
                                    }
                                ?>
                                <tr>
                                    <td colspan="5">
                                        <a style="font-size: 16px;" href="ShowCart.php?DeleteAll=1">Xóa tất cả</a>
                                    </td>
                                </tr>
                            </table>
                    <?php
                        }
                        else
                        {
                    ?>
                            <h4 style="height: 500px; text-align: center; margin-top: 25px; color: red; font-weight: bold;">Giỏ hàng của bạn đang rỗng</h4>
                    <?php
                        }
                    ?>
                </section>
            </div>
        </div>
        <?php
            if (count($chitietgiohang) > 0)
            {
        ?>
                <div class="container" style="margin-top: 20px">
                    <div class="col-md-7">
                        
                    </div>
                    <div class="col-md-5 bor">
                        <div style="width: 100%; margin-bottom: 10px; margin-top: 10px;">
                            <p style="display: inline-block; font-size: 16px; width: 55%;">
                                Tổng thanh toán (<?php echo count($chitietgiohang) ?> sản phẩm): 
                            </p>
                            <p style="display: inline-block; font-size: 20px; text-align: right; width: 40%;" class="price">
                                    <?php echo showTongTien($chitietgiohang); ?>đ
                            </p>
                        </div>
                        <a href="ShowCart.php?MuaHang=1">
                            <button style="width: 100%;" class="btn btn-danger">Mua Hàng</button>
                        </a>
                    </div>
                </div>
        <?php
            }
        ?>
    </div>
    <?php
        include('layout/footer.php');
    ?>   
</body>
</html>