<?php
// إعدادات الاتصال بقاعدة بيانات Railway
// اضغط على زر العين (👁️) بجانب كل متغير في Railway لنسخ القيمة الحقيقية

$servername = "mysql://root:ukmWUNCdPCHnZBDOUOdBROgeTioqWYVT@mainline.proxy.rlwy.net:38757/railway";          // مثال: mysql.railway.internal أو العنوان الخارجي
$username   = "root";          // اسم المستخدم من لوحة التحcontrol
$password   = "ukmWUNCdPCHnZBDOUOdBROgeTioqWYVT";      // كلمة المرور السرية
$dbname     = "railway";      // اسم قاعدة البيانات
$port       = "38757";          // المنفذ (غالباً يكون 3306)

try {
    // الاتصال باستخدام امتداد PDO المتوافق مع الكود الخاص بك
    $conn = new PDO("mysql:host=$servername;port=$port;dbname=$dbname;charset=utf8", $username, $password);
    
    // تفعيل وضع إظهار الأخطاء بشكل تفصيلي لتسهيل التتبع
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch(PDOException $e) {
    // في حال فشل الاتصال سيطبع السبب مباشرة على الشاشة
    die("فشل الاتصال بقاعدة بيانات Railway: " . $e->getMessage());
}
?>
