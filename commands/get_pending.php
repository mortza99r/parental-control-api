<?php
header("Content-Type: application/json; charset=UTF-8");
include '../db_config.php';

// نستخدم GET هنا لأننا نطلب بيانات فقط
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    echo json_encode(["status" => "error", "message" => "استخدم GET فقط."]);
    exit;
}

$device_uid = isset($_GET['device_uid']) ? trim($_GET['device_uid']) : null;

if (empty($device_uid)) {
    echo json_encode(["status" => "error", "message" => "device_uid مطلوب."]);
    exit;
}

try {
    // جلب الأوامر التي حالتها pending فقط لهذا الجهاز
    $sql = "SELECT c.id, c.command 
            FROM commands c
            JOIN devices d ON c.device_id = d.id
            WHERE d.device_unique_id = :uid AND c.status = 'pending'
            ORDER BY c.created_at ASC";
            
    $stmt = $conn->prepare($sql);
    $stmt->execute([':uid' => $device_uid]);
    $commands = $stmt->fetchAll();

    echo json_encode([
        "status" => "success",
        "commands" => $commands
    ]);

} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => "خطأ: " . $e->getMessage()]);
}
?>
