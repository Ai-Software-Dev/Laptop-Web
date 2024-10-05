<?php include('includes/header.php');?>
<?php
   include_once '../core/Connection.php';

   // Thống kê ngày
   $sqlngay = "SELECT SUM(TongTien) AS TongThanhTien
   FROM hoadon
   WHERE CONVERT(DATE, NgayMua) = CONVERT(DATE, CURRENT_TIMESTAMP)";

   $stngay = $pdo->prepare($sqlngay);
   $stngay->execute();

   if ($stngay->rowCount()) {
      $dtNgay = $stngay->fetchAll(PDO::FETCH_OBJ);
   }

   // Thống kê tháng
   $sqlthang = "SELECT SUM(TongTien) AS TongThanhTien
   FROM hoadon
   WHERE MONTH(NgayMua) = MONTH(CURRENT_TIMESTAMP) AND YEAR(NgayMua) = YEAR(CURRENT_TIMESTAMP)";

   $stthang = $pdo->prepare($sqlthang);
   $stthang->execute();

   if ($stthang->rowCount()) {
      $dtThang = $stthang->fetchAll(PDO::FETCH_OBJ);
   }

   // Thống kê năm
   $sqlnam = "SELECT SUM(TongTien) AS TongThanhTien
        FROM hoadon
        WHERE YEAR(NgayMua) = YEAR(CURRENT_TIMESTAMP)";

   $stnam = $pdo->prepare($sqlnam);
   $stnam->execute();

   if ($stnam->rowCount()) {
      $dtnam = $stnam->fetchAll(PDO::FETCH_OBJ);
   }
?>
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
   <h1 class="h3 mb-0 text-gray-800">Thống kê</h1>
</div>
<!-- Content Row -->
<div class="row">
   <!-- Earnings (Monthly) Card Example -->
   <div class="col-xl-4 col-md-6 mb-4">
      <div class="card border-left-primary shadow h-100 py-2">
         <div class="card-body">
            <div class="row no-gutters align-items-center">
               <div class="col mr-2">
                  <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                     Thu nhập (Hàng ngày)
                  </div>
                  <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo number_format($dtNgay[0]->TongThanhTien, 0, ',', '.') . ' VND';?></div>
               </div>
               <div class="col-auto">
                  <i class="fas fa-calendar fa-2x text-gray-300"></i>
               </div>
            </div>
         </div>
      </div>
   </div>

   <!-- Earnings (Monthly) Card Example -->
   <div class="col-xl-4 col-md-6 mb-4">
      <div class="card border-left-primary shadow h-100 py-2">
         <div class="card-body">
            <div class="row no-gutters align-items-center">
               <div class="col mr-2">
                  <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                     Thu nhập (Hàng tháng)
                  </div>
                  <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo number_format($dtThang[0]->TongThanhTien, 0, ',', '.') . ' VND';?></div>
               </div>
               <div class="col-auto">
                  <i class="fas fa-calendar fa-2x text-gray-300"></i>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- Earnings (Monthly) Card Example -->
   <div class="col-xl-4 col-md-6 mb-4">
      <div class="card border-left-success shadow h-100 py-2">
         <div class="card-body">
            <div class="row no-gutters align-items-center">
               <div class="col mr-2">
                  <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                     Thu nhập (Hàng năm)
                  </div>
                  <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo number_format($dtnam[0]->TongThanhTien, 0, ',', '.') . ' VND';?></div>
               </div>
               <div class="col-auto">
                  <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- Earnings (Monthly) Card Example -->
</div>
<!-- Content Row -->

<!-- Content Row -->

<?php include('includes/footer.php');?>