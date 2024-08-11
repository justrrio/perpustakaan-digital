<?= $this->extend('layouts/auth-template'); ?>

<?= $this->section('content'); ?>
<div class="register-container">
    <div class="register-logo">
        <img src="/assets/logo-perpustal.png" alt="Logo" class="logo">
    </div>
    <div class="register-form">
        <div>
            <h1>Register</h1>
            <p>Silakan isi data Anda untuk membuat akun baru.</p>
            <form action="<?= base_url('/register-submit'); ?>" method="post">
                <?= csrf_field(); ?>

                <!-- USERNAME -->
                <div class="input-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" class="form-control <?= (isset($validation['username'])) ? 'is-invalid' : '' ?>" value="<?= old('username'); ?>" autofocus placeholder="Andi Prakoso">
                    <?php if (isset($validation['username'])) : ?>
                        <span style="color: red;"><?= $validation['username']; ?></span>
                    <?php endif; ?>
                </div>

                <!-- EMAIL -->
                <div class="input-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-control <?= (isset($validation['email'])) ? 'is-invalid' : '' ?>" value="<?= old('email'); ?>" placeholder="test@gmail.com">

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

                <!-- CONFIRM PASSWORD -->
                <div class="input-group d-block">
                    <div>
                        <label for="confirm-password" class="form-label">Confirm Password</label>
                    </div>
                    <div class="d-flex">
                        <input type="password" class="form-control <?= (isset($validation['confirm-password'])) ? 'is-invalid' : '' ?>" id="confirm-password" name="confirm-password" placeholder="*****">
                        <span class="input-group-text">
                            <i class="fa fa-eye" id="toggleConfirmPassword" style="cursor: pointer" onclick="togglePassword('confirm-password', 'toggleConfirmPassword')"></i>
                        </span>

                    </div>
                    <?php if (isset($validation['confirm-password'])) : ?>
                        <span style="color: red;"><?= $validation['confirm-password']; ?></span>
                    <?php endif; ?>
                </div>

                <div class="submit-group mt-4">
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

<script>
    function togglePassword(inputId, toggleId) {
        const passwordInput = document.getElementById(inputId);
        const togglePassword = document.getElementById(toggleId);

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            togglePassword.className = 'fa fa-eye-slash';
        } else {
            passwordInput.type = 'password';
            togglePassword.className = 'fa fa-eye';
        }
    }
</script>

</body>

</html>

<?= $this->endSection(); ?>