<?php
//fill the values
$host = 'host_name';
$dbname = 'dbname';
$username = 'username';
$password = 'pass';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    include 'error500.php';
    exit();
}
?>
