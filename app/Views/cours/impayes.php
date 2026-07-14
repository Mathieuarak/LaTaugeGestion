<?= $this->extend('layout') ?>
<?= $this->section('contenu') ?>

<section class="container-fluid">

    <div class="page-header">
        <div>
            <h1>Paiements en attente</h1>
            <p class="mb-0">Cours et forfaits non réglés, tous clients confondus.</p>
        </div>
        <span class="badge-count">
            <?= count($impayesCours) + count($impayesForfaits) ?> en attente · <?= number_format($total, 2) ?> €
        </span>
    </div>

    <?php if (empty($impayesCours) && empty($impayesForfaits)) : ?>

        <div class="table-responsive">
            <div class="empty-state">
                <div class="empty-icon">🎉</div>
                <div class="empty-title">Tout est à jour</div>
                <div class="empty-desc">Aucun paiement en attente pour le moment. Tous les cours et forfaits sont réglés.</div>
                <a href="<?= route_to('cours') ?>" class="btn btn-secondary btn-sm">Retour aux cours</a>
            </div>
        </div>

    <?php else : ?>

        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Type</th>
                        <th>Client</th>
                        <th>Date</th>
                        <th>Détail</th>
                        <th>Montant</th>
                        <th>Payé</th>
                        <th>Fiche</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($impayesCours as $c) : ?>
                        <tr>
                            <td><span class="badge bg-info">Cours</span></td>
                            <td><?= esc($c['client']) ?></td>
                            <td><?= $c['date'] ? date('d/m/Y', strtotime($c['date'])) : '—' ?></td>
                            <td><?= esc($c['option'] ?: $c['description']) ?></td>
                            <td data-num><?= number_format($c['prix'], 2) ?> €</td>
                            <td>
                                <form action="<?= route_to('cours_toggle_paye', $c['id']) ?>" method="post" class="d-inline">
                                    <input type="hidden" name="redirect" value="<?= route_to('cours_impayes') ?>">
                                    <input class="form-check-input" type="checkbox" onchange="this.form.submit();">
                                </form>
                            </td>
                            <td>
                                <a class="btn btn-sm btn-outline-primary" href="<?= route_to('cours_client', $c['clientId']) ?>">Voir</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php foreach ($impayesForfaits as $f) : ?>
                        <tr>
                            <td><span class="badge bg-secondary">Forfait</span></td>
                            <td><?= esc($f['client']) ?></td>
                            <td><?= $f['date'] ? date('d/m/Y', strtotime($f['date'])) : '—' ?></td>
                            <td><?= esc($f['description']) ?></td>
                            <td data-num><?= number_format($f['prix'], 2) ?> €</td>
                            <td>
                                <form action="<?= route_to('cours_forfait_toggle_paye', $f['id']) ?>" method="post" class="d-inline">
                                    <input type="hidden" name="redirect" value="<?= route_to('cours_impayes') ?>">
                                    <input class="form-check-input" type="checkbox" onchange="this.form.submit();">
                                </form>
                            </td>
                            <td>
                                <a class="btn btn-sm btn-outline-primary" href="<?= route_to('cours_client', $f['clientId']) ?>">Voir</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    <?php endif; ?>

</section>

<?= $this->endSection() ?>
