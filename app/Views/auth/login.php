<?= $this->extend('layouts/template'); ?>

<?= $this->section('content'); ?>

<link rel="stylesheet" href="style.css">

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="login-container">
        <div class="login-logo">
            <img src="/assets/logo-perpustal.png" alt="Logo" class="logo">
        </div>
        <div class="login-form">
            <div>
                <h1>Login</h1>
                <p>Harap masukkan data akun Anda.</p>
                <form action="submit-login.php" method="post">
                    <div class="input-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="input-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    <!-- <div class="options">
                        <div class="remember-me">
                            <input type="checkbox" id="remember" name="remember" value="remember">
                            <label for="remember">Remember me for 60 days</label>
                        </div>
                        <a href="#">Forgot password?</a>
                    </div> -->
                    <div class="submit-group">
                        <button type="submit">Sign In</button>
                    </div>
                    <p class="signup-link">Tidak punya akun? <a href="<?= base_url("/register"); ?>">Sign Up</a></p>
                </form>
            </div>
            <div class="register-cover">
                <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw1.webp" class="img-fluid" alt="Sample image">
            </div>
        </div>
    </div>
</body>

</html>

<script src="script.js"></script>

<?= $this->endSection(); ?>