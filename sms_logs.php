<?php
session_start();
include 'db_config.php';

if (!isset($_SESSION['device_id'])) {
    header("Location: index.php");
    exit;
}

$sql = "SELECT sms_logs.*, devices.child_name
        FROM sms_logs
        JOIN devices ON sms_logs.device_id = devices.id
        ORDER BY sms_logs.id DESC";

$stmt = $conn->query($sql);
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>سجل الرسائل</title>
<style>
body{
    background:#0f172a;
    color:white;
    font-family:Tahoma;
    margin:0;
    padding:20px;
}

h1{
    margin-bottom:20px;
}

a{
    color:white;
    text-decoration:none;
    background:#2563eb;
    padding:10px 16px;
    border-radius:10px;
}

.table-box{
    background:#1e293b;
    padding:20px;
    border-radius:20px;
    margin-top:20px;
}

.table{
    width:100%;
    border-collapse:collapse;
}

.table th,
.table td{
    padding:14px;
    border-bottom:1px solid #334155;
    text-align:center;
}

.table th{
    background:#334155;
}
</style>
</head>
<body>

<h1>سجل الرسائل المستلمة</h1>

<a href="dashboard.php">العودة للوحة الأجهزة</a>

<div class="table-box">
<table class="table">
<tr>
    <th>الجهاز</th>
    <th>المرسل</th>
    <th>الرسالة</th>
    <th>التاريخ</th>
</tr>

<?php foreach($messages as $msg): ?>
<tr>
    <td><?php echo $msg['child_name']; ?></td>
    <td><?php echo $msg['sender']; ?></td>
    <td><?php echo $msg['message_body']; ?></td>
    <td><?php echo $msg['created_at']; ?></td>
</tr>
<?php endforeach; ?>

</table>
</div>

</body>
</html>
