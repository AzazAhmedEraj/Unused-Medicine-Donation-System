<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MedDonate - Register</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/register.css">
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
                <li><a href="login.html">Login</a></li>
                <li><a href="register.html" class="active">Sign Up</a></li>
            </ul>
        </nav>
    </div>
</header>

<main class="main-content">
    <section class="form-section">
        <div class="container">
            <h2>Register as NGO or Individual</h2>

            <form action="php/register.php" method="POST" enctype="multipart/form-data" id="registerForm" class="registration-form">
                <!-- User Type -->
                <div class="form-group">
                    <label>User Type <span class="required">*</span></label>
                    <div class="radio-group">
                        <label><input type="radio" name="userType" value="individual" checked required> Individual</label>
                        <label><input type="radio" name="userType" value="ngo" required> NGO / Organization</label>
                    </div>
                </div>

                <!-- Name -->
                <div class="form-group">
                    <label>Full Name <span class="required">*</span></label>
                    <input type="text" name="name" placeholder="Enter your full name" required>
                </div>

                <!-- Email -->
                <div class="form-group">
                    <label>Email <span class="required">*</span></label>
                    <input type="email" name="email" placeholder="Enter your email" required>
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label>Password <span class="required">*</span></label>
                    <input type="password" name="password" id="password" placeholder="Enter your password" required minlength="6">
                </div>

                <!-- Confirm Password -->
                <div class="form-group">
                    <label>Confirm Password <span class="required">*</span></label>
                    <input type="password" id="confirmPassword" placeholder="Confirm your password" required>
                </div>

                <!-- Phone -->
                <div class="form-group">
                    <label>Phone Number <span class="required">*</span></label>
                    <input type="tel" name="phone" placeholder="01XXXXXXXXX" required>
                </div>

                <!-- Division -->
                <div class="form-group">
                    <label>Division <span class="required">*</span></label>
                    <select name="division" id="division" required>
                        <option value="">Select Division</option>
                        <option>Dhaka</option><option>Chattogram</option><option>Khulna</option>
                        <option>Rajshahi</option><option>Barishal</option><option>Sylhet</option>
                        <option>Rangpur</option><option>Mymensingh</option>
                    </select>
                </div>

                <!-- District -->
                <div class="form-group">
                    <label>District <span class="required">*</span></label>
                    <select name="district" id="district" required>
                        <option value="">Select District</option>
                    </select>
                </div>

                <!-- Address -->
                <div class="form-group">
                    <label>Detailed Address <span class="required">*</span></label>
                    <textarea name="address" placeholder="House/Road/Village, Area, Thana etc." required></textarea>
                </div>

                <!-- NGO Only Fields -->
                <div class="ngo-only">
                    <div class="form-group">
                        <label>Organization Name <span class="required">*</span></label>
                        <input type="text" name="org_name" placeholder="Enter organization name">
                    </div>
                    <div class="form-group">
                        <label>Registration Proof (PDF/Image) <span class="required">*</span></label>
                        <input type="file" name="proof_doc" accept=".pdf,.jpg,.jpeg,.png">
                    </div>
                </div>

                <!-- Terms Checkbox -->
                <div class="form-group checkbox-group">
                    <label class="checkbox-container">
                        <input type="checkbox" name="terms" required>
                        <span class="checkmark"></span>
                        I agree to the <a href="terms.html" target="_blank">terms and conditions</a>
                    </label>
                </div>

                <button type="submit" class="btn-primary">Submit Registration</button>
            </form>

            <p class="form-link">Already have an account? <a href="login.html">Login here</a></p>
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
// Full districts
const districts = {
    "Dhaka": ["Dhaka", "Faridpur", "Gazipur", "Gopalganj", "Kishoreganj", "Madaripur", "Manikganj", "Munshiganj", "Narayanganj", "Narsingdi", "Rajbari", "Shariatpur", "Tangail"],
    "Chattogram": ["Bandarban", "Brahmanbaria", "Chandpur", "Chattogram", "Cumilla", "Cox's Bazar", "Feni", "Khagrachhari", "Lakshmipur", "Noakhali", "Rangamati"],
    "Khulna": ["Bagerhat", "Chuadanga", "Jashore", "Jhenaidah", "Khulna", "Kushtia", "Magura", "Meherpur", "Narail", "Satkhira"],
    "Rajshahi": ["Bogura", "Chapainawabganj", "Joypurhat", "Naogaon", "Natore", "Pabna", "Rajshahi", "Sirajganj"],
    "Barishal": ["Barguna", "Barishal", "Bhola", "Jhalokati", "Patuakhali", "Pirojpur"],
    "Sylhet": ["Habiganj", "Moulvibazar", "Sunamganj", "Sylhet"],
    "Rangpur": ["Dinajpur", "Gaibandha", "Kurigram", "Lalmonirhat", "Nilphamari", "Panchagarh", "Rangpur", "Thakurgaon"],
    "Mymensingh": ["Jamalpur", "Mymensingh", "Netrokona", "Sherpur"]
};

document.getElementById('division').onchange = function() {
    const d = document.getElementById('district');
    d.innerHTML = '<option value="">Select District</option>';
    districts[this.value]?.forEach(dist => {
        const opt = document.createElement('option');
        opt.value = opt.textContent = dist;
        d.appendChild(opt);
    });
};

// Show/Hide NGO fields + make required
document.querySelectorAll('input[name="userType"]').forEach(radio => {
    radio.onchange = () => {
        const isNGO = radio.value === 'ngo';
        document.querySelectorAll('.ngo-only').forEach(el => {
            el.style.display = isNGO ? 'block' : 'none';
            el.querySelectorAll('input').forEach(inp => inp.required = isNGO);
        });
    };
});

// Password match check
document.getElementById('registerForm').onsubmit = function(e) {
    const pwd = this.password.value;
    const confirm = document.getElementById('confirmPassword').value;
    if (pwd !== confirm) {
        alert("Passwords do not match!");
        e.preventDefault();
    }
};

// Back to top
const btn = document.getElementById('backToTop');
window.addEventListener('scroll', () => btn.style.display = window.scrollY > 300 ? 'block' : 'none');
btn.onclick = () => window.scrollTo({top: 0, behavior: 'smooth'});
</script>

</body>
</html>