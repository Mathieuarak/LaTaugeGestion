<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">
    <title>La Tauge Gestion</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="shortcut icon" type="image/png" href="<?= base_url('favicon.ico') ?>">

    <link rel="stylesheet" href="<?= base_url('css.css') ?>?v=<?= time() ?>">
    <link rel="stylesheet" href="<?= base_url('menu.css') ?>?v=<?= time() ?>">
    <link rel="stylesheet" href="<?= base_url('ajoutcss.css') ?>?v=<?= time() ?>">

</head>

<body>
    
    <nav style="display: flex; align-items: center;">
        <a href="<?= base_url('index.php') ?>" style="margin-right: 30px; flex-shrink: 0;">
            <img src="<?= base_url('p.jpg') ?>" alt="Logo" style="height: 80px;">
        </a>
        <ul class="main-nav" style="flex-grow: 1;">
            <li><a href="<?= base_url('chevaux_liste') ?>">Liste des chevaux</a></li>
            <li><a href="<?= base_url('liste_clients') ?>">Liste des clients</a></li>
            <li><a href="<?= base_url('cours') ?>">Cours</a></li>
        </ul>
    </nav>

    <?= $this->renderSection('contenu') ?>
</body>

</html>
