<?= $this->extend('layout') ?>
<?= $this->section('contenu') ?>

<section>

    <h1 style="display: flex; justify-content: space-between; align-items: center;">
        Liste des clients
        <button type="button" class="btn" onclick="window.location.href='<?= base_url('client_ajout') ?>'">
            Ajouter un client
        </button>
    </h1>
    <p>Nombre de clients : <strong><?= count($clientListe) ?></strong></p>

    <form method="get" action="<?= current_url() ?>" style="margin: 15px 0; display: flex; gap: 10px;">
        <input
            type="text"
            name="search"
            placeholder="Rechercher ..."
            value="<?= esc($search ?? '') ?>">
        <button type="submit" class="btn">Rechercher</button>
        <a href="<?= current_url() ?>" class="btn">Réinitialiser</a>
    </form>

    <?php
    $table = new \CodeIgniter\View\Table();
    $table->setHeading('Nom', 'Prénom', 'Inspecter', 'Modifier', 'Supprimer');

    foreach ($clientListe as $client) {
        $id = $client['idclients'];

        $voir = '<button type="button" class="btn" onclick="window.location.href=\'' . base_url('client_voir-' . $id) . '\'">Inspecter</button>';
        $modifier = '<button type="button" class="btn" onclick="window.location.href=\'' . base_url('client_modif-' . $id) . '\'">Modifier</button>';
        $supprimer = '<form action="' . base_url('client-supprimer-' . $id) . '" method="post" style="display:inline;">
                        <button type="submit" class="btn" onclick="return confirm(\'Supprimer ce client ?\')">Supprimer</button>
                      </form>';

        $table->addRow(
            $client['nom'],
            $client['prenom'],
            $voir,
            $modifier,
            $supprimer
        );
    }
    ?>

    <?= $table->generate(); ?>

</section>


<?= $this->endSection() ?>