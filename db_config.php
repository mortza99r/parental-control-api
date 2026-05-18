<?php
/**
 * ملف الاتصال الموحد بقاعدة البيانات (PDO)
 * العقل المدبر: Murtadha Abdulnoor Al-Sorori
 */

$host = 'sql301.byetcluster.com'; 
$db_name = 'if0_41922795_monitoring_db'; 
$username = 'if0_41922795'; 
$password ='mdgZGaww'; 'اكتب_هنا_كلمة_سر_حسابك_في_الاستضافة'; 

try {
    // إنشاء الاتصال مع ضبط الترميز للعربية utf8mb4
    $conn = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8mb4", $username, $password);
    
    // ضبط وضع الأخطاء (مهم جداً للمناقشة مع الدكتور)
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // ضبط جلب البيانات كمصفوفة مرتبطة (Associative Array)
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch(PDOException $e) {
    // في حالة الخطأ يظهر لنا السبب (سنخفيه لاحقاً عند نشر التطبيق للأمان)
    die("فشل الاتصال بالقاعدة: " . $e->getMessage());
}
?>
