<?= $this->extend('layout') ?>
<?= $this->section('contenu') ?>

<section class="container my-4" style="max-width: 720px;">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="m-0">Informations du client</h1>
        <a href="javascript:history.back()" class="btn btn-secondary">← Retour</a>
    </div>

    <!-- Card infos client -->
    <div class="table-responsive mb-4">
        <table class="table align-middle mb-0">
            <tbody>
                <tr>
                    <td style="width:35%; font-weight:600; color:rgba(255,255,255,0.6); font-size:0.85rem; text-transform:uppercase; letter-spacing:0.5px;">Nom</td>
                    <td><?= esc($client['nom']) ?></td>
                </tr>
                <tr>
                    <td style="font-weight:600; color:rgba(255,255,255,0.6); font-size:0.85rem; text-transform:uppercase; letter-spacing:0.5px;">Prénom</td>
                    <td><?= esc($client['prenom']) ?></td>
                </tr>
                <tr>
                    <td style="font-weight:600; color:rgba(255,255,255,0.6); font-size:0.85rem; text-transform:uppercase; letter-spacing:0.5px;">Adresse postale</td>
                    <td><?= esc($client['adressePost']) ?></td>
                </tr>
                <tr>
                    <td style="font-weight:600; color:rgba(255,255,255,0.6); font-size:0.85rem; text-transform:uppercase; letter-spacing:0.5px;">Adresse mail</td>
                    <td><?= esc($client['adresseMail']) ?></td>
                </tr>
                <tr>
                    <td style="font-weight:600; color:rgba(255,255,255,0.6); font-size:0.85rem; text-transform:uppercase; letter-spacing:0.5px;">Téléphone</td>
                    <td><?= esc($client['tel']) ?></td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Chevaux affectés -->
    <h2 class="mb-3">Chevaux affectés</h2>

    <?php if (!empty($chevaux) && is_array($chevaux)): ?>
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Numéro SIRE</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($chevaux as $cheval): ?>
                        <tr>
                            <td><?= esc($cheval['nom'] ?? ($cheval['nom_cheval'] ?? '—')) ?></td>
                            <td><?= !empty($cheval['numSire']) ? esc($cheval['numSire']) : '<span style="opacity:0.4">—</span>' ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p class="text-center" style="opacity:0.6; padding: 24px 0;">Aucun cheval affecté à ce client.</p>
    <?php endif; ?>

</section>

<?= $this->endSection() ?>