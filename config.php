<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


$host = 'sql113.infinityfree.com';
$dbname = 'if0_38057726_library';
$username = 'if0_38057726';
$password = 'ZPb3ArdLO5liBey';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password,array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
?>
