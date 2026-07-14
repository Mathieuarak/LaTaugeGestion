<?= $this->extend('Auth/layout') ?>

<?= $this->section('title') ?><?= lang('Auth.login') ?><?= $this->endSection() ?>

<?= $this->section('main') ?>

<div class="auth-card">
    <h5 class="card-title"><?= lang('Auth.login') ?></h5>

    <?php if (session('error') !== null) : ?>
        <div class="alert alert-danger" role="alert"><?= esc(session('error')) ?></div>
    <?php elseif (session('errors') !== null) : ?>
        <div class="alert alert-danger" role="alert">
            <?php if (is_array(session('errors'))) : ?>
                <?php foreach (session('errors') as $error) : ?>
                    <?= esc($error) ?><br>
                <?php endforeach ?>
            <?php else : ?>
                <?= esc(session('errors')) ?>
            <?php endif ?>
        </div>
    <?php endif ?>

    <?php if (session('message') !== null) : ?>
        <div class="alert alert-success" role="alert"><?= esc(session('message')) ?></div>
    <?php endif ?>

    <form action="<?= url_to('login') ?>" method="post">
        <?= csrf_field() ?>

        <!-- Email -->
        <div class="mb-3">
            <label for="email" class="form-label"><?= lang('Auth.email') ?></label>
            <input type="email" class="form-control" id="email" name="email" inputmode="email" autocomplete="email" value="<?= old('email') ?>" required>
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label for="password" class="form-label"><?= lang('Auth.password') ?></label>
            <input type="password" class="form-control" id="password" name="password" inputmode="text" autocomplete="current-password" required>
        </div>

        <!-- Remember me -->
        <?php if (setting('Auth.sessionConfig')['allowRemembering']): ?>
            <div class="form-check mb-3">
                <input type="checkbox" name="remember" id="remember" class="form-check-input" <?php if (old('remember')): ?> checked<?php endif ?>>
                <label for="remember" class="form-check-label"><?= lang('Auth.rememberMe') ?></label>
            </div>
        <?php endif; ?>

        <div class="d-grid mt-4">
            <button type="submit" class="btn btn-primary"><?= lang('Auth.login') ?></button>
        </div>

        <?php if (setting('Auth.allowMagicLinkLogins')) : ?>
            <p class="auth-footer-link"><?= lang('Auth.forgotPassword') ?> <a href="<?= url_to('magic-link') ?>"><?= lang('Auth.useMagicLink') ?></a></p>
        <?php endif ?>

        <?php if (setting('Auth.allowRegistration')) : ?>
            <p class="auth-footer-link"><?= lang('Auth.needAccount') ?> <a href="<?= url_to('register') ?>"><?= lang('Auth.register') ?></a></p>
        <?php endif ?>

    </form>
</div>

<?= $this->endSection() ?>
