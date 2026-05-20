<?php
session_start();
include 'db_config.php';

if (!isset($_SESSION['device_id'])) {
    header("Location: index.php");
    exit;
}

$stmt = $conn->query("SELECT * FROM devices ORDER BY id DESC");
$devices = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>الأجهزة المسجلة</title>
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

.top-bar{
    display:flex;
    justify-content:space-between;
    align-items:center;
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

<div class="top-bar">
    <h1>الأجهزة المسجلة</h1>

    <div>
        <a href="sms_logs.php">سجل الرسائل</a>
        <a href="logout.php">تسجيل خروج</a>
    </div>
</div>

<div class="table-box">
<table class="table">
<tr>
    <th>ID</th>
    <th>اسم الجهاز</th>
    <th>UID</th>
    <th>إصدار أندرويد</th>
    <th>وقت التسجيل</th>
</tr>

<?php foreach($devices as $device): ?>
<tr>
    <td><?php echo $device['id']; ?></td>
    <td><?php echo $device['child_name']; ?></td>
    <td><?php echo $device['device_unique_id']; ?></td>
    <td><?php echo $device['android_version']; ?></td>
    <td><?php echo $device['created_at']; ?></td>
</tr>
<?php endforeach; ?>

</table>
</div>

</body>
</html>
