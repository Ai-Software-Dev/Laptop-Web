<?php
ob_start();
include('includes/header.php');
?>
<div>
    <?php
    include_once '../core/Connection.php';

    // Lấy dữ liệu từ bảng hang
    $sql = "SELECT * FROM hang";
    $st = $pdo->prepare($sql);
    $st->execute();

    // Lấy tất cả dữ liệu và kiểm tra nếu có dữ liệu
    $hangsp = $st->fetchAll(PDO::FETCH_OBJ);

    // Xử lý xóa thương hiệu
    if (isset($_POST["delete"])) {
        $mahang = $_POST["mahang"];
        $sqldel = "DELETE FROM hang WHERE MaHang = :mahang";
        $stdel = $pdo->prepare($sqldel);
        $stdel->execute([':mahang' => $mahang]);

        header("Location: ListBrands.php");
        exit();
    }
    ?>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Danh sách thương hiệu</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên hãng</th>
                            <th>Logo</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        // Kiểm tra nếu có dữ liệu trong $hangsp
                        if (!empty($hangsp)) {
                            foreach ($hangsp as $hsp) { ?>
                            <tr style="line-height: 80px">
                                <td><?php echo $hsp->MaHang ?></td>
                                <td><?php echo $hsp->TenHang ?></td>
                                <td>
                                    <img src="../public/images/logo/<?php echo $hsp->Logo ?>" alt="<?php echo $hsp->Logo ?>" style="height: 50px; width: auto;">
                                </td>
                                <td>
                                    <a href="UpdateBrands.php?id=<?php echo $hsp->MaHang ?>" class="btn btn-primary">Chỉnh sửa</a>
                                    <strong>|</strong>
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal" data-mahang="<?php echo $hsp->MaHang; ?>">Xóa</button>
                                </td>
                            </tr>
                        <?php 
                            }
                        } else { ?>
                            <tr>
                                <td colspan="4">Không có thương hiệu nào.</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal xác nhận xóa -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalLabel">Xác nhận xóa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Bạn có chắc chắn muốn xóa thương hiệu này không?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <form id="deleteForm" action="ListBrands.php" method="post">
                    <input type="hidden" name="mahang" id="mahangToDelete">
                    <button type="submit" class="btn btn-danger" name="delete">Xóa</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>

<!-- JavaScript để xử lý modal -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var deleteModal = document.getElementById('confirmDeleteModal');
        deleteModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            var mahang = button.getAttribute('data-mahang');
            var input = deleteModal.querySelector('#mahangToDelete');
            input.value = mahang;
        });
    });
</script>