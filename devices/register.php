<?php
    
// إجبار السيرفر على إرسال استجابة بصيغة JSON نظيفة
header("Content-Type: application/json; charset=UTF-8");

// استدعاء ملف الاتصال الموحد
include '../db_config.php';

// التأكد من أن الطلب قادم عبر POST وليس GET
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        "status" => "error",
        "message" => "طريقة الطلب غير مسموح بها. استخدم POST فقط."
    ]);
    exit;
}

// استقبال البيانات القادمة من التطبيق
$device_uid = isset($_POST['device_uid']) ? trim($_POST['device_uid']) : null;
$child_name = isset($_POST['child_name']) ? trim($_POST['child_name']) : null;
$android_version = isset($_POST['android_version']) ? trim($_POST['android_version']) : null;

// التحقق من وجود المعرف الفريد للجهاز (الأساس)
if (empty($device_uid)) {
    echo json_encode([
        "status" => "error",
        "message" => "المعطيات ناقصة: device_uid مطلوب."
    ]);
    exit;
}

try {
    // استعلام ذكي: إذا كان الجهاز جديداً يقوم بإدخاله، وإذا كان موجوداً مسبقاً يحدّث بياناته ووقت ظهوره
    $sql = "INSERT INTO devices (device_unique_id, child_name, android_version, last_seen) 
            VALUES (:uid, :name, :version, NOW()) 
            ON DUPLICATE KEY UPDATE 
            child_name = :name2, 
            android_version = :version2, 
            last_seen = NOW()";
            
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':uid' => $device_uid,
        ':name' => $child_name,
        ':version' => $android_version,
        ':name2' => $child_name,
        ':version2' => $android_version
    ]);

    // إرجاع نجاح العملية بصيغة JSON احترافية أمام الدكتور
    echo json_encode([
        "status" => "success",
        "message" => "تم تسجيل وتحديث بيانات الجهاز بنجاح في القاعدة"
    ]);

} catch (PDOException $e) {
    echo json_encode([
        "status" => "error",
        "message" => "خطأ في قاعدة البيانات: " . $e->getMessage()
    ]);
}
?>
