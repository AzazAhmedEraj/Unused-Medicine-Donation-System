<?php
require 'config.php';
requireLogin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../request.php");
    exit();
}

try {
    $medicine      = trim($_POST['medicine_name']);
    $quantity      = (int)$_POST['quantity'];
    $reason        = trim($_POST['reason']);
    $address       = trim($_POST['delivery_address']);
    $urgency       = $_POST['urgency'] ?? 'medium';
    $beneficiaries = ($_SESSION['user_type'] === 'ngo') ? (int)($_POST['beneficiary_count'] ?? 0) : null;

    $stmt = $pdo->prepare("INSERT INTO requests (user_id, medicine_name, quantity, reason, delivery_address, urgency, beneficiary_count, status) VALUES (?, ?, ?, ?, ?, ?, ?, 'pending')");
    $stmt->execute([$_SESSION['user_id'], $medicine, $quantity, $reason, $address, $urgency, $beneficiaries]);

    header("Location: ../request.php?success=1");
    exit();

} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
?>