<?= $this->extend('layouts/auth-template'); ?>

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

                <?php if (session()->getFlashdata("message")) : ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fa fa-check" aria-hidden="true"></i> <?= session()->getFlashdata("message"); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url("/login-submit"); ?>" method="post">
                    <?= csrf_field(); ?>

                    <!-- EMAIL -->
                    <div class="input-group">
                        <label for="email form-label">Email</label>
                        <input type="email" id="email" name="email" placeholder="test@gmail.com" class="form-control <?= (isset($validation['email'])) ? 'is-invalid' : '' ?>" autofocus>
                        <?php if (isset($validation['email'])) : ?>
                            <span style="color: red;"><?= $validation['email']; ?></span>
                        <?php endif; ?>
                    </div>

                    <!-- PASSWORD -->
                    <div class="input-group d-block">
                        <div>
                            <label for="password" class="form-label">Password</label>
                        </div>
                        <div class="d-flex">
                            <input type="password" class="form-control <?= (isset($validation['password'])) ? 'is-invalid' : '' ?>" id="password" name="password" placeholder="*****">
                            <span class="input-group-text">
                                <i class="fa fa-eye" id="togglePassword" style="cursor: pointer" onclick="togglePassword('password', 'togglePassword')"></i>
                            </span>
                        </div>

                        <?php if (isset($validation['password'])) : ?>
                            <span style="color: red;"><?= $validation['password']; ?></span>
                        <?php endif; ?>
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