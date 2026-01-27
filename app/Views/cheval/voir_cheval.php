<?= $this->extend('layout') ?>
<?= $this->section('contenu') ?>

<style>
    .cheval-card {
        max-width: 600px;
        margin: 40px auto;
        padding: 30px;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        font-family: Arial, sans-serif;
    }

    .cheval-card h1 {
        text-align: center;
        margin-bottom: 30px;
        color: #333;
        font-size: 24px;
    }

    .cheval-info {
        display: grid;
        grid-template-columns: 1fr 2fr;
        row-gap: 15px;
        column-gap: 15px;
        font-size: 16px;
    }

    .cheval-info span {
        font-weight: bold;
        color: #555;
        text-align: right;
        padding-right: 10px;
    }

    .cheval-info p {
        margin: 0;
        color: #222;
    }

    /* Responsive */
    @media(max-width: 500px) {
        .cheval-info {
            grid-template-columns: 1fr;
        }

        .cheval-info span {
            text-align: left;
            padding-right: 0;
        }
    }
</style>

<div class="cheval-card">
    <h1>Informations du cheval</h1>

    <div class="cheval-info">

        <span>Client :</span>
        <p><?= esc($client['nom'] . ' ' . $client['prenom']) ?></p>

        <span>Nom :</span>
        <p><?= esc($cheval['nom']) ?></p>

        <span>Numéro Sire :</span>
        <p><?= esc($cheval['numSire']) ?></p>

        <span>Date de naissance :</span>
        <p><?= esc($cheval['dateNaissance']) ?></p>

        <span>Date d'arrivée :</span>
        <p><?= esc($cheval['dateArrivee']) ?></p>

        <span>Dernier vaccin :</span>
        <p><?= esc($cheval['vaccin']) ?></p>
        
        <span>Prix pension :</span>
        <p>
            <?php
                $price = null;
                if (!empty($tarifs_cheval) && isset($tarifs_cheval['totalTarif'])) {
                    $price = $tarifs_cheval['totalTarif'];
                } elseif (!empty($tarif) && isset($tarif['tarifBase'])) {
                    $price = $tarif['tarifBase'];
                }
            ?>
            <?= $price !== null ? esc(number_format((float) $price, 2, ',', ' ')) . ' €' : '—' ?>
        </p>
    </div>
</div>

<?= $this->endSection() ?>
