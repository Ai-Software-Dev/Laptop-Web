<?php
try 
{
    // Chuỗi kết nối cho SQL Server
    $pdo = new PDO("sqlsrv:Server=XuanBinh\\XUANBINH;Database=laptop", "sa", "123");

} catch (PDOException $ex) {
    echo "Lỗi kết nối: " . $ex->getMessage();   
    die();
}
?>