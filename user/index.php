<?php include('home.php') ?>
<?php
// Kiểm tra kết quả trả về từ VNPAY
if (isset($_GET['vnp_ResponseCode']) && $_GET['vnp_ResponseCode'] == '00') {
    // Thanh toán thành công
    echo '
    <div class="alert">
        <p style="font-size: 25px;">Thông báo</p>
        <p style="font-size: 18px; color:white">Đặt hàng thành công.</p>
    </div>';
} else {
    // Thanh toán không thành công
    echo '
    <div class="alert">
        <p style="font-size: 25px;">Thông báo</p>
        <p style="font-size: 18px; color:white">Thanh toán không thành công. Vui lòng thử lại.</p>
    </div>';
}
?>
