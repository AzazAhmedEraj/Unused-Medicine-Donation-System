<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email']);
    $password = $_POST['password'];

    // HARD-CODED ADMIN — WILL ALWAYS WORK
    if ($email === 'admin@meddonate.com' && $password === 'admin123') {
        $_SESSION['user_id']   = 999;
        $_SESSION['user_name'] = 'Administrator';
        $_SESSION['user_type'] = 'admin';
        header("Location: ../admin.php");
        exit();
    }

    // Normal users
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        if ($user['status'] === 'blocked') {
            echo "<script>alert('Account blocked'); window.location='../login.html';</script>";
            exit();
        }
        if ($user['user_type'] === 'ngo' && $user['status'] === 'pending') {
            echo "<script>alert('NGO pending approval'); window.location='../login.html';</script>";
            exit();
        }

        $_SESSION['user_id']   = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_type'] = $user['user_type'];

        // Also force admin if email matches (backup)
        if ($email === 'admin@meddonate.com') {
            $_SESSION['user_type'] = 'admin';
        }

        $redirect = ($_SESSION['user_type'] === 'admin') ? '../admin.html' : '../dashboard.php';
        header("Location: $redirect");
        exit();
    }

    echo "<script>alert('Invalid email or password!'); window.location='../login.html';</script>";
}
?>