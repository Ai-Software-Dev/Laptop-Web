<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php
        include_once '../core/Connection.php';
        $masp = null;

        if (isset($_GET["id"]))
        {
            $masp = (int)$_GET["id"];
        }

        $sql1 = "SELECT MaHang FROM SanPham WHERE MaSanPham = :masp";
        $st_mahang = $pdo->prepare($sql1);
        $st_mahang->execute([
            'masp' => $masp
        ]);
        $mahang = $st_mahang->fetchAll(PDO::FETCH_OBJ);

        $sql = "SELECT * FROM sanpham WHERE MaHang = :mahang LIMIT 3";
        $st = $pdo->prepare($sql);
        $st->execute([
            'mahang' => $mahang[0]->MaHang
        ]);
        $sps = $st->fetchAll(PDO::FETCH_OBJ);

    ?>
</head>
<body>

        <?php
            if (!empty($sps))
            {
                foreach($sps as $sp)
                {
        ?>
                    <div class="showitem">
                        <div class="col-md-3 item-product bor" style="height: 300px; margin: 5px; width: 100%">
                            <a href="ShowDetail.php?id=<?php echo $sp->MaSanPham ?>">
                                <img src="../public/images/products/<?php echo htmlspecialchars($sp->HinhAnh) ?>" class="" width="100%" height="180">
                            
                                <div class="info-item">
                                    <p><?php echo htmlspecialchars($sp->TenSanPham) ?></p> <br>
                                    <b class="price"><?php echo number_format($sp->GiaBan, 0, ',', '.') ?>đ</b><br>
                                    <span style="margin-top: 50px;">Đã bán <?php echo getSoLuongDaBanProduct($pdo, $sp->MaSanPham); ?></span>
                                </div>
                            </a>
                        </div>
                    </div>
        <?php
                }
            }
        ?>
</body>
</html>