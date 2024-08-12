<?= $this->extend('layouts/page-template'); ?>

<?= $this->section('content'); ?>

<div class="mb-2 judul-page-buku">
    <p>Ubah Akun <span>User</span></p>
    <a class="btn btn-primary p-2 fs-6" href="<?= base_url("/user"); ?>">
        <i class="fa fa-arrow-left" aria-hidden="true"></i>
        <span class="ms-2" style="color: white;">Kembali</span>
    </a>
</div>

<div class="container-ubah">
    <?php if (session()->getFlashdata("message")) : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fa fa-check fs-5" aria-hidden="true"></i> <?= session()->getFlashdata("message"); ?>
            <button type="button" class="btn-close fs-5" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <div class="mb-3">
        <h1>Form</h1>
    </div>

    <form action="<?= base_url('/user/edit-user'); ?>" method="post">
        <?= csrf_field(); ?>

        <!-- USERNAME -->
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" id="username" name="username" class="form-control <?= (isset($validation['username'])) ? 'is-invalid' : '' ?>" value="<?= old('username', $user['username']); ?>" autofocus placeholder="Andi Prakoso">
            <?php if (isset($validation['username'])) : ?>
                <span style="color: red;"><?= $validation['username']; ?></span>
            <?php endif; ?>
        </div>

        <!-- EMAIL -->
        <div class="mb-3">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" class="form-control <?= (isset($validation['email'])) ? 'is-invalid' : '' ?>" value="<?= old('email', $user['email']); ?>" placeholder="test@gmail.com">

            <?php if (isset($validation['email'])) : ?>
                <span style="color: red;"><?= $validation['email']; ?></span>
            <?php endif; ?>
        </div>

        <button type="submit" class="btn btn-primary mt-2">
            <i class="fa fa-save" aria-hidden="true"></i>
            Simpan
        </button>
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