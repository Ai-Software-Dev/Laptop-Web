<?php
   ob_start();
   include('includes/header.php');
   ?>
<div>
   <?php
      include_once '../core/Connection.php';
      
      if (isset($_GET['txtSearch']) && !empty($_GET['txtSearch'])) {
         $keyword = $_GET['txtSearch'];
         $sql = "SELECT * FROM sanpham JOIN hang ON sanpham.MaHang = hang.MaHang WHERE TenSanPham LIKE '%$keyword%'";
         $st = $pdo->prepare($sql);
         $st->execute();
      } else {
         $sql = "SELECT * FROM sanpham JOIN hang ON sanpham.MaHang = hang.MaHang";
         $st = $pdo->prepare($sql);
         $st->execute();
      }
      
      
      if ($st->rowCount()) {
          $sanpham = $st->fetchAll(PDO::FETCH_OBJ);
      }
      
      if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['maSanPham'])) {
          $maSanPham = $_POST['maSanPham'];
          $sqldel = "DELETE FROM sanpham WHERE MaSanPham = :maSanPham";
          $stmt = $pdo->prepare($sqldel);
          $stmt->execute([':maSanPham' => $maSanPham]);
      
          header('Location: ListProducts.php');
          exit;
      }
      ?>
   <div class="card shadow mb-4">
      <div class="card-header py-3">
         <h6 class="m-0 font-weight-bold text-primary">Danh sách sản phẩm</h6>
      </div>
      <div class="card-body">
         <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
               <thead>
                  <tr>
                     <th>ID</th>
                     <th>Tên sản phẩm</th>
                     <th>Hãng</th>
                     <th>Mô tả</th>
                     <th>Giá bán</th>
                     <th>CPU</th>
                     <th>Ram</th>
                     <th>Ổ cứng</th>
                     <th>Màn hình</th>
                     <th>VGA</th>
                     <th>Hệ điều hành</th>
                     <th>Trọng lượng</th>
                     <th>Pin</th>
                     <th>Số lượng</th>
                     <th>Hình</th>
                     <th>Thao tác</th>
                  </tr>
               </thead>
               <tfoot>
                  <tr>
                     <th>ID</th>
                     <th>Tên sản phẩm</th>
                     <th>Hãng</th>
                     <th>Mô tả</th>
                     <th>Giá bán</th>
                     <th>CPU</th>
                     <th>Ram</th>
                     <th>Ổ cứng</th>
                     <th>Màn hình</th>
                     <th>VGA</th>
                     <th>Hệ điều hành</th>
                     <th>Trọng lượng</th>
                     <th>Pin</th>
                     <th>Số lượng</th>
                     <th>Hình</th>
                     <th>Thao tác</th>
                  </tr>
               </tfoot>
               <tbody>
                  <?php foreach ($sanpham as $sp) { ?>
                  <tr>
                     <td><?php echo $sp->MaSanPham ?></td>
                     <td><?php echo $sp->TenSanPham ?></td>
                     <td><?php echo $sp->TenHang ?></td>
                     <td style="width: 300px; word-wrap: break-word;"><?php echo $sp->MoTa ?></td>
                     <td style="white-space: nowrap;"><?php echo number_format($sp->GiaBan, 0, ',', '.'); ?>₫</td>
                     <td><?php echo $sp->CPU ?></td>
                     <td><?php echo $sp->Ram ?></td>
                     <td><?php echo $sp->OCung ?></td>
                     <td><?php echo $sp->ManHinh ?></td>
                     <td><?php echo $sp->VGA ?></td>
                     <td><?php echo $sp->HeDieuHanh ?></td>
                     <td style="white-space: nowrap;"><?php echo $sp->TrongLuong ?></td>
                     <td><?php echo $sp->Pin ?></td>
                     <td><?php echo $sp->SoLuong ?></td>
                     <td>
                        <img src="../public/images/products/<?php echo $sp->HinhAnh ?>" alt="<?php echo $sp->HinhAnh ?>" style="height: 200px;">
                     </td>
                     <td style="white-space: nowrap;">
                        <a href="UpdateProduct.php?id=<?php echo $sp->MaSanPham ?>">Chỉnh sửa </a>
                        <strong>|</strong>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal" data-masanpham="<?php echo $sp->MaSanPham; ?>">Xóa</a>
                     </td>
                  </tr>
                  <?php } ?>  
               </tbody>
            </table>
         </div>
      </div>
   </div>
</div>
<!-- Confirmation Modal -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="confirmDeleteModalLabel">Xác nhận xóa</h5>
            <button class="btnThaoTac" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
         </div>
         <div class="modal-body">
            Bạn có muốn xóa sản phẩm này?
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
            <form id="deleteForm" action="ListProducts.php" method="post">
               <input type="hidden" name="maSanPham" id="maSanPhamToDelete">
               <button type="submit" class="btn btn-danger" name="delete">Xóa</button>
            </form>
         </div>
      </div>
   </div>
</div>
<?php include('includes/footer.php');?>
<script>
   document.addEventListener('DOMContentLoaded', (event) => {
       var deleteModal = document.getElementById('confirmDeleteModal');
       deleteModal.addEventListener('show.bs.modal', function (event) {
           var button = event.relatedTarget;
           var maSanPham = button.getAttribute('data-masanpham');
           var input = deleteModal.querySelector('#maSanPhamToDelete');
           input.value = maSanPham;
       });
   });
</script>