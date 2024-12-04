<?php
   include('includes/header.php');
   ?>
<div>
   <?php
      include_once '../core/Connection.php';
      
      $sql = "select * from users";
      $st = $pdo->prepare($sql);
      $st->execute();

      if($st->rowCount()) {
         $khachhang = $st->fetchAll(PDO::FETCH_OBJ);
      }
      ?>
   <div class="card shadow mb-4">
      <div class="card-header py-3">
         <h6 class="m-0 font-weight-bold text-primary">Danh sách khách hàng</h6>
      </div>
      <div class="card-body">
         <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
               <thead>
                  <tr>
                     <th>ID</th>
                     <th>Tên khách hàng</th>
                     <th>Tên tài khoản</th>
                     <th>Email</th>
                  </tr>
               </thead>
               <tfoot>
                  <tr>
                     <th>ID</th>
                     <th>Tên khách hàng</th>
                     <th>Tên tài khoản</th>
                     <th>Email</th>
                  </tr>
               </tfoot>
               <tbody>
                  <?php
                    foreach($khachhang as $kh) { ?>
                        <tr>
                            <td><?php echo $kh->MaTaiKhoan?></td>
                            <td><?php echo $kh->TenKhachHang?></td>
                            <td><?php echo $kh->TenTaiKhoan?></td>
                            <td><?php echo $kh->Email?></td>
                        </tr>    
                  <?php }?>  
               </tbody>
            </table>
         </div>
      </div>
   </div>
</div>
<?php
   include('includes/footer.php');
   ?>