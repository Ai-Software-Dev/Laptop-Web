<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tất Cả Sản Phẩm</title>
    <?php
        include_once '../core/Connection.php';
        include("Pager.php");

        $sql = "SELECT * FROM SanPham";
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

        // Initial Query to get the total count of records
        $sql1 = "SELECT COUNT(*) FROM sanpham";
        $sta = $pdo->prepare($sql1);
        $sta->execute();
        $count = $sta->fetchColumn();

        $p = new Pager();
        $limit = 8;  // Thiết lập số sản phẩm của 1 trang.

        // Determine current page
        $cur = isset($_GET["page"]) ? $_GET["page"] : 1;
        $vt = $p->findStart($limit, $cur);
        $pages = $p->findPages($count, $limit);

        // Query to fetch the records for the current page
        $sql2 = "SELECT * FROM sanpham ORDER BY MaSanPham OFFSET $vt ROWS FETCH NEXT $limit ROWS ONLY"; // Cập nhật câu truy vấn
        $sta = $pdo->prepare($sql2);
        $sta->execute();
        $san_pham = $sta->fetchAll(PDO::FETCH_OBJ);

        // Generate pagination
        $phantrang = $p->pageList($cur, $pages);
    ?>
</head>
   
<body>
    <section class="box-main1">
        <h3 class="title-main" style="text-align: center;"><a href="javascript:void(0)"> Tất cả sản phẩm </a> </h3>
        <?php
            if (!empty($sps))
            {
                foreach($san_pham as $sp)
                {
        ?>
                    <div class="showitem">
                        <div class="col-md-3 item-product bor" style="height: 300px; margin: 5px; width: 23.8%">
                            <a href="ShowDetail.php?id=<?php echo $sp->MaSanPham ?>">
                                <img src="../public/images/products/<?php echo htmlspecialchars($sp->HinhAnh) ?>" class="" width="100%" height="180">
                            
                                <div class="info-item">
                                    <p><?php echo htmlspecialchars($sp->TenSanPham) ?></p> <br>
                                    <b class="price"><?php echo number_format($sp->GiaBan, 0, ',', '.') ?>₫</b><br>
                                    <span style="margin-top: 50px;">Đã bán <?php echo getSoLuongDaBanProduct($pdo, $sp->MaSanPham); ?></span>
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