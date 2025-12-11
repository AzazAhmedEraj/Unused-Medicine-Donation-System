<?php
require 'php/config.php';
requireAdmin();

// Pending Donations
$donStmt = $pdo->prepare("
    SELECT d.id, d.medicine_name, d.quantity, d.photo, d.created_at, u.name as donor_name, u.email as donor_email
    FROM donations d
    JOIN users u ON d.user_id = u.id
    WHERE d.status = 'pending'
    ORDER BY d.created_at DESC
");
$donStmt->execute();
$pendingDonations = $donStmt->fetchAll();

// Pending Requests
$reqStmt = $pdo->prepare("
    SELECT r.id, r.medicine_name, r.quantity, r.reason, r.created_at, u.name as requester_name, u.email as requester_email
    FROM requests r
    JOIN users u ON r.user_id = u.id
    WHERE r.status = 'pending'
    ORDER BY r.created_at DESC
");
$reqStmt->execute();
$pendingRequests = $reqStmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Requests & Donations Approval - MedDonate Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/approvals.css">
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
            <li><a href="approvals.php" class="active">Requests & Donations</a></li>
            <li><a href="ngo-approval.php">NGO Approval</a></li>
            <li><a href="manageusers.php">Manage Users</a></li>
        </ul>
    </aside>

    <main class="main-content">
        <div class="container">
            <h2>Requests & Donations Approval</h2>

            <!-- Pending Donations -->
            <div class="approval-card">
                <h3>Pending Donations (<?php echo count($pendingDonations); ?>)</h3>
                <?php if (empty($pendingDonations)): ?>
                    <p style="text-align:center; padding:40px; color:#666;">No pending donations</p>
                <?php else: ?>
                    <div class="table-container">
                        <table class="approval-table">
                            <thead>
                                <tr>
                                    <th>Medicine</th>
                                    <th>Qty</th>
                                    <th>Donor</th>
                                    <th>Photo</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pendingDonations as $d): ?>
                                <tr id="donation-<?php echo $d['id']; ?>">
                                    <td><strong><?php echo htmlspecialchars($d['medicine_name']); ?></strong></td>
                                    <td><?php echo $d['quantity']; ?></td>
                                    <td><?php echo htmlspecialchars($d['donor_name']); ?><br><small><?php echo htmlspecialchars($d['donor_email']); ?></small></td>
                                    <td>
                                        <?php if ($d['photo'] && file_exists($d['photo'])): ?>
                                            <a href="<?php echo $d['photo']; ?>" target="_blank">View Photo</a>
                                            <a href="<?php echo $d['photo']; ?>" target="_blank">View Photo</a>
                                        
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo date('d M Y', strtotime($d['created_at'])); ?></td>
                                    <td class="actions">
                                        <button class="btn-approve" onclick="handleDonation(<?php echo $d['id']; ?>, 'approve')">Approve</button>
                                        <button class="btn-reject" onclick="handleDonation(<?php echo $d['id']; ?>, 'reject')">Reject</button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Pending Requests -->
            <div class="approval-card">
                <h3>Pending Requests (<?php echo count($pendingRequests); ?>)</h3>
                <?php if (empty($pendingRequests)): ?>
                    <p style="text-align:center; padding:40px; color:#666;">No pending requests</p>
                <?php else: ?>
                    <div class="table-container">
                        <table class="approval-table">
                            <thead>
                                <tr>
                                    <th>Medicine</th>
                                    <th>Qty</th>
                                    <th>Requester</th>
                                    <th>Reason</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pendingRequests as $r): ?>
                                <tr id="request-<?php echo $r['id']; ?>">
                                    <td><strong><?php echo htmlspecialchars($r['medicine_name']); ?></strong></td>
                                    <td><?php echo $r['quantity']; ?></td>
                                    <td><?php echo htmlspecialchars($r['requester_name']); ?><br><small><?php echo htmlspecialchars($r['requester_email']); ?></small></td>
                                    <td><?php echo htmlspecialchars($r['reason']); ?></td>
                                    <td><?php echo date('d M Y', strtotime($r['created_at'])); ?></td>
                                    <td class="actions">
                                        <button class="btn-approve" onclick="handleRequest(<?php echo $r['id']; ?>, 'approve')">Approve</button>
                                        <button class="btn-reject" onclick="handleRequest(<?php echo $r['id']; ?>, 'reject')">Reject</button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
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
function handleDonation(id, action) {
    if (!confirm(`Are you sure to ${action} this donation?`)) return;

    fetch('php/admin/actions.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `action=${action === 'approve' ? 'approve_donation' : 'reject_donation'}&id=${id}`
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            document.getElementById('donation-' + id).remove();
            alert('Donation ' + action + 'd!');
        }
    });
}

function handleRequest(id, action) {
    if (!confirm(`Are you sure to ${action} this request?`)) return;

    fetch('php/admin/actions.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `action=${action === 'approve' ? 'approve_request' : 'reject_request'}&id=${id}`
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            document.getElementById('request-' + id).remove();
            alert('Request ' + action + 'd!');
        }
    });
}
</script>
</body>
</html>