<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">
    <title>La Tauge Gestion</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" type="image/png" href="<?= base_url('favicon.ico') ?>">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="<?= base_url('nouveaucss.css') ?>?v=<?= time() ?>">

</head>


<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <div class="container">

        <a class="navbar-brand" href="<?= base_url('index.php') ?>">
            <img src="<?= base_url('p.jpg') ?>" alt="Logo" height="40">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('chevaux_liste') ?>">Liste des chevaux</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('liste_clients') ?>">Liste des clients</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('cours') ?>">Cours</a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-primary ms-lg-3" href="<?= base_url('logout') ?>">
                        Déconnexion
                    </a>
                </li>
            </ul>
        </div>

    </div>
</nav>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <?= $this->renderSection('contenu') ?>
</body>

</html>