<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MedDonate - Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/login.css">
</head>
<body>

<header class="navbar">
    <div class="container">
        <a href="index.html" class="logo">
            <i class="fas fa-heartbeat"></i> MedDonate
        </a>
        <button class="nav-toggle-btn" aria-label="Toggle menu">
            <span></span><span></span><span></span>
        </button>
        <nav class="nav-links">
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="about.html">About</a></li>
                <li><a href="contact.html">Contact</a></li>
                <li><a href="login.html" class="active">Login</a></li>
                <li><a href="register.html">Sign Up</a></li>
            </ul>
        </nav>
    </div>
</header>

<main class="main-content">
    <section class="form-section">
        <div class="container">
            <h2>Login to Your Account</h2>

            <form action="php/login.php" method="POST" id="loginForm" class="login-form">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" placeholder="Enter your email" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" placeholder="Enter your password" required>
                </div>

                <div class="form-group checkbox-group">
                    <label class="checkbox-container">
                        <input type="checkbox" name="remember">
                        <span class="checkmark"></span>
                        Remember me
                    </label>
                </div>

                <button type="submit" class="btn-primary">Login</button>
            </form>

            <p class="form-link">
                <a href="forgotpassword.html">Forgot password?</a>
            </p>
            <p class="form-link">
                New user? <a href="register.html">Register here</a>
            </p>
        </div>
    </section>
</main>

<footer class="footer">
    <div class="container">
        <p>© 2025 MedDonate. All rights reserved.</p>
    </div>
</footer>

<button id="backToTop" title="Go to top">
    <i class="fas fa-arrow-up"></i>
</button>

<script>
// Back to top
const btn = document.getElementById('backToTop');
window.addEventListener('scroll', () => {
    btn.style.display = window.scrollY > 300 ? 'block' : 'none';
});
btn.onclick = () => window.scrollTo({top: 0, behavior: 'smooth'});
</script>

</body>
</html>