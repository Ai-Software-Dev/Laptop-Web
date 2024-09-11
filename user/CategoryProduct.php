<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php
        include_once '../core/Connection.php';
        include("Pager.php");

        $mahang = null;
        if (isset($_GET["mh"])) {
            $mahang = (int)$_GET["mh"];
        }

        if ($mahang !== null) {
            $sql = "SELECT * FROM SanPham WHERE MaHang = :mahang";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'mahang' => $mahang
            ]);
            $sps = $stmt->fetchAll(PDO::FETCH_OBJ);

            $sql1 = "SELECT TenHang FROM HANG WHERE MaHang = :mahang";
            $st_tenhang = $pdo->prepare($sql1);
            $st_tenhang->execute([
                'mahang' => $mahang
            ]);
            $tenhang = $st_tenhang->fetchAll(PDO::FETCH_OBJ);
        }

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

        
        // Initial Query to get the total count of records for this category
        $sql_count = "SELECT COUNT(*) FROM SanPham WHERE MaHang = :mahang";
        $sta = $pdo->prepare($sql_count);
        $sta->execute([
            'mahang' => $mahang
        ]);
        $count = $sta->fetchColumn();
    $p = new Pager();
        $limit = 8;  // Thiết lập số sản phẩm của 1 trang.
        $vt = $p->findStart($limit);
        $pages = $p->findPages($count, $limit);

        // Determine current page
        $cur = isset($_GET["page"]) ? $_GET["page"] : 1;
        $phantrang = $p->pageList($cur, $pages, isset($_GET["mh"]) ? "&mh=" . $_GET["mh"] : "");

        // Query to fetch the records for the current page
        $sql2 = "SELECT * FROM sanpham WHERE MaHang = :mahang LIMIT $limit OFFSET $vt";
        $sta = $pdo->prepare($sql2);
        $sta->execute([
            'mahang' => $mahang
        ]);
        $san_pham = $sta->fetchAll(PDO::FETCH_OBJ);
        // Tính toán lại số lượng sản phẩm
        $num_products = count($san_pham);

    ?>
</head>
<body>
    <section class="box-main1">
        <h3 class="title-main" style="text-align: center;"><a href="javascript:void(0)"><?php echo $tenhang[0]->TenHang ?></a> </h3>
        <?php
            if (!empty($sps))
            {
                foreach($sps as $sp)
                {
        ?>
                    <div class="showitem">
                        <div class="col-md-3 item-product bor">
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
        else
            {
        ?>
            <h4 style="text-align: center; margin-top:25px; color: red; font-weight: bold;">Không có sản phẩm nào thuộc hãng này!</h4>
        <?php
            }
        ?>
    </section>
</body>
</html>
