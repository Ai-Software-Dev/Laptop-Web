
   <div id="wrapper">
      <!---->
      <!--HEADER-->
      <div id="header">
         <div class="container">
            <div class="row" id="header-main">
               <div class="col-md-4 logo">
                  <a href="../index.php">
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
                     <a href="index.php">Trang chủ</a>
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
                     $current_page = basename($_SERVER['PHP_SELF']);

                     if (isset($_SESSION['username'])) {
                        // Nếu đã đăng nhập, hiển thị tên khách hàng và menu dropdown
                        echo '<a href="#"><i class="fa fa-user"></i><span style="color: white; font-weight: bold; margin-left: 8px">' . $_SESSION['tenkhachhang'] . '</span></a>';
                        echo '<div class="account-menu-content">';
                        echo '<p><a href="CustomerInfo.php">Thông Tin Khách Hàng</a></p>';
                        echo '<p><a href="Logout.php">Đăng Xuất</a></p>';
                        echo '</div>';
                     } else {
                        // Nếu chưa đăng nhập và không ở trang login, hiển thị nút Tài khoản
                        if ($current_page !== 'login.php') {
                           echo '<a href="#"><i class="fa fa-user"></i><span style="color: white; font-weight: bold; margin-left: 8px">Tài khoản</span></a>';
                           echo '<div class="account-menu-content">';
                           echo '<p><a href="login.php">Đăng Nhập</a></p>';
                           echo '<p><a href="Register.php">Đăng Ký</a></p>';
                           echo '</div>';
                        }
                     }
                     ?>
                  </li>
                  <?php
                  if (isset($_SESSION["username"])) {
                  ?>
                     <li>
                        <a href="ShowCart.php"><i class="fa fa-shopping-basket"></i></a>
                     </li>
                  <?php
                  } else {
                  ?>
                     <li>
                        <a href="login.php"><i class="fa fa-shopping-basket"></i></a>
                     </li>
                  <?php
                  }
                  ?>
               </ul>

               <!--end Shopping-->
            </nav>
         </div>
      </div>