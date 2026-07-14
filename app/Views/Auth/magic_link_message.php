<?= $this->extend('Auth/layout') ?>

<?= $this->section('title') ?><?= lang('Auth.useMagicLink') ?><?= $this->endSection() ?>

<?= $this->section('main') ?>

<div class="auth-card">
    <h5 class="card-title"><?= lang('Auth.useMagicLink') ?></h5>

    <p><b><?= lang('Auth.checkYourEmail') ?></b></p>

    <p class="mb-0"><?= lang('Auth.magicLinkDetails', [setting('Auth.magicLinkLifetime') / 60]) ?></p>
</div>

<?= $this->endSection() ?>
