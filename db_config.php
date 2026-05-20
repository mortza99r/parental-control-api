<?php
// إعدادات الاتصال الخارجي الصحيحة والمستخرجة من حسابك في Railway

$servername = "mainline.proxy.rlwy.net"; 
$username   = "root";          
$password   = "ukmWUNCdPCHnZBDOUOdBROgeTioqWYVT"; // تأكد من مطابقتها للباسورد بالكامل بعد زر العين
$dbname     = "railway";      
$port       = "38757"; // المنفذ الخارجي الخاص بك

try {
    $conn = new PDO(
        "mysql:host=$servername;port=$port;dbname=$dbname;charset=utf8mb4",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_PERSISTENT => false,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
        ]
    );
} catch(PDOException $e) {
    die("فشل الاتصال بقاعدة البيانات: " . $e->getMessage());
}
?>
