<?php
// إجبار السيرفر على إرسال استجابة بصيغة JSON
header("Content-Type: application/json; charset=UTF-8");

// استدعاء ملف الاتصال الموحد (الخروج للمجلد الرئيسي أولاً عبر ..)
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

// التحقق من اكتمال البيانات الأساسية
if (empty($device_uid) || empty($sender) || empty($message)) {
    echo json_encode([
        "status" => "error",
        "message" => "المعطيات ناقصة: device_uid و sender و message مطلوبة."
    ]);
    exit;
}

try {
    // خطوة العقل المدبر: التطبيق يرسل الـ UID النصي، لكن السيرفر يبحث عن الـ ID الرقمي المرتبط به في قاعدة البيانات لضمان سرعة الاستعلامات ونظافة الهيكلة
    $stmt_device = $conn->prepare("SELECT id FROM devices WHERE device_unique_id = :uid LIMIT 1");
    $stmt_device->execute([':uid' => $device_uid]);
    $device = $stmt_device->fetch();

    if (!$device) {
        // إذا أرسل التطبيق رسائل لجهاز غير مسجل بعد، نرفض الطلب حمايةً للسيرفر وتطبيقاً لنصيحة صاحبك (سجل الجهاز أولاً)
        echo json_encode([
            "status" => "error",
            "message" => "خطأ: هذا الجهاز غير مسجل في النظام مسبقاً. قم بعمل Register أولاً."
        ]);
        exit;
    }

    // الحصول على الرقم التعريفي الداخلي للجهاز
    $device_id = $device['id'];

    // إدخال رسالة الـ SMS في جدول sms_logs مربوطة بالـ device_id الرقمي
    $sql = "INSERT INTO sms_logs (device_id, sender, message, created_at) 
            VALUES (:device_id, :sender, :message, NOW())";
            
    $stmt_insert = $conn->prepare($sql);
    $stmt_insert->execute([
        ':device_id' => $device_id,
        ':sender'    => $sender,
        ':message'   => $message
    ]);

    // إرجاع استجابة نجاح بصيغة JSON مرتبة
    echo json_encode([
        "status" => "success",
        "message" => "تم حفظ رسالة الـ SMS بنجاح وربطها بالجهاز."
    ]);

} catch (PDOException $e) {
    echo json_encode([
        "status" => "error",
        "message" => "خطأ في قاعدة البيانات: " . $e->getMessage()
    ]);
}
?>
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

// التحقق من اكتمال البيانات الأساسية
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
            "message" => "خطأ: هذا الجهاز غير مسجل في النظام مسبقاً."
        ]);
        exit;
    }

    $device_id = $device['id'];

    // التعديل هنا: استخدام message_body ليطابق اسم العمود في phpMyAdmin
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

// التحقق من اكتمال البيانات الأساسية
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
            "message" => "خطأ: هذا الجهاز غير مسجل في النظام مسبقاً."
        ]);
        exit;
    }

    $device_id = $device['id'];

    // التعديل هنا: استخدام message_body ليطابق اسم العمود في phpMyAdmin
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
