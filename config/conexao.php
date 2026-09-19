<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
try {
    $pdo = new PDO("mysql:host=localhost;dbname=gestao_doacoes;charset=utf8mb4", "root", "", [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) { die("Erro na conexão: " . $e->getMessage()); }
?>