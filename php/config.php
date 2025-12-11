<?php
// PREVENT DOUBLE LOADING — THIS IS THE FIX
if (defined('DB_CONNECTED')) {
    return;
}
define('DB_CONNECTED', true);

session_start();

try {
    $pdo = new PDO('mysql:host=localhost;port=8889;dbname=meddonate;charset=utf8mb4', 'root', 'root');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Helper functions
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function requireLogin() {
    if (!isLoggedIn()) {
        header("Location: ../login.html");
        exit();
    }
}

function isAdmin() {
    return isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'admin';
}

function requireAdmin() {
    requireLogin();
    if (!isAdmin()) {
        header("Location: ../dashboard.html");
        exit();
    }
}
?>