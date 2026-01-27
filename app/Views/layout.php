<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>La Tauge Gestion</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="favicon.ico">
    <link rel="stylesheet" href="css.css">
    <link rel="stylesheet" href="menu.css">
    <link rel="stylesheet" href="ajoutcss.css">

</head>

<body>
    <nav style="display: flex; align-items: center;">
        <a href="index.php" style="margin-right: 30px; flex-shrink: 0;">
            <img src="c.jpg" alt="Logo" style="height: 80px;">
        </a>
        <ul class="main-nav" style="flex-grow: 1;">

                <li><a href="chevaux_liste">Liste des chevaux</a></li>
                <li><a href="liste_clients">Liste des clients</a></li>
                <li><a href="cours">Cours</a></li>
        </ul>
    </nav>
<?= $this->renderSection('contenu') ?>
</body>

</html>