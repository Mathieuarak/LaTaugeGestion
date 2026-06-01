<?= $this->extend('layout') ?>
<?= $this->section('contenu') ?>

<section class="container my-4" style="max-width: 720px;">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="m-0">Informations du cheval</h1>
        <a href="javascript:history.back()" class="btn btn-secondary">← Retour</a>
    </div>

    <!-- Card infos cheval -->
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <tbody>
                <tr>
                    <td style="width:35%; font-weight:600; color:var(--muted); font-size:0.85rem; text-transform:uppercase; letter-spacing:0.5px;">Client</td>
                    <td><?= esc($client['nom'] . ' ' . $client['prenom']) ?></td>
                </tr>
                <tr>
                    <td style="font-weight:600; color:var(--muted); font-size:0.85rem; text-transform:uppercase; letter-spacing:0.5px;">Nom</td>
                    <td><?= esc($cheval['nom']) ?></td>
                </tr>
                <tr>
                    <td style="font-weight:600; color:var(--muted); font-size:0.85rem; text-transform:uppercase; letter-spacing:0.5px;">Numéro SIRE</td>
                    <td><?= esc($cheval['numSire']) ?></td>
                </tr>
                <tr>
                    <td style="font-weight:600; color:var(--muted); font-size:0.85rem; text-transform:uppercase; letter-spacing:0.5px;">Date de naissance</td>
                    <td><?= esc($cheval['dateNaissance']) ?></td>
                </tr>
                <tr>
                    <td style="font-weight:600; color:var(--muted); font-size:0.85rem; text-transform:uppercase; letter-spacing:0.5px;">Date d'arrivée</td>
                    <td><?= esc($cheval['dateArrivee']) ?></td>
                </tr>
                <tr>
                    <td style="font-weight:600; color:var(--muted); font-size:0.85rem; text-transform:uppercase; letter-spacing:0.5px;">Dernier vaccin</td>
                    <td><?= esc($cheval['vaccin']) ?></td>
                </tr>
                <tr>
                    <td style="font-weight:600; color:var(--muted); font-size:0.85rem; text-transform:uppercase; letter-spacing:0.5px;">Prix pension</td>
                    <td>
                        <?php
                            $price = null;
                            if (!empty($tarifs_cheval) && isset($tarifs_cheval['totalTarif'])) {
                                $price = $tarifs_cheval['totalTarif'];
                            } elseif (!empty($tarif) && isset($tarif['tarifBase'])) {
                                $price = $tarif['tarifBase'];
                            }
                        ?>
                        <?= $price !== null ? esc(number_format((float) $price, 2, ',', ' ')) . ' €' : '<span style="opacity:0.4">—</span>' ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

</section>

<?= $this->endSection() ?>