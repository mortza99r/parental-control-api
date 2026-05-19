<?php
// إعدادات الاتصال الخارجي الصحيحة والمستخرجة من حسابك في Railway

$servername = "mainline.proxy.rlwy.net"; 
$username   = "root";          
$password   = "ukmWUNCdPCHnZBDOUOdBROgeTioqWYVT"; // تأكد من مطابقتها للباسورد بالكامل بعد زر العين
$dbname     = "railway";      
$port       = "38757"; // المنفذ الخارجي الخاص بك
try {
    // إضافة خيارات متقدمة لحماية الاتصال ومنع انقطاعه (Gone away)
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
        PDO::ATTR_TIMEOUT            => 15,    // إعطاء السيرفر 15 ثانية للرد بدل الاستسلام فوراً
        PDO::ATTR_PERSISTENT         => false  // 🔴 الأهم: إجبار السيرفر على فتح اتصال جديد ونظيف كل مرة
    ];

    // الاتصال باستخدام PDO مع الخيارات الجديدة
    $conn = new PDO("mysql:host=$servername;port=$port;dbname=$dbname;charset=utf8mb4", $username, $password, $options);
    
} catch(PDOException $e) {
    die("فشل الاتصال بقاعدة بيانات Railway: " . $e->getMessage());
}
?>
