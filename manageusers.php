<?php
require 'php/config.php';
requireAdmin();

// Get all users (except admin)
$stmt = $pdo->prepare("
    SELECT id, name, email, phone, created_at, status, user_type, org_name 
    FROM users 
    WHERE email != 'admin@meddonate.com' 
    ORDER BY created_at DESC
");
$stmt->execute();
$users = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users - MedDonate Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/manageusers.css">
</head>
<body>

<header class="navbar">
    <div class="container">
        <a href="index.php" class="logo">MedDonate Admin</a>
        <nav class="nav-links">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="php/logout.php">Logout</a></li>
            </ul>
        </nav>
    </div>
</header>

<div class="dashboard-layout">
    <aside class="sidebar">
        <ul>
            <li><a href="admin.php">Dashboard</a></li>
            <li><a href="approvals.php">Requests & Donations</a></li>
            <li><a href="ngo-approval.php">NGO Approval</a></li>
            <li><a href="manageusers.php" class="active">Manage Users</a></li>
        </ul>
    </aside>

    <main class="main-content">
        <div class="container">
            <h2>Manage Users</h2>

            <div class="table-container">
                <table class="users-table">
                    <thead>
                        <tr>
                            <th>Name / Org</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Joined</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $u): ?>
                        <tr id="user-<?php echo $u['id']; ?>">
                            <td>
                                <strong>
                                    <?php echo $u['user_type'] === 'ngo' ? htmlspecialchars($u['org_name']) : htmlspecialchars($u['name']); ?>
                                </strong>
                            </td>
                            <td><?php echo htmlspecialchars($u['email']); ?></td>
                            <td><?php echo htmlspecialchars($u['phone']); ?></td>
                            <td><?php echo ucfirst($u['user_type']); ?></td>
                            <td>
                                <span class="status <?php echo $u['status']; ?>">
                                    <?php echo ucfirst($u['status']); ?>
                                </span>
                            </td>
                            <td><?php echo date('d M Y', strtotime($u['created_at'])); ?></td>
                            <td>
                                <?php if ($u['status'] !== 'blocked'): ?>
                                    <button class="btn-reject" onclick="blockUser(<?php echo $u['id']; ?>)">
                                        Block
                                    </button>
                                <?php else: ?>
                                    <em>Blocked</em>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="back-btn">
                <a href="admin.php">Back to Dashboard</a>
            </div>
        </div>
    </main>
</div>

<footer class="footer">
    <div class="container">
        <p>© 2025 MedDonate. All rights reserved.</p>
    </div>
</footer>

<script>
function blockUser(id) {
    if (!confirm("Block this user? They will no longer be able to log in.")) return;

    fetch('php/admin/actions.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'action=block_user&id=' + id
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            document.getElementById('user-' + id).querySelector('.status').textContent = 'blocked';
            document.getElementById('user-' + id).querySelector('button').outerHTML = '<em>Blocked</em>';
            alert("User blocked successfully");
        }
    });
}
</script>
</body>
</html>