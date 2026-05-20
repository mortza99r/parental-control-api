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
