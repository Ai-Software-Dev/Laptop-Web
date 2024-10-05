<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta name="description" content="">
      <meta name="author" content="">
      <title>ADMIN - Login</title>
      <!-- Custom fonts for this template-->
      <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
      <link
         href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
         rel="stylesheet">
      <!-- Custom styles for this template-->
      <link href="assets/css/sb-admin-2.min.css" rel="stylesheet">
      <?php
         include_once '../core/Connection.php';

         $tbtaikhoan = "";
         $tbmatkhau = "";
         $thongbao = "";
         
         if (isset($_POST['login'])) {
            if (empty($_POST['tendangnhap']) && empty($_POST['matkhau'])) {
                $tbtaikhoan = "Vui lòng nhập tài khoản";
                $tbmatkhau = "Vui lòng nhập mật khẩu";
            } elseif (empty($_POST['tendangnhap'])) {
                $tbtaikhoan = "Vui lòng nhập tài khoản";
            } elseif (empty($_POST['matkhau'])) {
                $tbmatkhau = "Vui lòng nhập mật khẩu";
            } else {
                $tendangnhap = $_POST['tendangnhap'];
                $matkhau = $_POST['matkhau'];
        
                $sql = "SELECT * FROM admin WHERE TenTaiKhoan = :tendangnhap AND MatKhau = :matkhau";
        
                $st = $pdo->prepare($sql);
                $st->execute([':tendangnhap' => $tendangnhap, ':matkhau' => $matkhau]);
        
                // Kiểm tra kết quả từ fetch()
                $result = $st->fetch(PDO::FETCH_ASSOC);
        
                if ($result) {
                    session_start();
                    $_SESSION['tendangnhap'] = $tendangnhap;
        
                    header('Location: Home.php');
                    exit();
                } else {
                    $thongbao = "Tài khoản hoặc mật khẩu không đúng, vui lòng thử lại!";
                }
            }
        }
         ?>
   </head>
   <body class="bg-gradient-primary">
      <div class="container">
         <!-- Outer Row -->
         <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
               <div class="card o-hidden border-0 shadow-lg my-5">
                  <div class="card-body p-0">
                     <!-- Nested Row within Card Body -->
                     <div class="row">
                        <!-- <div class="col-lg-6 d-none d-lg-block bg-login-image"></div> -->
                        <div class="col-lg-12">
                           <div class="p-5">
                              <div class="text-center">
                                 <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                              </div>
                              <form class="user" method="POST" action="index.php">
                                 <p style="text-align: center;"><?php echo $thongbao?></p>
                                 <div class="form-group">
                                    <input type="text" name="tendangnhap" class="form-control" id="exampleInputEmail" placeholder="Tên tài khoản">
                                    <p style="font-size: small; color: red;"><?php echo $tbtaikhoan?></p>
                                 </div>
                                 <div class="form-group">
                                    <input type="password" name="matkhau" class="form-control" id="exampleInputPassword" placeholder="Mật khẩu">
                                    <p style="font-size: small; color: red;"><?php echo $tbmatkhau?></p>
                                 </div>
                                 <div class="form-group">
                                    <div class="custom-control custom-checkbox small">
                                       <input type="checkbox" class="custom-control-input" id="customCheck">
                                       <label class="custom-control-label" for="customCheck">Nhớ mật khẩu</label>
                                    </div>
                                 </div>
                                 <!-- <a href="index.html" class="btn btn-primary btn-user btn-block">Đăng nhập</a> -->
                                 <button class="btn btn-primary btn-user btn-block" name="login">Đăng nhập</button>
                              </form>
                              <hr>
                              <div class="text-center">
                                 <a class="small" href="forgot-password.html">Forgot Password?</a>
                              </div>
                              <div class="text-center">
                                 <a class="small" href="register.html">Create an Account!</a>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- Bootstrap core JavaScript-->
      <script src="vendor/jquery/jquery.min.js"></script>
      <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
      <!-- Core plugin JavaScript-->
      <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
      <!-- Custom scripts for all pages-->
      <script src="js/sb-admin-2.min.js"></script>
   </body>
</html>