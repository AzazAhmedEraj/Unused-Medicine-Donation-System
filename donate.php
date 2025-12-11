<?php require 'php/config.php'; requireLogin(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donate Medicine - MedDonate</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/donate.css">
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
                <span></span><span></span><span></span>
            </label>
        </div>
    </header>

    <div class="dashboard-layout">
        <aside class="sidebar">
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="donate.php" class="active">Donate Medicine</a></li>
                <li><a href="request.php">Request Medicine</a></li>
                <li><a href="status.php">Status</a></li>
                <li><a href="inventory.php">Inventory</a></li>
            </ul>
        </aside>

        <main class="main-content dashboard-content">
            <section class="form-section">
                <div class="container">
                    <h2>Donate Unused Medicine</h2>
                    <?php if (isset($_GET['success'])): ?>
<div style="background:#d4edda;color:#155724;padding:15px;border-radius:8px;margin:20px 0;text-align:center;font-weight:600;border:1px solid #c3e6cb;">
    Success! Your submission has been received and is waiting for admin approval.
</div>
<?php endif; ?>
                    <form action="php/submit_donation.php" method="POST" enctype="multipart/form-data" class="donate-form">
                        <div class="form-group">
                            <label for="medicineName">Medicine Name:</label>
                            <input type="text" name="medicine_name" id="medicineName" placeholder="Enter medicine name" required>
                        </div>
                        <div class="form-group">
                            <label for="quantity">Quantity:</label>
                            <input type="number" name="quantity" id="quantity" min="1" placeholder="Enter quantity" required>
                        </div>
                        <div class="form-group">
                            <label for="expiryDate">Expiry Date:</label>
                            <input type="date" name="expiry_date" id="expiryDate">
                        </div>
                        <div class="form-group">
                            <label for="condition">Condition:</label>
                            <select name="condition" id="condition">
                                <option value="new">New</option>
                                <option value="opened">Opened</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="pickupAddress">Pickup Address:</label>
                            <textarea name="pickup_address" id="pickupAddress" placeholder="Enter pickup address" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="contactInfo">Contact Info:</label>
                            <input type="text" name="contact_info" id="contactInfo" placeholder="Enter contact info" required>
                        </div>
                        <div class="form-group">
                            <label for="file">Upload Photo:</label>
                            <input type="file" name="photo" id="photo" accept="file/*">
                            <input type="file" name="photo" id="photo" accept="file/*">

                        </div>
                        
                        <div class="form-group">
                            <label for="description">Additional Details:</label>
                            <textarea name="description" id="description" placeholder="Enter additional details"></textarea>
                        </div>
                        <p class="note">Your donation will help NGOs and individuals in need.</p>
                        <button type="submit" class="btn btn-primary">Submit Donation</button>
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

    <button id="backToTop" title="Go to top">
        <i class="fas fa-arrow-up"></i>
    </button>

    <script>
        // Mobile Menu Toggle
        const navToggle = document.getElementById('nav-toggle');
        const navLinks = document.querySelector('.nav-links');
        navToggle.addEventListener('change', () => {
            navLinks.style.display = navToggle.checked ? 'block' : 'none';
        });
        document.querySelectorAll('.nav-links a').forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth <= 767) {
                    navToggle.checked = false;
                    navLinks.style.display = 'none';
                }
            });
        });

        // Back to top
        const btn = document.getElementById('backToTop');
        window.addEventListener('scroll', () => btn.style.display = window.scrollY > 300 ? 'block' : 'none');
        btn.onclick = () => window.scrollTo({top: 0, behavior: 'smooth'});
    </script>
</body>
</html>