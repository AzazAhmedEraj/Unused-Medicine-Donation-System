<?php require 'php/config.php'; requireAdmin(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Assignment - MedDonate</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/delivery.css">
</head>
<body>
    <header class="navbar">
        <div class="container">
            <a href="index.php" class="logo">MedDonate Admin</a>
            <nav class="nav-links">
                <ul>
                    <li><a href="admin.php">Dashboard</a></li>
                    <li><a href="delivery.php" class="active">Delivery</a></li>
                    <li><a href="php/logout.php">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="dashboard-layout">
        <aside class="sidebar">
            <ul>
                <li><a href="admin.php">Dashboard</a></li>
                <li><a href="delivery.php" class="active">Delivery</a></li>
            </ul>
        </aside>

        <main class="main-content">
            <div class="container">
                <h2>Assign Delivery</h2>

                <div class="delivery-card">
                    <h3>Assign Delivery</h3>
                    <form id="assignForm">
                        <div class="form-group">
                            <label>Donation ID</label>
                            <input type="number" name="donation_id" placeholder="Donation ID" />
                        </div>
                        <div class="form-group">
                            <label>Request ID</label>
                            <input type="number" name="request_id" placeholder="Request ID" />
                        </div>
                        <div class="form-group">
                            <label>Assign To (User ID)</label>
                            <input type="number" name="volunteer_id" required />
                        </div>
                        <button type="submit" class="btn btn-primary">Assign Delivery</button>
                    </form>
                </div>
            </div>
        </main>
    </div>
</body>
</html>

<script>
document.getElementById('assignForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    formData.append('action', 'assign_delivery');

    fetch('php/admin/actions.php', {
        method: 'POST',
        body: formData
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            alert('Delivery assigned successfully!');
            this.reset();
        } else {
            alert('Error assigning delivery');
        }
    });
});
</script>