<?php
ob_start();
include('includes/header.php');
?>


<div>
    <?php
   include_once '../core/Connection.php';

    if(isset($_GET['id'])) {
        $mahoadon = $_GET['id'];
        $sql = "SELECT chitiethoadon.MaHoaDon, sanpham.TenSanPham, chitiethoadon.SoLuong, chitiethoadon.ThanhTien FROM chitiethoadon JOIN sanpham ON chitiethoadon.MaSanPham = sanpham.MaSanPham WHERE chitiethoadon.MaHoaDon = $mahoadon";
        $st = $pdo->prepare($sql);
        $st->execute();
    }
    

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
                            <th>STT</th>
                            <th>Mã đơn hàng</th>
                            <th>Tên sản phẩm</th>
                            <th>Số lượng</th>
                            <th>Thành tiền</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        <?php
                        $stt = 0;
                        $tongsl = 0;
                        $tongthanhtien = 0;
                        foreach ($donhang as $dh) { 
                            $stt++;
                            $tongsl += $dh->SoLuong;
                            $tongthanhtien += $dh->ThanhTien;
                        ?>
                            <tr>
                                <td><?php echo $stt ?></td>
                                <td><?php echo $dh->MaHoaDon ?></td>
                                <td><?php echo $dh->TenSanPham ?></td>
                                <td><?php echo $dh->SoLuong ?></td>
                                <td><?php echo number_format($dh->ThanhTien, 0, ',', '.') ?>₫</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                    
                    <tfoot>
                        <tr>
                            <th colspan="3" style="text-align: center;">Tổng</th>
                            <th><?php echo $tongsl ?></th>
                            <th><?php echo number_format($tongthanhtien, 0, ',', '.') ?>₫</th>
                        </tr>
                    </tfoot>
                </table>
                <a href="GeneratePDF.php?id=<?php echo $dh->MaHoaDon ?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                    <i class="fas fa-download fa-sm text-white-50"></i> In hóa đơn</a>
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
                        link.closest('tr').find('td:eq(4)').text('Đã xác nhận');
                        alert('Đã xác nhận đơn hàng!');
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
