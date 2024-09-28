<?php
   ob_start();
   include('includes/header.php');
   include_once '../core/Connection.php';
   
   $sqlhang = "SELECT * FROM hang";
   $sthang = $pdo->prepare($sqlhang);
   $sthang->execute();
   
   if ($sthang->rowCount()) {
       $hang = $sthang->fetchAll(PDO::FETCH_OBJ);
   }
   
   if (isset($_GET['id'])) {
       $maSanPham = $_GET['id'];
       $sql = "SELECT * FROM sanpham WHERE MaSanPham = :maSanPham";
       $stmt = $pdo->prepare($sql);
       $stmt->execute([':maSanPham' => $maSanPham]);
       $sanpham = $stmt->fetch(PDO::FETCH_OBJ);
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


    if (!empty($_FILES['hinhAnh']['name'])) {
        $target_dir = "../public/images/products/";
        $target_file = $target_dir . basename($_FILES["hinhAnh"]["name"]);
        move_uploaded_file($_FILES["hinhAnh"]["tmp_name"], $target_file);
        $hinhAnh = $_FILES['hinhAnh']['name']; 
    } else {
  
        $hinhAnh = $_POST['hinhAnhCu'];
    }

   
    $sqlUpdate = "UPDATE sanpham 
                  SET TenSanPham = :tenSanPham, MaHang = :maHang, GiaBan = :giaBan, CPU = :cpu, Ram = :ram, OCung = :oCung, ManHinh = :manHinh, VGA = :vga, HeDieuHanh = :heDieuHanh, TrongLuong = :trongLuong, Pin = :pin, SoLuong = :soLuong, MoTa = :moTa, HinhAnh = :hinhAnh 
                  WHERE MaSanPham = :maSanPham";
    
    $stmt = $pdo->prepare($sqlUpdate);
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
        ':hinhAnh' => $hinhAnh, 
        ':maSanPham' => $_POST['maSanPham']
    ]);

    header("Location: ListProducts.php");
    exit();
    }
   ?>
<div class="card o-hidden border-0 shadow-lg my-5">
   <div class="card-body p-0">
      <div class="row">
         <div class="col-lg-12">
            <div class="p-5">
               <div class="text-center">
                  <h1 class="h4 text-gray-900 mb-4">CẬP NHẬT SẢN PHẨM</h1>
               </div>
               <form class="product" method="POST" enctype="multipart/form-data">
                  <div class="form-group">
                     <input type="text" class="form-control form-control-product" name="tenSanPham" value="<?php echo $sanpham->TenSanPham ?>" required>
                  </div>
                  <div class="form-group">
                     <select class="form-control form-control-product" name="tenHang" required>
                        <option value="" disabled selected>Chọn Hãng</option>
                        <?php foreach ($hang as $hsp) { ?>
                        <option value="<?php echo $hsp->MaHang ?>" <?php if($sanpham->MaHang == $hsp->MaHang) echo 'selected' ?>><?php echo $hsp->TenHang ?></option>
                        <?php } ?>
                     </select>
                  </div>
                  <div class="form-group">
                     <input type="number" class="form-control form-control-product" name="giaBan" value="<?php echo $sanpham->GiaBan ?>" min="0" step="0.01" required>
                  </div>
                  <div class="form-group">
                     <input type="text" class="form-control form-control-product" name="cpu" value="<?php echo $sanpham->CPU ?>" required>
                  </div>
                  <div class="form-group">
                     <input type="text" class="form-control form-control-product" name="ram" value="<?php echo $sanpham->Ram ?>" required>
                  </div>
                  <div class="form-group">
                     <input type="text" class="form-control form-control-product" name="oCung" value="<?php echo $sanpham->OCung ?>" required>
                  </div>
                  <div class="form-group">
                     <input type="text" class="form-control form-control-product" name="manHinh" value="<?php echo $sanpham->ManHinh ?>" required>
                  </div>
                  <div class="form-group">
                     <input type="text" class="form-control form-control-product" name="vga" value="<?php echo $sanpham->VGA ?>" required>
                  </div>
                  <div class="form-group">
                     <input type="text" class="form-control form-control-product" name="heDieuHanh" value="<?php echo $sanpham->HeDieuHanh ?>" required>
                  </div>
                  <div class="form-group">
                     <input type="text" class="form-control form-control-product" name="trongLuong" value="<?php echo $sanpham->TrongLuong ?>" required>
                  </div>
                  <div class="form-group">
                     <input type="text" class="form-control form-control-product" name="pin" value="<?php echo $sanpham->Pin ?>" required>
                  </div>
                  <div class="form-group">
                     <input type="number" class="form-control form-control-product" name="soLuong" value="<?php echo $sanpham->SoLuong ?>" min="0" required>
                  </div>
                  <div class="form-group">
                     <textarea class="form-control form-control-product" name="moTa" required><?php echo $sanpham->MoTa ?></textarea>
                  </div>

                  <div class="form-group">
                    <?php if (!empty($sanpham->HinhAnh)) { ?>
                        <p>Tệp hiện tại: <span id="file-name"><?php echo $sanpham->HinhAnh; ?></span></p>
                        <img id="current-image" src="../public/images/products/<?php echo $sanpham->HinhAnh; ?>" alt="Current Image" style="width: 150px; height: auto; display: block; margin-bottom: 10px;">
                    <?php } ?>

                    <input type="file" class="form-control form-control-product" name="hinhAnh" id="file-input" onchange="previewImage();" style="padding: 10px; height: 50px;">

                    <input type="hidden" name="hinhAnhCu" value="<?php echo $sanpham->HinhAnh; ?>">
                    <input type="hidden" name="maSanPham" value="<?php echo $sanpham->MaSanPham; ?>">
                  </div>
                  <button type="submit" class="btn btn-primary btn-user btn-block">Hoàn Thành</button>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>
<?php include('includes/footer.php');?>
<script>
    function previewImage() {
        var fileInput = document.getElementById('file-input');
        var file = fileInput.files[0];
        
        if (file) {
            var reader = new FileReader();

            document.getElementById('current-image').src = '';

            reader.onload = function(e) {
                document.getElementById('current-image').src = e.target.result;
            }
            
            reader.readAsDataURL(file);
            document.getElementById('file-name').innerText = file.name;
        }
    }
</script>