<?php
// استدعاء ملف الاتصال الموحد المربوط بـ Railway
// يرجى التأكد من المسار، إذا كان db_config خارج مجلد sms بمرتبة واحدة نستخدم ونكتب ../db_config.php
include_once __DIR__ . '/../db_config.php';

// ضبط نوع الرد ليكون JSON متناسق مع الأندرويد
header('Content-Type: application/json; charset=utf-8');

// استقبال البيانات بصيغة JSON القادمة من تطبيق الأندرويد
$inputData = file_get_contents('php://input');
$data = json_decode($inputData, true);

// التحقق من وصول البيانات المطلوبة
if (!isset($data['sender']) || !isset($data['message'])) {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => "بيانات ناقصة، لم يتم إرسال المرسل أو نص الرسالة"]);
    exit();
}

$sender = trim($data['sender']);
$message = trim($data['message']);

try {
    // 🔥 حجر الزاوية لمنع التكرار في السيرفر:
    // الفحص في قاعدة البيانات: هل تم استقبال نفس الرسالة من نفس الرقم خلال آخر 10 دقائق؟
    $checkSql = "SELECT id FROM sms_messages 
                 WHERE sender = :sender AND message = :message 
                 AND created_at >= NOW() - INTERVAL 10 MINUTE 
                 LIMIT 1";
                 
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->execute([
        ':sender' => $sender,
        ':message' => $message
    ]);

    if ($checkStmt->fetch()) {
        // الرسالة موجودة مسبقاً، نرد بالنجاح للأندرويد ليقوم بحذفها من المخزن المحلي ولا يعلق السيرفر بالتكرار
        http_response_code(200);
        echo json_encode(["status" => "success", "message" => "الرسالة مكررة ومحفوظة مسبقاً"]);
        exit();
    }

    // إذا لم تكن مكررة، نقوم بإدخالها مباشرة
    // يرجى التأكد من أن أسماء الأعمدة (sender, message) تطابق تماماً أسماء الأعمدة في جدولك
    $insertSql = "INSERT INTO sms_messages (sender, message) VALUES (:sender, :message)";
    $insertStmt = $conn->prepare($insertSql);
    
    $insertStmt->execute([
        ':sender' => $sender,
        ':message' => $message
    ]);

    http_response_code(200);
    echo json_encode(["status" => "success", "message" => "تم حفظ الرسالة بنجاح في قاعدة البيانات"]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => "خطأ في السيرفر: " . $e->getMessage()]);
}
?>
