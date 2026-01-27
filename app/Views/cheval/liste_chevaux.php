<?= $this->extend('layout') ?>
<?= $this->section('contenu') ?>

<section>

    <h1 style="display: flex; justify-content: space-between; align-items: center;">
        Liste des chevaux
        <button type="button" class="btn" onclick="window.location.href='<?= base_url('ajout_cheval') ?>'">
            Ajouter un cheval
        </button>
    </h1>

    <p>Nombre de chevaux : <strong><?= count($chevauxListe) ?></strong></p>

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
    $table->setHeading('Nom', 'Numéro SIRE', 'Tarif', 'Inspecter', 'Modifier', 'Supprimer');

    $tarifsChevalModel = model('TarifsChevalModel');

    foreach ($chevauxListe as $cheval) {
        $id = $cheval['idpensions'];

        $tarif = $tarifsChevalModel->getByCheval($id);
        $totalTarif = $tarif['totalTarif'] ?? 0;

        $voir = '<button type="button" class="btn" onclick="window.location.href=\'' . base_url('cheval_voir-' . $id) . '\'">Inspecter</button>';
        $modifier = '<button type="button" class="btn" onclick="window.location.href=\'' . base_url('cheval_modif-' . $id) . '\'">Modifier</button>';
        $supprimer = '<form action="' . base_url('cheval-supprimer-' . $id) . '" method="post" style="display:inline;">
                        <button type="submit" class="btn" onclick="return confirm(\'Supprimer ce cheval ?\')">Supprimer</button>
                      </form>';

        $table->addRow(
            $cheval['nom'],
            $cheval['numSire'],
            esc($totalTarif) . ' €',
            $voir,
            $modifier,
            $supprimer
        );
    }
    ?>

    <?= $table->generate(); ?>

</section>


<?= $this->endSection() ?>
