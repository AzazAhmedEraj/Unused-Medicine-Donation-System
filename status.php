<?php require 'php/config.php'; requireLogin(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Status - MedDonate</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/status.css">
</head>
<body>
    <header class="navbar">
        <div class="container">
            <a href="index.php" class="logo">MedDonate</a>
            <nav class="nav-links">
                <ul>
                    <li><a href="dashboard.php">Dashboard</a></li>
                    <li><a href="donate.php">Donate</a></li>
                    <li><a href="request.php">Request</a></li>
                    <li><a href="status.php" class="active">My Status</a></li>
                    <li><a href="inventory.php">Inventory</a></li>
                    <li><a href="php/logout.php">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="dashboard-layout">
        <aside class="sidebar">
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="donate.php">Donate Medicine</a></li>
                <li><a href="request.php">Request Medicine</a></li>
                <li><a href="status.php" class="active">My Status</a></li>
                <li><a href="inventory.php">Public Inventory</a></li>
            </ul>
        </aside>

        <main class="main-content">
            <div class="container">
                <h2>My Donation & Request Status</h2>

                <?php
                $userId = $_SESSION['user_id'];

                $donations = $pdo->prepare("SELECT medicine_name, quantity, status, created_at FROM donations WHERE user_id = ? ORDER BY created_at DESC");
                $donations->execute([$userId]);
                $donations = $donations->fetchAll();

                $requests = $pdo->prepare("SELECT medicine_name, quantity, status, created_at FROM requests WHERE user_id = ? ORDER BY created_at DESC");
                $requests->execute([$userId]);
                $requests = $requests->fetchAll();
                ?>

                <!-- My Donations -->
                <div class="status-card">
                    <h3>My Donations</h3>
                    <?php if (empty($donations)): ?>
                        <p class="no-data">No donations yet</p>
                    <?php else: ?>
                        <div class="table-container">
                            <table class="status-table">
                                <thead>
                                    <tr>
                                        <th>Medicine</th>
                                        <th>Quantity</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($donations as $d): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($d['medicine_name']); ?></td>
                                        <td><?php echo $d['quantity']; ?></td>
                                        <td><span class="status-badge <?php echo $d['status']; ?>"><?php echo ucfirst($d['status']); ?></span></td>
                                        <td><?php echo date('d M Y', strtotime($d['created_at'])); ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- My Requests -->
                <div class="status-card">
                    <h3>My Requests</h3>
                    <?php if (empty($requests)): ?>
                        <p class="no-data">No requests yet</p>
                    <?php else: ?>
                        <div class="table-container">
                            <table class="status-table">
                                <thead>
                                    <tr>
                                        <th>Medicine</th>
                                        <th>Quantity</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($requests as $r): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($r['medicine_name']); ?></td>
                                        <td><?php echo $r['quantity']; ?></td>
                                        <td><span class="status-badge <?php echo $r['status']; ?>"><?php echo ucfirst($r['status']); ?></span></td>
                                        <td><?php echo date('d M Y', strtotime($r['created_at'])); ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>

    <footer class="footer">
        <div class="container">
            <p>© 2025 MedDonate. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>