
<?php
session_start();

if (!isset($_SESSION['device_id'])) {
    header("Location: index.php");
    exit;
}

include 'db_config.php';

$device_id = $_SESSION['device_id'];

$stmt = $conn->prepare("
    SELECT * FROM screenshots
    WHERE device_id = :device_id
    ORDER BY captured_at DESC
");

$stmt->execute([
    ':device_id' => $device_id
]);

$images = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>صور الشاشة</title>

<style>

body{
    background:#0f172a;
    font-family:Tahoma;
    margin:0;
    color:white;
}

.container{
    width:90%;
    margin:auto;
    margin-top:30px;
}

h1{
    text-align:center;
    margin-bottom:30px;
}

.grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(280px,1fr));
    gap:20px;
}

.card{
    background:#1e293b;
    padding:15px;
    border-radius:18px;
}

.card img{
    width:100%;
    border-radius:12px;
}

.date{
    margin-top:10px;
    color:#cbd5e1;
    font-size:14px;
}

.back{
    display:inline-block;
    margin-top:30px;
    background:#2563eb;
    color:white;
    padding:12px 18px;
    border-radius:10px;
    text-decoration:none;
}

</style>

</head>

<body>

<div class="container">

    <h1>صور الشاشة المرفوعة</h1>

    <div class="grid">

        <?php foreach($images as $img): ?>

            <div class="card">

                <img src="<?php echo $img['image_path']; ?>">

                <div class="date">
                    <?php echo $img['captured_at']; ?>
                </div>

            </div>

        <?php endforeach; ?>

    </div>

    <a class="back" href="dashboard.php">
        رجوع للوحة التحكم
    </a>

</div>

</body>
</html>
