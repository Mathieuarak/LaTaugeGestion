<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">
    <title><?= $this->renderSection('title') ?> — La Tauge Gestion</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script>
        (function () {
            try {
                var stored = localStorage.getItem('theme');
                var theme = stored || (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
                document.documentElement.setAttribute('data-theme', theme);
            } catch (e) {}
        })();
    </script>

    <link rel="shortcut icon" type="image/png" href="<?= base_url('favicon.ico') ?>">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="<?= base_url('nouveaucss.css') ?>?v=<?= time() ?>">

    <?= $this->renderSection('pageStyles') ?>

</head>

<body class="auth-body">

    <div class="auth-shell">
        <div class="auth-brand">
            <span class="brand-mark">LT</span>
            <span class="brand-text">La Tauge <span>Gestion</span></span>
        </div>

        <?= $this->renderSection('main') ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <?= $this->renderSection('pageScripts') ?>

</body>

</html>
