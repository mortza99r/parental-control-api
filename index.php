<?php
session_start();
include 'db_config.php';

$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $parent_name = trim($_POST['parent_name']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT * FROM devices WHERE parent_password = :password LIMIT 1");
    $stmt->execute([
        ':password' => $password:
    ]);

    $device = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($device) {
        $_SESSION['parent_name'] = $parent_name;
        $_SESSION['device_id'] = $device['id'];
        $_SESSION['device_name'] = $device['child_name'];

        header("Location: dashboard.php");
        exit;
    } else {
        $error = "كلمة المرور غير صحيحة";
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>تسجيل دخول الأب</title>
<style>
body{
    background:#0f172a;
    font-family:Tahoma;
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
    margin:0;
}

.login-box{
    background:#1e293b;
    padding:35px;
    border-radius:20px;
    width:360px;
    box-shadow:0 0 20px rgba(0,0,0,0.4);
    color:white;
}

h1{
    text-align:center;
    margin-bottom:25px;
}

input{
    width:100%;
    padding:14px;
    margin-top:12px;
    border:none;
    border-radius:10px;
    background:#334155;
    color:white;
    font-size:15px;
}

button{
    width:100%;
    padding:14px;
    margin-top:20px;
    border:none;
    border-radius:10px;
    background:#2563eb;
    color:white;
    font-size:16px;
    cursor:pointer;
}

button:hover{
    background:#1d4ed8;
}

.error{
    background:#7f1d1d;
    padding:10px;
    margin-top:15px;
    border-radius:8px;
    text-align:center;
}
</style>
</head>
<body>

<div class="login-box">
    <h1>لوحة تحكم الأب</h1>

    <form method="POST">
        <input type="text" name="parent_name" placeholder="اسم الأب" required>

        <input type="password" name="password" placeholder="كلمة المرور القادمة من جهاز الابن" required>

        <button type="submit">دخول</button>
    </form>

    <?php if($error): ?>
        <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>
</div>

</body>
</html>
