<?= $this->extend('Auth/layout') ?>

<?= $this->section('title') ?><?= lang('Auth.useMagicLink') ?><?= $this->endSection() ?>

<?= $this->section('main') ?>

<div class="auth-card">
    <h5 class="card-title"><?= lang('Auth.useMagicLink') ?></h5>

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

    <form action="<?= url_to('magic-link') ?>" method="post">
        <?= csrf_field() ?>

        <!-- Email -->
        <div class="mb-3">
            <label for="email" class="form-label"><?= lang('Auth.email') ?></label>
            <input type="email" class="form-control" id="email" name="email" autocomplete="email"
                   value="<?= old('email', auth()->user()->email ?? null) ?>" required>
        </div>

        <div class="d-grid mt-4">
            <button type="submit" class="btn btn-primary"><?= lang('Auth.send') ?></button>
        </div>

    </form>

    <p class="auth-footer-link"><a href="<?= url_to('login') ?>"><?= lang('Auth.backToLogin') ?></a></p>
</div>

<?= $this->endSection() ?>
