<?php
require 'config.php';
requireLogin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../donate.php");
    exit();
}

try {
    $medicine   = trim($_POST['medicine_name']);
    $quantity   = (int)$_POST['quantity'];
    $expiry     = !empty($_POST['expiry_date']) ? $_POST['expiry_date'] : null;
    $condition  = $_POST['condition'] ?? 'new';
    $address    = trim($_POST['pickup_address']);
    $contact    = trim($_POST['contact_info']);
    $desc       = trim($_POST['description'] ?? '');
    $photo      = null;

    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === 0) {
        $dir = '../uploads/donations/';
        if (!is_dir($dir)) mkdir($dir, 0755, true);
        $photo = $dir . time() . '_' . basename($_FILES['photo']['name']);
        move_uploaded_file($_FILES['photo']['tmp_name'], $photo);
    }

    $stmt = $pdo->prepare("INSERT INTO donations (user_id, medicine_name, quantity, expiry_date, photo, pickup_address, contact_info, description, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'pending')");
    $stmt->execute([$_SESSION['user_id'], $medicine, $quantity, $expiry, $photo, $address, $contact, $desc]);

    header("Location: ../donate.php?success=1");
    exit();

} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
?>