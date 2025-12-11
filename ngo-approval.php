<?php
require 'php/config.php';
requireAdmin();

// Fetch all pending NGOs with proof file
$stmt = $pdo->prepare("
    SELECT id, name, email, phone, org_name, proof_doc, created_at 
    FROM users 
    WHERE user_type = 'ngo' AND status = 'pending' 
    ORDER BY created_at DESC
");
$stmt->execute();
$pendingNGOs = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NGO Approval - MedDonate Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/ngo-approval.css">
</head>
<body>

<header class="navbar">
    <div class="container">
        <a href="index.php" class="logo"><i class="fas fa-heartbeat"></i> MedDonate Admin</a>
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
            <li><a href="ngo-approval.php" class="active">NGO Approval</a></li>
            <li><a href="manageusers.php">Manage Users</a></li>
        </ul>
    </aside>

    <main class="main-content">
        <div class="container">
            <h2>NGO / Organization Approval</h2>

            <?php if (empty($pendingNGOs)): ?>
                <div class="approval-card">
                    <p style="text-align:center; padding:40px; color:#666; font-size:1.1rem;">
                        No pending NGO registrations at the moment.
                    </p>
                </div>
            <?php else: ?>
                <div class="approval-card">
                    <h3>Pending NGO Registrations (<?php echo count($pendingNGOs); ?>)</h3>
                    <div class="table-container">
                        <table class="approval-table">
                            <thead>
                                <tr>
                                    <th>Organization</th>
                                    <th>Contact Person</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Applied On</th>
                                    <th>Proof</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pendingNGOs as $ngo): ?>
                                <tr id="ngo-<?php echo $ngo['id']; ?>">
                                    <td><strong><?php echo htmlspecialchars($ngo['org_name']); ?></strong></td>
                                    <td><?php echo htmlspecialchars($ngo['name']); ?></td>
                                    <td><?php echo htmlspecialchars($ngo['email']); ?></td>
                                    <td><?php echo htmlspecialchars($ngo['phone']); ?></td>
                                    <td><?php echo date('d M Y', strtotime($ngo['created_at'])); ?></td>
                                    <td>
                                        <?php if ($ngo['proof_doc'] && file_exists($ngo['proof_doc'])): ?>
                                            <a href="<?php echo $ngo['proof_doc']; ?>" target="_blank" class="proof-link">
                                                View File
                                            </a>
                                        <?php else: ?>
                                            <span style="color:#999;">No file</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="actions">
                                        <button class="btn-approve" onclick="handleNGO(<?php echo $ngo['id']; ?>, 'approve')">
                                            Approve
                                        </button>
                                        <button class="btn-reject" onclick="handleNGO(<?php echo $ngo['id']; ?>, 'reject')">
                                            Reject
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endif; ?>

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

<button id="backToTop" title="Go to top">
    <i class="fas fa-arrow-up"></i>
</button>

<script>
function handleNGO(id, action) {
    if (!confirm(`Are you sure you want to ${action} this NGO?`)) return;

    fetch('php/admin/actions.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `action=${action === 'approve' ? 'approve_ngo' : 'reject_ngo'}&id=${id}`
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            document.getElementById('ngo-' + id).remove();
            alert('NGO ' + (action === 'approve' ? 'approved' : 'rejected') + ' successfully!');
        } else {
            alert('Error: ' + (data.message || 'Unknown'));
        }
    });
}

// Back to top
const btn = document.getElementById('backToTop');
window.addEventListener('scroll', () => btn.style.display = window.scrollY > 300 ? 'block' : 'none');
btn.onclick = () => window.scrollTo({top: 0, behavior: 'smooth'});
</script>
</body>
</html>