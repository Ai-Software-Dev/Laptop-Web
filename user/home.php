<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <script src="assets/js/jquery-3.2.1.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="assets/css/slick.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/slick-theme.css" />

    <!--  -->
    <link rel="stylesheet" type="text/css" href="assets/css/Layout/style_header.css">
    <link rel="stylesheet" type="text/css" href="assets/css/Layout/style_footer.css">
    <link rel="stylesheet" type="text/css" href="assets/css/Home/style_home.css">
    <title>Document</title>
</head>

<body>
    <?php
    include_once '../core/Connection.php';
    session_start();
    include('layout/header.php');
    ?>
    <div id="maincontent">
        <div class="container">
            <!--ENDMENUNAV-->
            <div class="col-md-12 bor">
                <section id="slide" class="col-md-12">
                    <div class="col-md-2"></div>
                    <div id="carousel-example-generic" class="col-md-8 carousel slide" data-ride="carousel">
                        <!-- Indicators -->
                        <ol class="carousel-indicators">
                            <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                            <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                            <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                        </ol>
                        <!-- Wrapper for slides -->
                        <div class="carousel-inner" role="listbox">
                            <div class="item active">
                                <img src="../public/images/banner/banner1.png" alt="...">
                                <div class="carousel-caption">
                                </div>
                            </div>
                            <div class="item">
                                <img src="../public/images/banner/banner2.png" alt="...">
                                <div class="carousel-caption">
                                </div>
                            </div>
                            <div class="item">
                                <img src="../public/images/banner/banner3.png" alt="...">
                                <div class="carousel-caption">
                                </div>
                            </div>
                        </div>
                        <!-- Controls -->
                        <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </section>
                <?php
                include("TrendingProduct.php");
                ?>
            </div>
            <div class="container">
                <div class="col-md-4 bottom-home">
                    <a href=""><img src="../public/images/logo/free-shipping.png"></a>
                </div>
                <div class="col-md-4 bottom-home">
                    <a href=""><img src="../public/images/logo/guaranteed.png"></a>
                </div>
                <div class="col-md-4 bottom-home">
                    <a href=""><img src="../public/images/logo/deal.png"></a>
                </div>
            </div>
        </div>
    </div>

    <?php
    include('layout/footer.php');
    ?>
</body>
</html>