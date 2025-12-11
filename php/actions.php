<?php
require 'config.php';
requireAdmin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    $id = (int) $_POST['id'];

    switch ($action) {
        case 'approve_ngo':
            $stmt = $pdo->prepare("UPDATE users SET status = 'approved' WHERE id = ? AND user_type = 'ngo'");
            $stmt->execute([$id]);
            echo json_encode(['success' => true]);
            break;

        case 'reject_ngo':
            $stmt = $pdo->prepare("UPDATE users SET status = 'rejected' WHERE id = ? AND user_type = 'ngo'");
            $stmt->execute([$id]);
            echo json_encode(['success' => true]);
            break;

        case 'block_user':
            $stmt = $pdo->prepare("UPDATE users SET status = 'blocked' WHERE id = ?");
            $stmt->execute([$id]);
            echo json_encode(['success' => true]);
            break;

        case 'approve_donation':
            $stmt = $pdo->prepare("UPDATE donations SET status = 'approved' WHERE id = ?");
            $stmt->execute([$id]);
            // Add to inventory
            $donStmt = $pdo->prepare("SELECT medicine_name, quantity FROM donations WHERE id = ?");
            $donStmt->execute([$id]);
            $don = $donStmt->fetch();
            $invStmt = $pdo->prepare("INSERT INTO inventory (medicine_name, quantity) VALUES (?, ?) ON DUPLICATE KEY UPDATE quantity = quantity + ?");
            $invStmt->execute([$don['medicine_name'], $don['quantity'], $don['quantity']]);
            echo json_encode(['success' => true]);
            break;

        case 'reject_donation':
            $stmt = $pdo->prepare("UPDATE donations SET status = 'rejected' WHERE id = ?");
            $stmt->execute([$id]);
            echo json_encode(['success' => true]);
            break;
        
        case 'approve_request':
            $stmt = $pdo->prepare("UPDATE requests SET status = 'approved' WHERE id = ?");
            $stmt->execute([$id]);
            // Subtract from inventory
            $reqStmt = $pdo->prepare("SELECT medicine_name, quantity FROM requests WHERE id = ?");
            $reqStmt->execute([$id]);
            $req = $reqStmt->fetch();
            $invStmt = $pdo->prepare("UPDATE inventory SET quantity = quantity - ? WHERE medicine_name = ? AND quantity >= ?");
            $invStmt->execute([$req['quantity'], $req['medicine_name'], $req['quantity']]);
            echo json_encode(['success' => true]);
            break;

        case 'reject_request':
            $stmt = $pdo->prepare("UPDATE requests SET status = 'rejected' WHERE id = ?");
            $stmt->execute([$id]);
            echo json_encode(['success' => true]);
            break;

        default:
            echo json_encode(['success' => false, 'message' => 'Invalid action']);
    }
}
?>