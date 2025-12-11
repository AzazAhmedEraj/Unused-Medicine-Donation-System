<?php
require 'php/config.php';
requireAdmin();

// LIVE STATS FROM DATABASE
$pendingDonations = $pdo->query("SELECT COUNT(*) FROM donations WHERE status = 'pending'")->fetchColumn();
$pendingRequests  = $pdo->query("SELECT COUNT(*) FROM requests WHERE status = 'pending'")->fetchColumn();
$pendingNGOs      = $pdo->query("SELECT COUNT(*) FROM users WHERE user_type = 'ngo' AND status = 'pending'")->fetchColumn();
$totalUsers       = $pdo->query("SELECT COUNT(*) FROM users WHERE email != 'admin@meddonate.com'")->fetchColumn();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MedDonate - Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>

<header class="navbar">
    <div class="container">
        <a href="index.php" class="logo">
            <i class="fas fa-heartbeat"></i> MedDonate Admin
        </a>
        <nav class="nav-links">
            <ul>
                <li><a href="index.php"><i class="fas fa-home"></i> Home</a></li>
                <li><a href="php/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </nav>
    </div>
</header>

<div class="dashboard-layout">
    <aside class="sidebar">
        <ul>
            <li><a href="admin.php" class="active"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
            <li><a href="approvals.php"><i class="fas fa-clipboard-check"></i> Requests & Donations</a></li>
            <li><a href="ngo-approval.php"><i class="fas fa-building"></i> NGO Approval</a></li>
            <li><a href="manageusers.php"><i class="fas fa-users-cog"></i> Manage Users</a></li>
        </ul>
    </aside>

    <main class="main-content">
        <div class="container">
            <h2>Welcome back, Admin</h2>
            <p class="subtitle">Here’s what’s happening today — <strong>Live Data</strong></p>

            <div class="stats-grid">
                <div class="stat-card">
                    <i class="fas fa-gift"></i>
                    <h4>Pending Donations</h4>
                    <p class="big-num"><?php echo $pendingDonations; ?></p>
                </div>
                <div class="stat-card">
                    <i class="fas fa-hand-holding-medical"></i>
                    <h4>Pending Requests</h4>
                    <p class="big-num"><?php echo $pendingRequests; ?></p>
                </div>
                <div class="stat-card">
                    <i class="fas fa-building"></i>
                    <h4>Pending NGOs</h4>
                    <p class="big-num"><?php echo $pendingNGOs; ?></p>
                </div>
                <div class="stat-card">
                    <i class="fas fa-users"></i>
                    <h4>Total Users</h4>
                    <p class="big-num"><?php echo $totalUsers; ?></p>
                </div>
            </div>

            <div class="quick-links">
                <a href="approvals.php" class="btn-large">Review Requests & Donations</a>
                <a href="ngo-approval.php" class="btn-large">Review NGO Applications</a>
            </div>
        </div>
    </main>
</div>

<footer class="footer">
    <div class="container">
        <p>© 2025 MedDonate. All rights reserved.</p>
    </div>
</footer>

<button id="backToTop" title="Go to top"><i class="fas fa-arrow-up"></i></button>

<script>
    document.getElementById('backToTop').onclick = () => window.scrollTo({top:0, behavior:'smooth'});
    window.addEventListener('scroll', () => {
        document.getElementById('backToTop').style.display = window.scrollY > 300 ? 'block' : 'none';
    });
</script>
</body>
</html>