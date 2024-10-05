<?php
   ob_start();
   include('includes/header.php');
   ?>
<div>
<?php
   include_once '../core/Connection.php';
   
   $sqlhang = "SELECT * FROM hang";
   $sthang = $pdo->prepare($sqlhang);
   $sthang->execute();
   
   if ($sthang->rowCount()) {
    $hang = $sthang->fetchAll(PDO::FETCH_OBJ);
   }
   
   if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tenSanPham = $_POST['tenSanPham'];
    $maHang = $_POST['tenHang'];
    $giaBan = $_POST['giaBan'];
    $cpu = $_POST['cpu'];
    $ram = $_POST['ram'];
    $oCung = $_POST['oCung'];
    $manHinh = $_POST['manHinh'];
    $vga = $_POST['vga'];
    $heDieuHanh = $_POST['heDieuHanh'];
    $trongLuong = $_POST['trongLuong'];
    $pin = $_POST['pin'];
    $soLuong = $_POST['soLuong'];
    $moTa = $_POST['moTa'];
    $hinhAnh = $_FILES['hinhAnh']['name'];
   
    $target_dir = "../public/images/products/";
    $target_file = $target_dir . basename($_FILES["hinhAnh"]["name"]);
    move_uploaded_file($_FILES["hinhAnh"]["tmp_name"], $target_file);
   
    $sqlInsert = "INSERT INTO sanpham (TenSanPham, MaHang, GiaBan, CPU, Ram, OCung, ManHinh, VGA, HeDieuHanh, TrongLuong, Pin, SoLuong, MoTa, HinhAnh) 
                  VALUES (:tenSanPham, :maHang, :giaBan, :cpu, :ram, :oCung, :manHinh, :vga, :heDieuHanh, :trongLuong, :pin, :soLuong, :moTa, :hinhAnh)";
    $stmt = $pdo->prepare($sqlInsert);
    $stmt->execute([
        ':tenSanPham' => $tenSanPham,
        ':maHang' => $maHang,
        ':giaBan' => $giaBan,
        ':cpu' => $cpu,
        ':ram' => $ram,
        ':oCung' => $oCung,
        ':manHinh' => $manHinh,
        ':vga' => $vga,
        ':heDieuHanh' => $heDieuHanh,
        ':trongLuong' => $trongLuong,
        ':pin' => $pin,
        ':soLuong' => $soLuong,
        ':moTa' => $moTa,
        ':hinhAnh' => $hinhAnh
    ]);
   
    header("Location: ListProducts.php");
   }
   ?>
<div class="card o-hidden border-0 shadow-lg my-5">
   <div class="card-body p-0">
      <div class="row">
         <div class="col-lg-12">
            <div class="p-5">
               <div class="text-center">
                  <h1 class="h4 text-gray-900 mb-4">THÊM SẢN PHẨM MỚI</h1>
               </div>
               <form class="product" method="POST" enctype="multipart/form-data">
                  <div class="form-group">
                     <input type="text" class="form-control form-control-product" name="tenSanPham" placeholder="Tên Sản Phẩm" required>
                  </div>
                  <div class="form-group">
                     <select class="form-control form-control-product" name="tenHang" required>
                        <option value="" disabled selected>Chọn Hãng</option>
                        <?php foreach ($hang as $hsp) { ?>
                        <option value="<?php echo $hsp->MaHang ?>"><?php echo $hsp->TenHang ?></option>
                        <?php } ?>
                     </select>
                  </div>
                  <div class="form-group">
                     <input type="number" class="form-control form-control-product" name="giaBan" placeholder="Giá Bán" min="0" step="0.01" required>
                  </div>
                  <div class="form-group">
                     <input type="text" class="form-control form-control-product" name="cpu" placeholder="CPU" required>
                  </div>
                  <div class="form-group">
                     <input type="text" class="form-control form-control-product" name="ram" placeholder="Ram" required>
                  </div>
                  <div class="form-group">
                     <input type="text" class="form-control form-control-product" name="oCung" placeholder="Ổ Cứng" required>
                  </div>
                  <div class="form-group">
                     <input type="text" class="form-control form-control-product" name="manHinh" placeholder="Màn Hình" required>
                  </div>
                  <div class="form-group">
                     <input type="text" class="form-control form-control-product" name="vga" placeholder="VGA" required>
                  </div>
                  <div class="form-group">
                     <input type="text" class="form-control form-control-product" name="heDieuHanh" placeholder="Hệ Điều Hành" required>
                  </div>
                  <div class="form-group">
                     <input type="text" class="form-control form-control-product" name="trongLuong" placeholder="Trọng Lượng" required>
                  </div>
                  <div class="form-group">
                     <input type="text" class="form-control form-control-product" name="pin" placeholder="Pin" required>
                  </div>
                  <div class="form-group">
                     <input type="number" class="form-control form-control-product" name="soLuong" placeholder="Số Lượng" min="0" required>
                  </div>
                  <div class="form-group">
                     <textarea class="form-control form-control-product" name="moTa" placeholder="Mô Tả" required></textarea>
                  </div>
                  <div class="form-group">
                     <input type="file" class="form-control form-control-product" name="hinhAnh" placeholder="Hình Ảnh" style="padding: 10px; height: 50px" required>
                  </div>
                  <button type="submit" class="btn btn-primary btn-user btn-block">
                  Thêm Sản Phẩm
                  </button>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>
<?php
   include('includes/footer.php');
   ?>