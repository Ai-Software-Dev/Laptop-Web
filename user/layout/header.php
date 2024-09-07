<!DOCTYPE html>
<html>
   <head>
      <title>Trang chủ</title>
      <meta charset="utf-8">

      <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css">

      <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
      <script  src="assets/js/jquery-3.2.1.min.js"></script>
      <script  src="assets/js/bootstrap.min.js"></script>
      <!---->
      <link rel="stylesheet" type="text/css" href="assets/css/slick.css"/>
      <link rel="stylesheet" type="text/css" href="assets/css/slick-theme.css"/>

      <!-- css -->
      <link rel="stylesheet"  href="assets/css/Layout/style_header.css">
      <link rel="stylesheet"  href="assets/css/Layout/style_footer.css">
      <link rel="stylesheet"  href="assets/css/Home/style_home.css">
      <link rel="stylesheet"  href="assets/css/Product/style_products.css">
      <link rel="stylesheet"  href="assets/css/Product/style_detail.css">
      <link rel="stylesheet"  href="assets/css/Cart/style_cart.css">
      <link rel="stylesheet"  href="assets/css/Contact/style_contact.css">
      <link rel="stylesheet"  href="assets/css/Intro/style_intro.css">
      <link rel="stylesheet"  href="assets/css/Login/style_login.css">

      <?php
         include("../core/Connection.php");
         session_start();
         ?>
   </head>
   <body>
      <div id="wrapper">
         <!---->
         <!--HEADER-->
         <div id="header">
            <div class="container">
               <div class="row" id="header-main">
                  <div class="col-md-4 logo">
                     <a href="/user/index.php">
                     <img src="../public/images/logo/logo_btv.png"> <span>SHOP</span>
                     </a>
                  </div>
                  <div class="col-md-5">
                     <form class="form-inline" method="post" action="ProductList.php">
                        <div class="form-group">
                           <input type="text" name="txt_search" placeholder="Tìm kiếm..." class="form-control">
                           <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                        </div>
                     </form>
                  </div>
                  <div class="col-md-3" id="header-right">
                     <div class="pull-right">
                        <div class="pull-left">
                           <i class="glyphicon glyphicon-phone-alt"></i>
                        </div>
                        <div class="pull-right">
                           <p id="hotline">HOTLINE</p>
                           <p>0986420994</p>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <!--END HEADER-->
         <!--MENUNAV-->
         <div id="menunav">
            <div class="container">
               <nav>
                  <!--menu main-->
                  <ul id="menu-main">
                     <li>
                        <a href="#">Trang chủ</a>
                     </li>
                     <li>
                        <a href="#">Laptop</a>
                     </li>
                     <li>
                        <a href="#">Liên hệ</a>
                     </li>
                     <li>
                        <a href="#">Giới thiệu</a>
                     </li>
                  </ul>
                  <!-- end menu main-->
                  <!--Shopping-->
                  <ul class="pull-right" id="main-shopping">
                     <li class="account-menu">
                        <?php
                           if(isset($_SESSION['username'])) {
                               // Nếu đã đăng nhập, hiển thị tên khách hàng và menu dropdown
                               echo '<a href="#"><i class="fa fa-user"></i><span style="color: white; font-weight: bold; margin-left: 8px">' . $_SESSION['tenkhachhang'] . '</span></a>';
                               echo '<div class="account-menu-content">';
                               echo '<p><a href="CustomerInfo.php">Thông Tin Khách Hàng</a></p>';
                               echo '<p><a href="Logout.php">Đăng Xuất</a></p>';
                               echo '</div>';
                           } else {
                               // Nếu chưa đăng nhập, hiển thị nút Tài khoản
                               echo '<a href="#"><i class="fa fa-user"></i><span style="color: white; font-weight: bold; margin-left: 8px">Tài khoản</span></a>';
                               echo '<div class="account-menu-content">';
                               echo '<p><a href="Login.php">Đăng Nhập</a></p>';
                               echo '<p><a href="Register.php">Đăng Ký</a></p>';
                               echo '</div>';
                           }
                           ?>
                     </li>
                     <?php
                        if (isset($_SESSION["username"]))
                        {
                     ?>
                           <li>
                              <a href="ShowCart.php"><i class="fa fa-shopping-basket"></i></a>
                           </li>
                     <?php
                        }
                        else
                        {
                     ?>
                           <li>
                              <a href="Login.php"><i class="fa fa-shopping-basket"></i></a>
                           </li>
                     <?php
                        }
                      ?>
                  </ul>
                  <!--end Shopping-->
               </nav>
            </div>
         </div>