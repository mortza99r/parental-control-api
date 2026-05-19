<?php
// إعدادات الاتصال الخارجي الصحيحة والمستخرجة من حسابك في Railway

$servername = "mainline.proxy.rlwy.net"; 
$username   = "root";          
$password   = "ukmWUNCdPCHnZBDOUodBROgeTioqWYVT"; // تأكد من مطابقتها للباسورد بالكامل بعد زر العين
$dbname     = "railway";      
$port       = "38757"; // المنفذ الخارجي الخاص بك

try {
    // الاتصال باستخدام PDO عبر المنفذ والسيرفر الخارجيين
    $conn = new PDO("mysql:host=$servername;port=$port;dbname=$dbname;charset=utf8", $username, $password);
    
    // تفعيل وضع الأخطاء
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch(PDOException $e) {
    die("فشل الاتصال بقاعدة بيانات Railway: " . $e->getMessage());
}
?>
