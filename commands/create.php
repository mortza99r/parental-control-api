<?php
header("Content-Type: application/json; charset=UTF-8");
include '../db_config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["status" => "error", "message" => "استخدم POST فقط."]);
    exit;
}

// نستقبل الـ UID الخاص بالجهاز والأمر المطلوب
$device_uid = isset($_POST['device_uid']) ? trim($_POST['device_uid']) : null;
$command = isset($_POST['command']) ? trim($_POST['command']) : null;

if (empty($device_uid) || empty($command)) {
    echo json_encode(["status" => "error", "message" => "device_uid و command مطلوبان."]);
    exit;
}

try {
    // نجلب ID الجهاز من القاعدة
    $stmt_device = $conn->prepare("SELECT id FROM devices WHERE device_unique_id = :uid LIMIT 1");
    $stmt_device->execute([':uid' => $device_uid]);
    $device = $stmt_device->fetch();

    if (!$device) {
        echo json_encode(["status" => "error", "message" => "الجهاز غير مسجل."]);
        exit;
    }

    // إدخال الأمر الجديد في القاعدة بحالة pending افتراضياً
    $sql = "INSERT INTO commands (device_id, command, status, created_at) 
            VALUES (:device_id, :command, 'pending', NOW())";
            
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':device_id' => $device['id'],
        ':command'   => $command
    ]);

    echo json_encode([
        "status" => "success",
        "message" => "تم إنشاء الأمر بنجاح وهو الآن بانتظار التطبيق ليسحبه."
    ]);

} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => "خطأ: " . $e->getMessage()]);
}
?>
