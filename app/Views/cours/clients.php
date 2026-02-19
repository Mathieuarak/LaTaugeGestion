<?= $this->extend('layout') ?>
<?= $this->section('contenu') ?>

<div class="container-fluid">

    <h1 class="h3 mb-2">Clients avec cours ou forfaits</h1>

    <button type="button" class="btn btn-primary mb-3" onclick="window.location.href='<?= base_url('ajout_cours') ?>'">
        Ajouter un cours
    </button>

    <p>Nombre de clients : <strong><?= count($clients) ?></strong></p>

    <div class="table-responsive">
        <table class="table table-striped table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Client</th>
                    <th>Total cours</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($clients as $client): 
                    $total = $client['nbCours'] + $client['nbForfaits'];
                    ?>
                    <tr>
                        <td><?= esc($client['nom'] . ' ' . $client['prenom']) ?></td>
                        <td><?= esc($total) ?></td>
                        <td>
                            <button type="button" class="btn btn-sm btn-info" onclick="window.location.href='<?= route_to('cours_client', $client['idclients']) ?>'">
                                Voir
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>

<?= $this->endSection() ?>
