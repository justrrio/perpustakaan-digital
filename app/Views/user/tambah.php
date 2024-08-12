<?= $this->extend('layouts/page-template'); ?>

<?= $this->section('content'); ?>

<div class="mb-2 judul-page-buku">
    <p>Tambah Akun <span>User</span></p>
    <a class="btn btn-primary p-2 fs-6" href="<?= base_url("/user"); ?>">
        <i class="fa fa-arrow-left" aria-hidden="true"></i>
        <span class="ms-2" style="color: white;">Kembali</span>
    </a>
</div>

<div class="container-tambah">
    <?php if (session()->getFlashdata("message")) : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fa fa-check fs-5" aria-hidden="true"></i> <?= session()->getFlashdata("message"); ?>
            <button type="button" class="btn-close fs-5" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <div class="mb-3">
        <h1>Form</h1>
    </div>

    <form action="<?= base_url('/user/tambah-user'); ?>" method="post">
        <?= csrf_field(); ?>

        <!-- USERNAME -->
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" id="username" name="username" class="form-control <?= (isset($validation['username'])) ? 'is-invalid' : '' ?>" value="<?= old('username'); ?>" autofocus placeholder="Andi Prakoso">
            <?php if (isset($validation['username'])) : ?>
                <span style="color: red;"><?= $validation['username']; ?></span>
            <?php endif; ?>
        </div>

        <!-- EMAIL -->
        <div class="mb-3">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" class="form-control <?= (isset($validation['email'])) ? 'is-invalid' : '' ?>" value="<?= old('email'); ?>" placeholder="test@gmail.com">

            <?php if (isset($validation['email'])) : ?>
                <span style="color: red;"><?= $validation['email']; ?></span>
            <?php endif; ?>
        </div>

        <!-- PASSWORD -->
        <div class="mb-3 d-block">
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
        <div class="mb-3 d-block">
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

        <button type="submit" class="btn btn-primary">Tambah Akun</button>
    </form>
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