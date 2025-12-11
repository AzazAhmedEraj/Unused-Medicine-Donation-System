<?php require 'php/config.php'; requireLogin(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Medicine - MedDonate</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/request.css">
</head>
<body>
    <header class="navbar">
        <div class="container">
            <a href="index.php" class="logo">
                <i class="fas fa-heartbeat"></i> MedDonate
            </a>
            <input type="checkbox" id="nav-toggle" class="nav-toggle">
            <nav class="nav-links">
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="about.php">About</a></li>
                    <li><a href="contact.php">Contact</a></li>
                    <li><a href="profile.php">Profile</a></li>
                    <li><a href="php/logout.php" class="btn-secondary">Logout</a></li>
                </ul>
            </nav>
            <label for="nav-toggle" class="nav-toggle-label">
                <span></span>
                <span></span>
                <span></span>
            </label>
        </div>
    </header>

    <div class="dashboard-layout">
        <aside class="sidebar">
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="donate.php">Donate Medicine</a></li>
                <li><a href="request.php" class="active">Request Medicine</a></li>
                <li><a href="status.php">Status</a></li>
                <li><a href="inventory.php">Inventory</a></li>
            </ul>
        </aside>

        <main class="main-content dashboard-content">
            <section class="form-section">
                <div class="container">
                    <h2>Request Medicine</h2>
                    <?php if (isset($_GET['success'])): ?>
<div style="background:#d4edda;color:#155724;padding:15px;border-radius:8px;margin:20px 0;text-align:center;font-weight:600;border:1px solid #c3e6cb;">
    Success! Your submission has been received and is waiting for admin approval.
</div>
<?php endif; ?>
                    <form action="php/submit_request.php" method="POST" class="request-form" novalidate>
                        <div class="form-group">
                            <label for="medicineName">Medicine Name:</label>
                            <input type="text" name="medicine_name" id="medicineName" placeholder="Enter medicine name" required>
                        </div>
                        <div class="form-group">
                            <label for="quantity">Quantity Needed:</label>
                            <input type="number" name="quantity" id="quantity" min="1" placeholder="Enter quantity needed" required>
                        </div>
                        <div class="form-group">
                            <label for="reason">Reason:</label>
                            <textarea name="reason" id="reason" placeholder="Enter reason for request" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="deliveryAddress">Delivery Address:</label>
                            <textarea name="delivery_address" id="deliveryAddress" placeholder="Enter delivery address" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="urgency">Urgency:</label>
                            <select name="urgency" id="urgency" required>
                                <option value="low">Low</option>
                                <option value="medium">Medium</option>
                                <option value="high">High</option>
                            </select>
                        </div>
                        <?php if ($_SESSION['user_type'] === 'ngo'): ?>
                        <div class="form-group">
                            <label for="beneficiaryCount">Beneficiary Count (for NGOs):</label>
                            <input type="number" name="beneficiary_count" id="beneficiaryCount" min="1" placeholder="Enter beneficiary count" required>
                        </div>
                        <?php endif; ?>
                        <p class="note">Requests will be matched with available donations.</p>
                        <button type="submit" class="btn btn-primary">Submit Request</button>
                        <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
                    </form>
                </div>
            </section>
        </main>
    </div>

    <footer class="footer">
        <div class="container">
            <p>© 2025 MedDonate. All rights reserved.</p>
            <ul class="footer-links">
                <li><a href="about.php">About</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
            <div class="social-icons">
                <a href="#" class="social-icon">Twitter</a>
                <a href="#" class="social-icon">Facebook</a>
                <a href="#" class="social-icon">Instagram</a>
            </div>
        </div>
    </footer>
</body>
</html>