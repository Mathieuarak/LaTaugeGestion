<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">
    <title>La Tauge Gestion</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

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
                        <a class="btn btn-logout ms-lg-3" href="<?= base_url('logout') ?>">
                            Déconnexion
                        </a>
                    </li>
                </ul>
            </div>

        </div>
    </nav>

    <main class="app-main">
        <?= $this->renderSection('contenu') ?>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
