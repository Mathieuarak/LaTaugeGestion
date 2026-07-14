<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">
    <title>La Tauge Gestion</title>
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

</head>


<body>

    <nav class="navbar navbar-expand-lg app-navbar">
        <div class="container">

            <a class="navbar-brand" href="<?= base_url('index.php') ?>">
                <span class="brand-mark">LT</span>
                <span class="brand-text">La Tauge <span>Gestion</span></span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('chevaux_liste') ?>">Chevaux</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('liste_clients') ?>">Clients</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('cours') ?>">Cours</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= route_to('cours_calendrier') ?>">Calendrier</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= route_to('cours_impayes') ?>">Impayés</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-logout ms-lg-3" href="<?= base_url('logout') ?>">
                            Déconnexion
                        </a>
                    </li>
                    <li class="nav-item">
                        <button type="button" class="theme-toggle" id="themeToggle" aria-label="Changer de thème">
                            <span class="theme-icon-light">🌙</span>
                            <span class="theme-icon-dark">☀️</span>
                        </button>
                    </li>
                </ul>
            </div>

        </div>
    </nav>

    <?php
        $flashTypes = ['success' => 'Succès', 'error' => 'Erreur', 'warning' => 'Attention', 'info' => 'Info'];
        $flashes = [];
        foreach ($flashTypes as $key => $label) {
            $msg = session()->getFlashdata($key);
            if (!empty($msg) && is_string($msg)) {
                $flashes[] = ['type' => $key, 'message' => $msg];
            }
        }
    ?>
    <?php if (!empty($flashes)) : ?>
        <div class="toast-stack" id="toastStack">
            <?php foreach ($flashes as $flash) : ?>
                <div class="toast-item toast-<?= esc($flash['type']) ?>" role="status">
                    <span class="toast-icon">
                        <?= $flash['type'] === 'success' ? '✓' : ($flash['type'] === 'error' ? '✕' : ($flash['type'] === 'warning' ? '!' : 'i')) ?>
                    </span>
                    <span class="toast-msg"><?= esc($flash['message']) ?></span>
                    <button type="button" class="toast-close" aria-label="Fermer">&times;</button>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <main class="app-main">
        <?= $this->renderSection('contenu') ?>
    </main>

    <div class="confirm-overlay" id="confirmOverlay">
        <div class="confirm-box">
            <div class="confirm-title" id="confirmTitle">Confirmer</div>
            <div class="confirm-text" id="confirmText"></div>
            <div class="confirm-actions">
                <button type="button" class="btn btn-secondary" id="confirmCancel">Annuler</button>
                <button type="button" class="btn btn-danger" id="confirmOk">Confirmer</button>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            // --- Bascule mode sombre ---
            var themeBtn = document.getElementById('themeToggle');
            if (themeBtn) {
                themeBtn.addEventListener('click', function () {
                    var current = document.documentElement.getAttribute('data-theme') === 'dark' ? 'dark' : 'light';
                    var next = current === 'dark' ? 'light' : 'dark';
                    document.documentElement.setAttribute('data-theme', next);
                    try { localStorage.setItem('theme', next); } catch (e) {}
                });
            }

            // --- Notifications toast ---
            document.querySelectorAll('.toast-item').forEach(function (toast, i) {
                setTimeout(function () { toast.classList.add('toast-show'); }, 50 + i * 90);

                function dismiss() {
                    toast.classList.remove('toast-show');
                    toast.classList.add('toast-hide');
                    setTimeout(function () { toast.remove(); }, 260);
                }

                var closeBtn = toast.querySelector('.toast-close');
                if (closeBtn) closeBtn.addEventListener('click', dismiss);
                setTimeout(dismiss, 5200 + i * 90);
            });

            // --- Modale de confirmation (remplace confirm()) ---
            var overlay = document.getElementById('confirmOverlay');
            var titleEl = document.getElementById('confirmTitle');
            var textEl = document.getElementById('confirmText');
            var okBtn = document.getElementById('confirmOk');
            var cancelBtn = document.getElementById('confirmCancel');
            var pendingForm = null;

            function closeConfirm() {
                overlay.classList.remove('is-open');
                pendingForm = null;
            }

            document.querySelectorAll('form[data-confirm]').forEach(function (form) {
                form.addEventListener('submit', function (e) {
                    if (form.dataset.confirmed === 'true') { return; }
                    e.preventDefault();
                    pendingForm = form;
                    textEl.textContent = form.dataset.confirm;
                    titleEl.textContent = form.dataset.confirmTitle || 'Confirmer la suppression';
                    overlay.classList.add('is-open');
                });
            });

            if (cancelBtn) cancelBtn.addEventListener('click', closeConfirm);
            if (overlay) {
                overlay.addEventListener('click', function (e) {
                    if (e.target === overlay) closeConfirm();
                });
            }
            if (okBtn) {
                okBtn.addEventListener('click', function () {
                    if (pendingForm) {
                        pendingForm.dataset.confirmed = 'true';
                        pendingForm.submit();
                    }
                    closeConfirm();
                });
            }
        });
    </script>

</body>

</html>
