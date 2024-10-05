<?php
try 
{
    // Chuỗi kết nối cho SQL Server
    $pdo = new PDO("sqlsrv:Server=DESKTOP-NO8JHRO\\VINHYET;Database=laptop", "sa", "123456");

} catch (PDOException $ex) {
    echo "Lỗi kết nối: " . $ex->getMessage();
    die();
}
?>