<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">
    <title>La Tauge Gestion</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" type="image/png" href="<?= base_url('favicon.ico') ?>">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="<?= base_url('css.css') ?>?v=<?= time() ?>">
    <link rel="stylesheet" href="<?= base_url('menu.css') ?>?v=<?= time() ?>">
    <link rel="stylesheet" href="<?= base_url('ajoutcss.css') ?>?v=<?= time() ?>">

</head>

<script>
    function toggleMenu() {
        document.querySelector('.main-nav').classList.toggle('active');
    }
</script>


<body>

    <nav class="nav-wrap">

        <div class="brand">
            <a href="<?= base_url('index.php') ?>">
                <img src="<?= base_url('p.jpg') ?>" alt="Logo">
            </a>
        </div>

        <button class="menu-toggle" onclick="toggleMenu()">☰</button>

        <ul class="main-nav">
            <li><a href="<?= base_url('chevaux_liste') ?>">Liste des chevaux</a></li>
            <li><a href="<?= base_url('liste_clients') ?>">Liste des clients</a></li>
            <li><a href="<?= base_url('cours') ?>">Cours</a></li>
            <li class="push">
                <a href="<?= base_url('logout') ?>" class="primary">Déconnexion</a>
            </li>
        </ul>


    </nav>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <?= $this->renderSection('contenu') ?>
</body>

</html>