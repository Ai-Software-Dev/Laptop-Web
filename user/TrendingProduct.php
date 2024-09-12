<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php
       include_once '../core/Connection.php';

        $sql = "SELECT * FROM sanpham ORDER BY GiaBan DESC LIMIT 8";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $sps = $stmt->fetchAll(PDO::FETCH_OBJ);

        function getSoLuongDaBanProduct($pdo, $masp) 
        {
            $sqldaban = "SELECT SUM(chitiethoadon.soluong) AS SoLuongDaBan " .
                        "FROM sanpham INNER JOIN chitiethoadon ON sanpham.MaSanPham = chitiethoadon.masanpham " .
                        "WHERE sanpham.MaSanPham = :masp";
            $stmt = $pdo->prepare($sqldaban);
            $stmt->execute(['masp' => $masp]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['SoLuongDaBan'] ?? 0;
        }
    ?>
</head>
<body>
    <section class="box-main1">
        <h3 class="title-trending"><a href="javascript:void(0)"> Sản phẩm nổi bật </a> </h3>
        <?php
            if (!empty($sps))
            {
                foreach($sps as $sp)
                {
        ?>
                    <div class="showitem">
                        <div class="col-md-3 item-product bor" >
                            <a href="ShowDetail.php?id=<?php echo $sp->MaSanPham ?>">
                                <div class="product-img">
                                    <img src="../public/images/products/<?php echo htmlspecialchars($sp->HinhAnh) ?>" class="" width="100%" height="180">
                                </div>
                                <div class="info-item">
                                    <p class="product-name"><?php echo htmlspecialchars($sp->TenSanPham) ?></p> <br>
                                    <b class="product-price"><?php echo number_format($sp->GiaBan, 0, ',', '.') ?>đ</b><br>
                                    <h6>Đã bán <?php echo getSoLuongDaBanProduct($pdo, $sp->MaSanPham); ?></h6>
                                </div>
                            </a>
                        </div>
                    </div>
        <?php
                }
            }
        ?>
    </section>
</body>
</html>