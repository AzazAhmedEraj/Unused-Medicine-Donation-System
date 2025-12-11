<?php
require '../config.php';
requireAdmin(); // Only admin can use this

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
    exit();
}

$action = $_POST['action'] ?? '';
$id     = (int)($_POST['id'] ?? 0);

if ($id <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid ID']);
    exit();
}

switch ($action) {
    case 'approve_ngo':
    case 'reject_ngo':
        $status = ($action === 'approve_ngo') ? 'approved' : 'rejected';
        $stmt = $pdo->prepare("UPDATE users SET status = ? WHERE id = ? AND user_type = 'ngo'");
        $stmt->execute([$status, $id]);
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
        $don = $pdo->prepare("SELECT medicine_name, quantity FROM donations WHERE id = ?")->execute([$id]) ? $pdo->query("SELECT medicine_name, quantity FROM donations WHERE id = $id")->fetch() : null;
        if ($don) {
            $inv = $pdo->prepare("INSERT INTO inventory (medicine_name, quantity) VALUES (?, ?) ON DUPLICATE KEY UPDATE quantity = quantity + VALUES(quantity)");
            $inv->execute([$don['medicine_name'], $don['quantity']]);
        }
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
        $req = $pdo->query("SELECT medicine_name, quantity FROM requests WHERE id = $id")->fetch();
        if ($req) {
            $inv = $pdo->prepare("UPDATE inventory SET quantity = GREATEST(0, quantity - ?) WHERE medicine_name = ?");
            $inv->execute([$req['quantity'], $req['medicine_name']]);
        }
        echo json_encode(['success' => true]);
        break;

    case 'reject_request':
        $stmt = $pdo->prepare("UPDATE requests SET status = 'rejected' WHERE id = ?");
        $stmt->execute([$id]);
        echo json_encode(['success' => true]);
        break;

    default:
        echo json_encode(['success' => false, 'message' => 'Unknown action']);
}