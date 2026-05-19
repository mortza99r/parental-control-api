<?php

include 'db_config.php';

$sql = file_get_contents('database.sql');

try {

    $conn->exec($sql);

    echo "DATABASE IMPORTED SUCCESSFULLY";

} catch(PDOException $e) {

    die("IMPORT ERROR: " . $e->getMessage());
}
?>
