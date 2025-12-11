<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $userType = $_POST['userType'] ?? 'individual';
    $org_name = ($userType === 'ngo') ? trim($_POST['org_name'] ?? '') : null;
    $proof_doc = null;

    // Handle file upload
    if ($userType === 'ngo' && isset($_FILES['proof_doc']) && $_FILES['proof_doc']['error'] === 0) {
        $uploadDir = '../uploads/proofs/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
        $proof_doc = $uploadDir . time() . '_' . basename($_FILES['proof_doc']['name']);
        move_uploaded_file($_FILES['proof_doc']['tmp_name'], $proof_doc);
    }

    $status = ($userType === 'ngo') ? 'pending' : 'approved';

    try {
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password, phone, address, user_type, org_name, proof_doc, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$name, $email, $password, $phone, $address, $userType, $org_name, $proof_doc, $status]);
        
        // Show success and redirect
        echo "<script>alert('Registration successful!'); window.location='../login.html';</script>";
    } catch (Exception $e) {
        echo "<script>alert('Email already exists!'); window.history.back();</script>";
    }
}
?>