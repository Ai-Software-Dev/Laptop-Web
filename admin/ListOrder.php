<?php
   ob_start();
    include('includes/header.php');
?>

<div>
    <?php
    include_once '../core/Connection.php';

    $sql = "SELECT hoadon.MaHoaDon, user.TenKhachHang, hoadon.DiaChi, user.Email, hoadon.HinhThucThanhToan, hoadon.TongTien, hoadon.TrangThai FROM hoadon JOIN user ON hoadon.MaTaiKhoan = user.MaTaiKhoan";
    $st = $pdo->prepare($sql);
    $st->execute();

    if ($st->rowCount()) {
        $donhang = $st->fetchAll(PDO::FETCH_OBJ);
    }
    ?>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Danh sách đơn hàng</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Mã đơn hàng</th>
                            <th>Tên khách hàng</th>
                            <th>Địa chỉ</th>
                            <th>Email</th>
                            <th>Hình thức thanh toán</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                            <th>Xác nhận</th>
                            <th>Chi tiết</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Mã đơn hàng</th>
                            <th>Tên khách hàng</th>
                            <th>Địa chỉ</th>
                            <th>Email</th>
                            <th>Hình thức thanh toán</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                            <th>Xác nhận</th>
                            <th>Chi tiết</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php
                        foreach ($donhang as $dh) { ?>
                            <tr>
                                <td><?php echo $dh->MaHoaDon ?></td>
                                <td><?php echo $dh->TenKhachHang ?></td>
                                <td><?php echo $dh->DiaChi ?></td>
                                <td><?php echo $dh->Email ?></td>
                                <td><?php echo $dh->HinhThucThanhToan ?></td>
                                <td><?php echo number_format($dh->TongTien, 0, ',', '.') ?>₫</td>
                                <td><?php echo $dh->TrangThai ?></td>
                                <td><a href="#" class="confirm-order" data-id="<?php echo $dh->MaHoaDon ?>">Xác nhận</a></td>
                                <td><a href="DetailOrder.php?id=<?php  echo $dh->MaHoaDon ?>">Chi tiết</a></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
include('includes/footer.php');
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
    $('a.confirm-order').on('click', function(e) {
        e.preventDefault();

        var maHoaDon = $(this).data('id');
        var link = $(this);

        $.ajax({
            type: 'POST',
            url: 'confirm_order.php',
            data: {
                ma_hoa_don: maHoaDon
            },
            success: function(response) {
                if (response === 'success') {
                    link.closest('tr').find('td:eq(6)').text('Đã xác nhận');
                    alert('Đã xác nhận đơn hàng!');
                    
                    // Chuyển hướng người dùng đến trang send_email.php
                    window.location.href = 'send_email.php?id=' + maHoaDon;
                } else {
                    alert('Có lỗi xảy ra. Vui lòng thử lại sau.');
                }
            },
            error: function() {
                alert('Có lỗi xảy ra. Vui lòng thử lại sau.');
            }
        });
    });
});

</script>
