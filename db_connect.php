<?php
$host = 'srv1642.hstgr.io';
$dbname = 'u901317468_assetlab';
$username = 'u901317468_scientist';
$password = 'Assetlab.com_apoorv137';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    include 'error500.php';
    exit();
}
?>
