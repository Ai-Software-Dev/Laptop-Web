<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php
        include_once '../core/Connection.php';
        include("Pager.php");

        if (isset($_POST["txt_search"])) {
            $ten = $_POST["txt_search"];
            $sql = "SELECT * FROM SANPHAM WHERE TenSanPham LIKE :ten";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['ten' => '%' . $ten . '%']);
            $dssp = $stmt->fetchAll(PDO::FETCH_OBJ);

            // Tính số lượng sản phẩm
            $count = count($dssp);

            // Số sản phẩm trên mỗi trang
            $limit = 10; // Thay số 10 bằng số lượng sản phẩm bạn muốn hiển thị trên mỗi trang

            // Tạo đối tượng Pager
            $pager = new Pager();

            // Tính toán số trang
            $pages = $pager->findPages($count, $limit);

            // Lấy trang hiện tại
            $curPage = isset($_GET["page"]) ? $_GET["page"] : 1;

            // Tạo phân trang
            $phantrang = $pager->pageList($curPage, $pages);
        }
    ?>
</head>
<body>
    <h3 style="margin: 30px 0px; text-align: center;">KẾT QUẢ TÌM KIẾM</h3>

    <?php if (!empty($dssp)): ?>
        <?php foreach ($dssp as $sp): ?>
            <div class="showitem">
                <div class="col-md-3 item-product bor" style="height: 300px; margin: 5px; width: 23.8%">
                    <a href="ShowDetail.php?id=<?php echo htmlspecialchars($sp->MaSanPham) ?>"> <!-- Link đến sản phẩm -->
                        <img src="../public/images/products/<?php echo htmlspecialchars($sp->HinhAnh) ?>" class="" width="100%" height="180">
                    
                        <div class="info-item">
                            <p><?php echo htmlspecialchars($sp->TenSanPham) ?></p> <br>
                            <b class="price"><?php echo number_format($sp->GiaBan, 0, ',', '.'); ?>đ</b>
                        </div>
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <h4 style="color: red; font-weight: bold;" align="center">Không tìm thấy sản phẩm nào.</h4>
    <?php endif; ?>

    <!-- Phân trang -->
    <div class="col-md-12" style="margin-left: 240px">
        <?php if (isset($phantrang_search)) echo $phantrang_search; ?>
    </div>
</body>
</html>
