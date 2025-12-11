<?php
require 'php/config.php';
requireLogin();

$userId = $_SESSION['user_id'];

// Real counts
$donationsCount = $pdo->query("SELECT COUNT(*) FROM donations WHERE user_id = $userId")->fetchColumn();
$requestsCount  = $pdo->query("SELECT COUNT(*) FROM requests WHERE user_id = $userId")->fetchColumn();
$approvedDonations = $pdo->query("SELECT COUNT(*) FROM donations WHERE user_id = $userId AND status = 'approved'")->fetchColumn();
$approvedRequests  = $pdo->query("SELECT COUNT(*) FROM requests WHERE user_id = $userId AND status = 'approved'")->fetchColumn();

// Recent Activity
$activities = $pdo->query("
    SELECT 'Donation' as type, medicine_name as item, status, created_at FROM donations WHERE user_id = $userId
    UNION ALL
    SELECT 'Request' as type, medicine_name as item, status, created_at FROM requests WHERE user_id = $userId
    ORDER BY created_at DESC LIMIT 10
")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - MedDonate</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>

<header class="navbar">
    <div class="container">
        <a href="index.php" class="logo">MedDonate</a>
        <nav class="nav-links">
            <ul>
                <li><a href="dashboard.php" class="active">Dashboard</a></li>
                <li><a href="donate.php">Donate</a></li>
                <li><a href="request.php">Request</a></li>
                <li><a href="php/logout.php">Logout</a></li>
            </ul>
        </nav>
    </div>
</header>

<div class="dashboard-layout">
    <aside class="sidebar">
        <ul>
            <li><a href="dashboard.php" class="active">Dashboard</a></li>
            <li><a href="donate.php">Donate Medicine</a></li>
            <li><a href="request.php">Request Medicine</a></li>
            <li><a href="status.php">My Status</a></li>
            <li><a href="inventory.php">Public Inventory</a></li>
        </ul>
    </aside>

    <main class="main-content">
        <div class="container">
            <h2>Welcome back, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</h2>
            <p>You are logged in as <strong><?php echo $_SESSION['user_type'] === 'ngo' ? 'NGO / Organization' : 'Individual Donor'; ?></strong></p>

            <!-- Stats Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <i class="fas fa-gift"></i>
                    <h4>Total Donations</h4>
                    <p class="big-num"><?php echo $donationsCount; ?></p>
                </div>
                <div class="stat-card">
                    <i class="fas fa-check-circle" style="color:#28a745;"></i>
                    <h4>Approved Donations</h4>
                    <p class="big-num"><?php echo $approvedDonations; ?></p>
                </div>
                <div class="stat-card">
                    <i class="fas fa-hand-holding-medical"></i>
                    <h4>Total Requests</h4>
                    <p class="big-num"><?php echo $requestsCount; ?></p>
                </div>
                <div class="stat-card">
                    <i class="fas fa-check-circle" style="color:#28a745;"></i>
                    <h4>Approved Requests</h4>
                    <p class="big-num"><?php echo $approvedRequests; ?></p>
                </div>
            </div>

            <!-- Recent Activity Table -->
            <div class="activity-card">
                <h3>Recent Activity</h3>
                <?php if (empty($activities)): ?>
                    <p style="text-align:center; color:#666; padding:30px;">No activity yet. Start donating or requesting!</p>
                <?php else: ?>
                    <div class="table-container">
                        <table class="activity-table">
                            <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>Medicine</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($activities as $act): ?>
                                <tr>
                                    <td><strong><?php echo $act['type']; ?></strong></td>
                                    <td><?php echo htmlspecialchars($act['item']); ?></td>
                                    <td>
                                        <span class="status <?php echo $act['status']; ?>">
                                            <?php echo ucfirst($act['status']); ?>
                                        </span>
                                    </td>
                                    <td><?php echo date('d M Y', strtotime($act['created_at'])); ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>

            <div class="quick-actions">
                <a href="donate.php" class="btn btn-primary">Donate Medicine</a>
                <a href="request.php" class="btn btn-secondary">Request Medicine</a>
            </div>
        </div>
    </main>
</div>

<footer class="footer">
    <div class="container">
        <p>© 2025 MedDonate. All rights reserved.</p>
    </div>
</footer>

<style>
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 25px;
    margin: 30px 0;
}
.stat-card {
    background: white;
    padding: 25px;
    border-radius: 16px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    text-align: center;
    transition: transform 0.3s;
}
.stat-card:hover { transform: translateY(-5px); }
.stat-card i { font-size: 2.5rem; color: #4CAF50; margin-bottom: 15px; }
.stat-card h4 { margin: 10px 0; color: #333; }
.big-num { font-size: 2.5rem; font-weight: 700; color: #2e7d32; }

.activity-card {
    background: white;
    padding: 30px;
    border-radius: 16px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    margin-top: 30px;
}
.activity-card h3 { margin-bottom: 20px; color: #2e7d32; text-align: center; }

.table-container {
    overflow-x: auto;
}
.activity-table {
    width: 100%;
    border-collapse: collapse;
}
.activity-table th, .activity-table td {
    padding: 15px;
    text-align: left;
    border-bottom: 1px solid #eee;
}
.activity-table th {
    background: #f8f9fa;
    font-weight: 600;
    color: #333;
}
.activity-table tr:hover {
    background: #f8fff8;
}
.status {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 600;
}
.status.pending { background:#fff3cd; color:#856404; }
.status.approved { background:#d4edda; color:#155724; }
.status.rejected { background:#f8d7da; color:#721c24; }

.quick-actions {
    text-align: center;
    margin: 40px 0;
}
.quick-actions .btn {
    margin: 0 15px;
    padding: 14px 32px;
    font-size: 1.1rem;
}
</style>
</body>
</html>