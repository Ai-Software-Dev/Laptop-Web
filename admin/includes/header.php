<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta name="description" content="">
      <meta name="author" content="">
      <title>BTVSHOP - Dashboard</title>
      <!-- Custom fonts for this template-->
      <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
      <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
      <link rel="shortcut icon" type="x-icon" href="../assets/images/logolapstore.png">
      <!-- Custom styles for this template-->
      <link href="assets/css/sb-admin-2.min.css" rel="stylesheet">
      <link href="assets/css/style.css" rel="stylesheet">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
   </head>
   <body id="page-top">
      <!-- Page Wrapper -->
      <div id="wrapper">
      <!-- Sidebar -->
      <?php include('includes/sidebar.php');?>
      <!-- End of Sidebar -->
      <!-- Content Wrapper -->
      <div id="content-wrapper" class="d-flex flex-column">
      <!-- Main Content -->
      <div id="content">
      <!-- Topbar -->
      <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
         <!-- Sidebar Toggle (Topbar) -->
         <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
         <i class="fa fa-bars"></i>
         </button>
         <!-- Topbar Search -->
         <form action="ListProducts.php" method="GET" class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
            <div class="input-group">
               <input type="text" name="txtSearch" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
               <div class="input-group-append">
                  <button class="btn btn-primary" type="submit"><i class="fas fa-search fa-sm"></i></button>
               </div>
            </div>
         </form>
         <!-- Topbar Navbar -->
         <ul class="navbar-nav ml-auto">
            <!-- Nav Item - Search Dropdown (Visible Only XS) -->
            <li class="nav-item dropdown no-arrow d-sm-none">
               <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
               <i class="fas fa-search fa-fw"></i>
               </a>
               <!-- Dropdown - Messages -->
               <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                  aria-labelledby="searchDropdown">
                  <form class="form-inline mr-auto w-100 navbar-search">
                     <div class="input-group">
                        <input type="text" class="form-control bg-light border-0 small"
                           placeholder="Search for..." aria-label="Search"
                           aria-describedby="basic-addon2">
                        <div class="input-group-append">
                           <button class="btn btn-primary" type="button">
                           <i class="fas fa-search fa-sm"></i>
                           </button>
                        </div>
                     </div>
                  </form>
               </div>
            </li>
            <!-- Nav Item - Alerts -->
            <li class="nav-item dropdown no-arrow mx-1">
               <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fas fa-bell fa-fw"></i>
                  <!-- Counter - Alerts -->
                  <?php
                     include_once '../core/Connection.php';
                     $sql = "SELECT COUNT(*) AS count FROM hoadon WHERE TrangThai = 'Chưa xác nhận'";
                     $st = $pdo->prepare($sql);
                     $st->execute();
                     $result = $st->fetch(PDO::FETCH_ASSOC);
                     $soluong = $result['count'];
                     if($soluong == 0) {
                        $sl="";
                     } else {
                        $sl = $soluong;
                     }
                     ?>
                  <span class="badge badge-danger badge-counter"><?php echo $sl?></span>
               </a>
               <!-- Dropdown - Alerts -->
               <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                  aria-labelledby="alertsDropdown">
                  <h6 class="dropdown-header">
                     Thông báo
                  </h6>
                  <a class="dropdown-item d-flex align-items-center" href="ListOrder.php">
                     <div class="mr-3">
                        <div class="icon-circle bg-primary">
                           <i class="fas fa-file-alt text-white"></i>
                        </div>
                     </div>
                     <div>
                        <div class="small text-gray-500">
                           <?php
                              $currentDateTime = date("Y-m-d");
                              echo $currentDateTime;
                              ?>
                        </div>
                        <span class="font-weight-bold">Có <?php echo $soluong?> chưa được xác nhận</span>
                     </div>
                  </a>
                  <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
               </div>
            </li>
            <!-- Nav Item - Messages -->
            <li class="nav-item dropdown no-arrow mx-1">
               <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button"
                  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fas fa-envelope fa-fw"></i>
                  <!-- Counter - Messages -->
                  <span class="badge badge-danger badge-counter">7</span>
               </a>
               <!-- Dropdown - Messages -->
               <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                  aria-labelledby="messagesDropdown">
                  <h6 class="dropdown-header">
                     Message Center
                  </h6>
                  <a class="dropdown-item d-flex align-items-center" href="#">
                     <div class="dropdown-list-image mr-3">
                        <img class="rounded-circle" src="assets/img/undraw_profile_1.svg"
                           alt="...">
                        <div class="status-indicator bg-success"></div>
                     </div>
                     <div class="font-weight-bold">
                        <div class="text-truncate">Hi there! I am wondering if you can help me with a
                           problem I've been having.
                        </div>
                        <div class="small text-gray-500">Emily Fowler · 58m</div>
                     </div>
                  </a>
                  <a class="dropdown-item d-flex align-items-center" href="#">
                     <div class="dropdown-list-image mr-3">
                        <img class="rounded-circle" src="img/undraw_profile_2.svg"
                           alt="...">
                        <div class="status-indicator"></div>
                     </div>
                     <div>
                        <div class="text-truncate">I have the photos that you ordered last month, how
                           would you like them sent to you?
                        </div>
                        <div class="small text-gray-500">Jae Chun · 1d</div>
                     </div>
                  </a>
                  <a class="dropdown-item d-flex align-items-center" href="#">
                     <div class="dropdown-list-image mr-3">
                        <img class="rounded-circle" src="assets/img/undraw_profile_3.svg"
                           alt="...">
                        <div class="status-indicator bg-warning"></div>
                     </div>
                     <div>
                        <div class="text-truncate">Last month's report looks great, I am very happy with
                           the progress so far, keep up the good work!
                        </div>
                        <div class="small text-gray-500">Morgan Alvarez · 2d</div>
                     </div>
                  </a>
                  <a class="dropdown-item d-flex align-items-center" href="#">
                     <div class="dropdown-list-image mr-3">
                        <img class="rounded-circle" src="https://source.unsplash.com/Mv9hjnEUHR4/60x60"
                           alt="...">
                        <div class="status-indicator bg-success"></div>
                     </div>
                     <div>
                        <div class="text-truncate">Am I a good boy? The reason I ask is because someone
                           told me that people say this to all dogs, even if they aren't good...
                        </div>
                        <div class="small text-gray-500">Chicken the Dog · 2w</div>
                     </div>
                  </a>
                  <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
               </div>
            </li>
            <div class="topbar-divider d-none d-sm-block"></div>
            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
               <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
               <span class="mr-2 d-none d-lg-inline text-gray-600 small">ADMIN</span>
               <img class="img-profile rounded-circle"
                  src="assets/img/undraw_profile.svg">
               </a>
               <!-- Dropdown - User Information -->
               <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                  aria-labelledby="userDropdown">
                  <a class="dropdown-item" href="#">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Profile
                  </a>
                  <a class="dropdown-item" href="#">
                  <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                  Settings
                  </a>
                  <a class="dropdown-item" href="#">
                  <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                  Activity Log
                  </a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                  </a>
               </div>
            </li>
         </ul>
      </nav>
      <!-- End of Topbar -->
      <!-- Begin Page Content -->
      <div class="container-fluid">