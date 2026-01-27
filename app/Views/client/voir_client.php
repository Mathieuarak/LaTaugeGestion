<?= $this->extend('layout') ?>

<?= $this->section('contenu') ?>

<style>
    .client-card {
        max-width: 600px;
        margin: 40px auto;
        padding: 30px;
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        font-family: Arial, sans-serif;
    }

    .client-card h1 {
        text-align: center;
        margin-bottom: 30px;
        color: #333;
    }

    .client-info {
        display: grid;
        grid-template-columns: 1fr 2fr;
        row-gap: 15px;
        column-gap: 10px;
    }

    .client-info span {
        font-weight: bold;
        color: #555;
    }

    .client-info p {
        margin: 0;
        color: #222;
    }

    .horse-section {
        margin-top: 30px;
    }

    .horse-list {
        display: grid;
        grid-template-columns: 1fr;
        row-gap: 12px;
        margin-top: 12px;
    }

    .horse-item {
        padding: 14px;
        background: #f8f9fb;
        border-radius: 8px;
        border: 1px solid #eef2f7;
    }

    .horse-item h3 {
        margin: 0 0 6px 0;
        color: #222;
        font-size: 1.05rem;
    }
</style>

<div class="client-card">
    <h1>Informations du client</h1>

    <div class="client-info">
        <span>Nom :</span>
        <p><?= esc($client['nom']) ?></p>

        <span>Prénom :</span>
        <p><?= esc($client['prenom']) ?></p>

        <span>Adresse postale :</span>
        <p><?= esc($client['adressePost']) ?></p>

        <span>Adresse mail :</span>
        <p><?= esc($client['adresseMail']) ?></p>

        <span>Téléphone :</span>
        <p><?= esc($client['tel']) ?></p>
    </div>
</div>
    <div class="horse-section client-card">
        <h2>Chevaux affectés</h2>

        <?php if (! empty($chevaux) && is_array($chevaux)): ?>
            <div class="horse-list">
                <?php foreach ($chevaux as $cheval): ?>
                    <div class="horse-item">
                        <h3><?= esc($cheval['nom'] ?? ($cheval['nom_cheval'] ?? '—')) ?> <?php if(!empty($cheval['numSire'])): ?><small style="font-weight:normal;color:#666">(SIRE: <?= esc($cheval['numSire']) ?>)</small><?php endif; ?></h3>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>Aucun cheval affecté à ce client.</p>
        <?php endif; ?>
    </div>

<?= $this->endSection() ?>
