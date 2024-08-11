<?= $this->extend('layouts/template'); ?>

<?= $this->section('content'); ?>

<link rel="stylesheet" href="style.css">

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="register-container">
        <div class="register-logo">
            <img src="/assets/logo-perpustal.png" alt="Logo" class="logo">
        </div>
        <div class="register-form">
            <div>
                <h1>Register</h1>
                <p>Silakan isi data Anda untuk membuat akun baru.</p>
                <form action="submit-register.php" method="post">
                    <div class="input-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" required>
                    </div>
                    <div class="input-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="input-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    <div class="input-group">
                        <label for="confirm-password">Confirm Password</label>
                        <input type="password" id="confirm-password" name="confirm-password" required>
                    </div>
                    <div class="submit-group">
                        <button type="submit">Register</button>
                    </div>
                    <p class="signup-link">Sudah punya akun? <a href="<?= base_url("/login"); ?>">Sign In</a></p>
                </form>
            </div>
            <div class="register-cover">
                <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.webp" class="img-fluid" alt="Sample image">
            </div>
        </div>
    </div>

</body>

</html>

<script src="script.js"></script>

<?= $this->endSection(); ?>