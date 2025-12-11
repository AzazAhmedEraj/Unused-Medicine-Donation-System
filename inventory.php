<?php require 'php/config.php'; requireLogin(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Public Inventory - MedDonate</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/inventory.css">
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
                    <li><a href="status.php">My Status</a></li>
                    <li><a href="inventory.php" class="active">Inventory</a></li>
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
                <li><a href="status.php">My Status</a></li>
                <li><a href="inventory.php" class="active">Public Inventory</a></li>
            </ul>
        </aside>

        <main class="main-content">
            <div class="container">
                <h2>Available Medicine Inventory</h2>
                <p>These medicines are currently available for approved requests</p>

                <?php
                $inventory = $pdo->query("SELECT medicine_name, quantity, last_updated FROM inventory WHERE quantity > 0 ORDER BY medicine_name")->fetchAll();
                ?>

                <?php if (empty($inventory)): ?>
                    <div class="status-card">
                        <p class="no-data">No medicine available in inventory yet.</p>
                    </div>
                <?php else: ?>
                    <div class="table-container">
                        <table class="inventory-table">
                            <thead>
                                <tr>
                                    <th>Medicine Name</th>
                                    <th>Available Quantity</th>
                                    <th>Last Updated</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($inventory as $item): ?>
                                <tr>
                                    <td><strong><?php echo htmlspecialchars($item['medicine_name']); ?></strong></td>
                                    <td><?php echo $item['quantity']; ?> units</td>
                                    <td><?php echo date('d M Y, h:i A', strtotime($item['last_updated'])); ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
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