<?php
header("Content-Type: application/json; charset=UTF-8");
include '../db_config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["status" => "error", "message" => "استخدم POST فقط."]);
    exit;
}

$command_id = isset($_POST['command_id']) ? intval($_POST['command_id']) : null;
$status = isset($_POST['status']) ? trim($_POST['status']) : null; // executed أو failed

if (empty($command_id) || !in_array($status, ['executed', 'failed'])) {
    echo json_encode(["status" => "error", "message" => "المعطيات غير صحيحة."]);
    exit;
}

try {
    $sql = "UPDATE commands SET status = :status WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':status' => $status,
        ':id' => $command_id
    ]);

    echo json_encode([
        "status" => "success",
        "message" => "تم تحديث حالة الأمر بنجاح."
    ]);

} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => "خطأ: " . $e->getMessage()]);
}
?>
