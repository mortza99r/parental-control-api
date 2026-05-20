<?php
session_start();

if (!isset($_SESSION['device_id'])) {
    header("Location: index.php");
    exit;
}

$parentName = $_SESSION['parent_name'];
$deviceName = $_SESSION['device_name'];
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>لوحة التحكم</title>

<style>

body{
    background:#0f172a;
    font-family:Tahoma;
    margin:0;
    color:white;
}

.container{
    width:90%;
    max-width:900px;
    margin:auto;
    margin-top:40px;
}

.header{
    background:#1e293b;
    padding:25px;
    border-radius:20px;
    margin-bottom:25px;
}

h1{
    margin:0;
}

.cards{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:20px;
}

.card{
    background:#1e293b;
    padding:25px;
    border-radius:18px;
    text-decoration:none;
    color:white;
    transition:0.3s;
    box-shadow:0 0 15px rgba(0,0,0,0.3);
}

.card:hover{
    transform:translateY(-5px);
    background:#334155;
}

.card h2{
    margin-top:0;
    margin-bottom:10px;
}

.logout{
    margin-top:30px;
    display:inline-block;
    background:#dc2626;
    color:white;
    padding:14px 20px;
    border-radius:10px;
    text-decoration:none;
}

.logout:hover{
    background:#b91c1c;
}

</style>

</head>

<body>

<div class="container">

    <div class="header">
        <h1>مرحباً <?php echo htmlspecialchars($parentName); ?></h1>

        <p>
            الجهاز المرتبط:
            <?php echo htmlspecialchars($deviceName); ?>
        </p>
    </div>

    <div class="cards">

        <a class="card" href="devices.php">
            <h2>الأجهزة</h2>
            <p>عرض الأجهزة المسجلة</p>
        </a>

        <a class="card" href="sms_logs.php">
            <h2>سجل الرسائل</h2>
            <p>عرض رسائل SMS المستلمة</p>
        </a>

        <a class="card" href="commands.php">
            <h2>الأوامر</h2>
            <p>إرسال أوامر للجهاز</p>
        </a>

        <a class="card" href="screenshots.php">
            <h2>الصور</h2>
            <p>عرض صور الشاشة المرفوعة</p>
        </a>

    </div>

    <a class="logout" href="logout.php">
        تسجيل خروج
    </a>

</div>

</body>
</html>
