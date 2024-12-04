<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh toán</title>
    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <script src="assets/js/jquery-3.2.1.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="assets/css/slick.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/slick-theme.css" />

    <!--  -->
    <link rel="stylesheet" type="text/css" href="assets/css/Layout/style_header.css">
    <link rel="stylesheet" type="text/css" href="assets/css/Layout/style_footer.css">
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
            width: 80%;
            max-width: 500px;
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
        ob_start();
        include_once '../core/Connection.php';
        session_start();
            
        $sql_magiohang = "SELECT MaGioHang FROM GIOHANG WHERE MaTaiKhoan = :mataikhoan";
        $stmt_magiohang = $pdo->prepare($sql_magiohang);
        $stmt_magiohang->execute(['mataikhoan' => $_SESSION["mataikhoan"]]);
        $result = $stmt_magiohang->fetch(PDO::FETCH_ASSOC);

        $magiohang = $result['MaGioHang'];

        $sql_load = "SELECT CHITIETGIOHANG.MASANPHAM, SANPHAM.TENSANPHAM, SANPHAM.HINHANH, SANPHAM.GIABAN, CHITIETGIOHANG.SOLUONG, CHITIETGIOHANG.THANHTIEN, SANPHAM.SOLUONG AS SANPHAM_SOLUONG 
        FROM CHITIETGIOHANG 
        JOIN SANPHAM ON CHITIETGIOHANG.MASANPHAM = SANPHAM.MASANPHAM 
        WHERE CHITIETGIOHANG.MAGIOHANG = :magiohang";
        $st_load = $pdo->prepare($sql_load);
        $st_load->execute(['magiohang' => $magiohang]);
        $chitietgiohang1 = $st_load->fetchAll(PDO::FETCH_OBJ);

        function showTongTien($chitietgiohang) 
        {
            $total_price = 0;
            foreach($chitietgiohang as $row) 
            {
                $total_price += $row->THANHTIEN; 
            }
            return $total_price;
        }

        function updateSLTon($chitietgiohang, $pdo) {
            foreach($chitietgiohang as $item) {
                $updateSLTon = "UPDATE SANPHAM SET SoLuong = SoLuong - :soluong WHERE MaSanPham = :masp";
                $st_updateSL = $pdo->prepare($updateSLTon);
                $st_updateSL->execute([
                    'soluong' => $item->SOLUONG,
                    'masp' => $item->MASANPHAM
                ]);
            }
        }

        $tb = null;

        if (isset($_POST["btn_thanhtoan"])) 
        {
            $magiohang = $_POST["magiohang"];

            // Lấy chi tiết giỏ hàng
            $sql = "SELECT CHITIETGIOHANG.MASANPHAM, SANPHAM.TENSANPHAM, SANPHAM.HINHANH, SANPHAM.GIABAN, CHITIETGIOHANG.SOLUONG, CHITIETGIOHANG.THANHTIEN, SANPHAM.SOLUONG AS SANPHAM_SOLUONG 
                    FROM CHITIETGIOHANG 
                    JOIN SANPHAM ON CHITIETGIOHANG.MASANPHAM = SANPHAM.MASANPHAM 
                    WHERE CHITIETGIOHANG.MAGIOHANG = :magiohang";
            $st1 = $pdo->prepare($sql);
            $st1->execute(['magiohang' => $magiohang]);
            $chitietgiohang = $st1->fetchAll(PDO::FETCH_OBJ);

            // Lấy lựa chọn thanh toán
            $selected_option = $_POST["choices"];
            if ($selected_option == 1) {
                $selected_option = "Thanh toán khi nhận hàng";
            } else {
                $selected_option = "Chuyển khoản ngân hàng";
            }

            $diachi = $_POST["addrs"];
            $sdt = $_POST["phone"];

            // Kiểm tra số điện thoại hợp lệ
            if (!preg_match('/^0\d{9}$/', $sdt)) {
                $tb = "Vui lòng kiểm tra lại SĐT";
            } 
            else 
            {
                // Lưu thông tin hóa đơn
                $sql_inserthd = "INSERT INTO HOADON (MaTaiKhoan, NgayMua, DiaChi, SDT, HinhThucThanhToan, TongTien, TrangThai) 
                                VALUES (:matk, GETDATE(), :diachi, :sdt, :hinhthuc, :tongtien, :trangthai)";
                $st_inserthd = $pdo->prepare($sql_inserthd);
                $st_inserthd->execute([
                    'matk' => $_SESSION["mataikhoan"],
                    'diachi' => $diachi,
                    'sdt' => $sdt,
                    'hinhthuc' => $selected_option,
                    'tongtien' => showTongTien($chitietgiohang) + 100000,
                    'trangthai' => 'Chưa xác nhận'
                ]);
                
                $mahd = $pdo->lastInsertId();

                // Lưu chi tiết hóa đơn
                foreach ($chitietgiohang as $row) {
                    $sql_insertcthd = "INSERT INTO chitiethoadon (MaHoaDon, MaSanPham, SoLuong, ThanhTien) 
                                    VALUES (:mahd, :masp, :soluong, :thanhtien)";
                    $st_insertcthd = $pdo->prepare($sql_insertcthd);
                    $st_insertcthd->execute([
                        'mahd' => $mahd,
                        'masp' => $row->MASANPHAM,
                        'soluong' => $row->SOLUONG,
                        'thanhtien' => $row->THANHTIEN
                    ]);
                }

                // Cập nhật số lượng sản phẩm tồn kho
                updateSLTon($chitietgiohang, $pdo);

                // Xóa sản phẩm trong giỏ hàng
                $sql_deleteAllitem = "DELETE FROM CHITIETGIOHANG WHERE MAGIOHANG = :magiohang";
                $st_deleteAllitem = $pdo->prepare($sql_deleteAllitem);
                $st_deleteAllitem->execute(['magiohang' => $magiohang]);

                // Nếu chọn "Chuyển khoản ngân hàng", điều hướng tới VNPAY
                if ($selected_option == "Chuyển khoản ngân hàng") {
                    // Các tham số yêu cầu cho thanh toán VNPAY
                    $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
                    $vnp_Returnurl = "http://localhost/Laptop-Web/user/index.php";
                    $vnp_TmnCode = "262XSFHX"; // Mã website tại VNPAY
                    $vnp_HashSecret = "MMZXWISZNUUUNKGOZQPCPASLLTHYGMTB"; // Chuỗi bí mật

                    $vnp_TxnRef = $mahd; // Mã đơn hàng (hoặc ID hóa đơn trong cơ sở dữ liệu)
                    $vnp_OrderInfo = "Thanh toán hóa đơn #" . $mahd;
                    $vnp_Amount = (showTongTien($chitietgiohang) + 100000) * 100; // Số tiền thanh toán, tính bằng đồng
                    $vnp_Locale = "vn"; // Ngôn ngữ
                    $vnp_BankCode = "NCB"; // Mã ngân hàng, nếu có
                    $vnp_IpAddr = $_SERVER['REMOTE_ADDR']; // Địa chỉ IP người dùng

                    // Tạo dữ liệu để gửi đến VNPAY
                    $inputData = [
                        "vnp_Version" => "2.1.0",
                        "vnp_TmnCode" => $vnp_TmnCode,
                        "vnp_Amount" => $vnp_Amount,
                        "vnp_Command" => "pay",
                        "vnp_CreateDate" => date('YmdHis'),
                        "vnp_CurrCode" => "VND",
                        "vnp_IpAddr" => $vnp_IpAddr,
                        "vnp_Locale" => $vnp_Locale,
                        "vnp_OrderInfo" => $vnp_OrderInfo,
                        "vnp_OrderType" => "Thanh toán hóa đơn",
                        "vnp_ReturnUrl" => $vnp_Returnurl,
                        "vnp_TxnRef" => $vnp_TxnRef,
                    ];

                    if (isset($vnp_BankCode)) {
                        $inputData['vnp_BankCode'] = $vnp_BankCode;
                    }

                    // Sắp xếp các tham số theo thứ tự và tạo chuỗi tham số
                    ksort($inputData);
                    $query = "";
                    $hashdata = "";
                    foreach ($inputData as $key => $value) {
                        $hashdata .= $query ? '&' . urlencode($key) . "=" . urlencode($value) : urlencode($key) . "=" . urlencode($value);
                        $query .= urlencode($key) . "=" . urlencode($value) . '&';
                    }

                    // Tạo chuỗi hash bảo mật
                    $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
                    $vnp_Url .= "?" . $query . 'vnp_SecureHash=' . $vnpSecureHash;

                    // Chuyển hướng đến VNPAY
                    header("Location: $vnp_Url");
                    exit();
                }

                ?>
                <div class="alert">
                    <p style="font-size: 25px;">Thông báo</p>
                    <p style="font-size: 18px; color:white">Đặt hàng thành công.</p>
                </div>
                <script>
                    setTimeout(function() {
                        window.location.href = "index.php";
                    }, 2000);
                </script>
            <?php
                exit();
            }
        }


        include("layout/header.php");

        function showGioHangCheckOut($chitietgiohang1)
        {   
            foreach($chitietgiohang1 as $row)
            {
                echo '<li class="list-group-item">
                        <div class="d-flex justify-content-between align-items-center" style="width: 100%">
                            <p style="font-size: 14px; display: inline-block; width: 65%; word-break: break-all;">'. $row->TENSANPHAM .'</p>
                            <p style="display: inline-block; width: 34%; text-align: right;"><span style="font-size: 14px;" class="badge text-secondary rounded-pill">'. number_format($row->THANHTIEN, 0, ',', '.') .'đ</span></p>
                        </div>
                        <p style="font-size: 13px; margin: 0;">Số lượng: '. $row->SOLUONG .' x Đơn giá: '. number_format($row->GIABAN, 0, ',', '.') .'đ</p>
                    </li>'; 
            }
        }

    ?>
    <main id="maincontent">
        <div class="container">
            <div class="col-md-7 bor">
                <section class="box-main1">
                    <h3 class="title-main" style="text-align: center;"><a href="javascript:void(0)"> Thanh toán </a> </h3>
                    <p style="font-size: 20px; margin-top: 20px; margin-bottom: 20px;">Địa chỉ đơn hàng</p>
                    <form method="post" action="CheckOut.php">
                        <input type="hidden" name="magiohang" value="<?php echo $magiohang ?>">
                        <label style="font-size: 16px; font-weight: normal;" for="addrs" style="margin-top: 20px;">Địa chỉ</label><br>
                        <input class="form-control" placeholder="Địa chỉ" type="text" name="addrs" id="addrs" required><br>
                        <label style="font-size: 16px; font-weight: normal;" for="phone" style="margin-top: 20px;">Số điện thoại</label><br>
                        <input class="form-control" placeholder="Số điện thoại" type="number" name="phone" id="phone" required>
                        <?php
                            if (!empty($tb))
                            {
                            ?>
                                <p style="color: red; font-weight: bold; font-size: 13px; margin-top: 5px;"><?php echo $tb ?></p>
                            <?php
                            }
                        ?>
                        <br>
                        <label style="font-size: 16px; font-weight: normal;" for="choices">Phương thức thanh toán</label><br>
                        <select style="width: 400px; height: 30px; font-size: 16px;" id="choices" name="choices" class="form-select" aria-label="Default select example">
                            <option style="font-size: 16px;" selected value="1">Thanh toán khi nhận hàng</option>
                            <option style="font-size: 16px;" value="2">Chuyển khoản ngân hàng</option>
                        </select>
                        <hr>
                        <button style="margin-top: 20px; margin-bottom: 20px; width: 100%;" class="btn btn-danger" name="btn_thanhtoan" value="btn_thanhtoan">Đặt Hàng</button>
                    </form>
                </section>
            </div>
            <div class="col-md-5">
                <p style="font-size: 20px; float: left;">Giỏ hàng</p>
                <span style="float: right; width: 30px; text-align: center; border-radius: 20px; background-color: grey; color: white; font-weight: bold; font-size: 14px;"><?php echo count($chitietgiohang1) ?></span>
                <ul style="clear: both;" class="list-group">
                    <?php showGioHangCheckOut($chitietgiohang1) ?>
                    <li style="font-size: 15px;" class="list-group-item d-flex justify-content-between align-items-center">
                        <p style="font-size: 15px; display: inline-block; width: 30%;">Tổng tiền hàng</p>
                        <p style="display: inline-block; width: 69%; text-align: right;"><span style="font-size: 15px;"><?php echo number_format(showTongTien($chitietgiohang1), 0, ',', '.') ?>đ</span></p>
                        <p style="font-size: 15px; display: inline-block; width: 30%;">Phí vận chuyển</p>
                        <p style="display: inline-block; width: 69%; text-align: right;"><span style="font-size: 15px;">100.000đ</span></p>
                        <p style="font-size: 15px; display: inline-block; width: 30%;">Tổng thanh toán</p>
                        <p style="display: inline-block; width: 69%; text-align: right;"><span style="font-size: 20px;" class="price"><?php echo number_format(showTongTien($chitietgiohang1) + 100000, 0, ',', '.') ?>đ</span></p>
                    </li>
                </ul>
            </div>
        </div>
    </main>
    <?php 
        include("layout/footer.php");
    ?>
</body>
</html>