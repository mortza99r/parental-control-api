<?php
// إجبار السيرفر على إرسال استجابة بصيغة JSON
header("Content-Type: application/json; charset=UTF-8");

// استدعاء ملف الاتصال الموحد
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
$sender = isset($_POST['sender']) ? trim($_POST['sender']) : null;
$message = isset($_POST['message']) ? trim($_POST['message']) : null;

// 🔥 تم إصلاح الخطأ البرمجي هنا (إضافة علامة ||)
if (empty($device_uid) || empty($sender) || empty($message)) {
    echo json_encode([
        "status" => "error",
        "message" => "المعطيات ناقصة: device_uid و sender و message مطلوبة."
    ]);
    exit;
}

try {
    // جلب الـ id الرقمي الخاص بالجهاز بواسطة الـ UID
    $stmt_device = $conn->prepare("SELECT id FROM devices WHERE device_unique_id = :uid LIMIT 1");
    $stmt_device->execute([':uid' => $device_uid]);
    $device = $stmt_device->fetch();

    if (!$device) {
        echo json_encode([
            "status" => "error",
            "message" => "خطأ: هذا الجهاز غير مسجل في النظام مسبقاً. قم بعمل Register أولاً."
        ]);
        exit;
    }

    $device_id = $device['id'];

    // 🔥 خطوة الخطة الاحترافية: التحقق من عدم وجود الرسالة مسبقاً لمنع التكرار
    $check_sql = "SELECT id FROM sms_logs 
                  WHERE device_id = :device_id 
                  AND sender = :sender 
                  AND message_body = :message 
                  AND created_at >= NOW() - INTERVAL 10 MINUTE 
                  LIMIT 1";
    $stmt_check = $conn->prepare($check_sql);
    $stmt_check->execute([
        ':device_id' => $device_id,
        ':sender'    => $sender,
        ':message'   => $message
    ]);

    if ($stmt_check->fetch()) {
        // إذا الرسالة مكررة، نرد بنجاح عشان الأندرويد يحذفها من عنده وما يعيد إرسالها
        echo json_encode([
            "status" => "success",
            "message" => "الرسالة مكررة وتم حفظها مسبقاً."
        ]);
        exit;
    }

    // إدخال رسالة الـ SMS الجديدة
    $sql = "INSERT INTO sms_logs (device_id, sender, message_body, created_at) 
            VALUES (:device_id, :sender, :message, NOW())";
            
    $stmt_insert = $conn->prepare($sql);
    $stmt_insert->execute([
        ':device_id' => $device_id,
        ':sender'    => $sender,
        ':message'   => $message
    ]);

    echo json_encode([
        "status" => "success",
        "message" => "تم حفظ رسالة الـ SMS بنجاح وربطها بالجهاز المحفوظ."
    ]);

} catch (PDOException $e) {
    echo json_encode([
        "status" => "error",
        "message" => "خطأ في قاعدة البيانات: " . $e->getMessage()
    ]);
}
?>
