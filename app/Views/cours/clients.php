<?= $this->extend('layout') ?>
<?= $this->section('contenu') ?>

<section>

    <h1 style="display: flex; justify-content: space-between; align-items: center;">
        Clients avec cours ou forfaits
        <button type="button" class="btn" onclick="window.location.href='<?= base_url('ajout_cours') ?>'">
            Ajouter un cours
        </button>
    </h1>

    <p>Nombre de clients : <strong><?= count($clients) ?></strong></p>

    <?php
    $table = new \CodeIgniter\View\Table();
    $table->setHeading('Client', 'Cours', 'Forfaits', 'Total', 'Action');

    foreach ($clients as $client) {

        $total = $client['nbCours'] + $client['nbForfaits'];

        $voirCours = '<button type="button" class="btn" onclick="window.location.href=\'' 
            . route_to('cours_client', $client['idclients']) . '\'">
                        Voir
                     </button>';

        $table->addRow(
            esc($client['nom'] . ' ' . $client['prenom']),
            $client['nbCours'],
            $client['nbForfaits'],
            $total,
            $voirCours
        );
    }
    ?>

    <?= $table->generate(); ?>

</section>

<?= $this->endSection() ?>
