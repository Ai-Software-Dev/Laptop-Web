<!DOCTYPE html>
<html>
<head>
    <title>Sản phẩm</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <script src="assets/js/jquery-3.2.1.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="assets/css/slick.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/slick-theme.css" />

    <!-- style -->
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="assets/css/Layout/style_header.css">
    <link rel="stylesheet" type="text/css" href="assets/css/Layout/style_footer.css">
    <style>
        .pagination>.active>span, .pagination>.active>span:hover {
        background-color: #333;
        border-color: #333;
        color:#fff;
        }
        .pagination>li>a {
        color:#000;
        }
        .pagination{
        /* padding-top: 100px;
        padding-bottom: 15px; */
        padding-left: 10%;
        }
    </style>
</head>
<body>
    <?php
        include_once '../core/Connection.php';
        session_start();
        include('layout/header.php');
    ?>
    <div id="maincontent">
        <div class="container">
            <!-- Sidebar -->
            <div class="col-md-3">
                <div class="box-left box-menu">
                    <h3 class="box-title"><i class="fa fa-list"></i>  Danh mục</h3>
                    <ul>
                    <?php
                        $sql = "select * from hang";
                        $hang = $pdo->query($sql); 
                        foreach($hang as $h) 
                        { 
                        ?>
                    <a href="ProductList.php?mh=<?php echo $h["MaHang"];?>">
                        <li class="list-group-item bg-light" style="cursor: pointer; font-weight: bold;"><?php echo $h["TenHang"];?></li>
                    </a>
                    <?php 
                        } 
                        ?>
                    </ul>
                </div>
            </div>
            <!-- End Sidebar -->
            <!-- Main Content -->
            <div class="col-md-9 bor">
                <?php
                    if (isset($_GET["mh"])) 
                    {
                        include("CategoryProduct.php");
                    }
                    else if (isset($_POST["txt_search"]))
                    {
                        include("SearchProduct.php");
                    }
                    else 
                    {
                        include("AllProduct.php");
                    }  
                    ?>
                <div class="col-md-12" style="margin-left: 240px">
                    <?php if (isset($phantrang)) echo $phantrang; ?>
                </div>
            </div>
            <!-- End Main Content -->
        </div>
    </div>
    <?php
        include('layout/footer.php');
    ?>
</body>
</html>