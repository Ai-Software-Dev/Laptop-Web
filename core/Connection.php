<?php
try
{
    // Chuỗi kết nối cho SQL Server
    $pdo = new PDO("sqlsrv:Server=XuanBinh\XUANBINH;Database=laptop");

} catch (PDOException $ex) {
    echo "Lỗi kết nối: " . $ex->getMessage();
    die();
}
?>