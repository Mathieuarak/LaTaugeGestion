<?= $this->extend('layout') ?>
<?= $this->section('contenu') ?>

<section class="container-fluid">

    <!-- Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-3">
        <h1 class="h3 mb-2 mb-md-0">Liste des chevaux</h1>

        <a href="<?= base_url('ajout_cheval') ?>" class="btn btn-primary">
            Ajouter un cheval
        </a>
    </div>

    <p class="mb-3">
        Nombre de chevaux : <strong><?= count($chevauxListe) ?></strong>
    </p>

    <!-- Formulaire -->
    <form method="get" action="<?= current_url() ?>" class="row g-2 mb-4">

        <div class="col-12 col-md-6">
            <input
                type="text"
                name="search"
                class="form-control"
                placeholder="Rechercher ..."
                value="<?= esc($search ?? '') ?>">
        </div>

        <div class="col-6 col-md-auto">
            <button type="submit" class="btn btn-primary w-100">
                Rechercher
            </button>
        </div>

        <div class="col-6 col-md-auto">
            <a href="<?= current_url() ?>" class="btn btn-outline-secondary w-100">
                Réinitialiser
            </a>
        </div>

    </form>

    <?php
    $table = new \CodeIgniter\View\Table();

    $table->setHeading('Nom', 'Numéro SIRE', 'Tarif', 'Inspecter', 'Modifier', 'Supprimer');

    // ✅ Méthode correcte pour CI4
    $table->setTemplate([
        'table_open' => '<table class="table table-striped table-hover align-middle">'
    ]);

    $tarifsChevalModel = model('TarifsChevalModel');

    foreach ($chevauxListe as $cheval) {

        $id = $cheval['idpensions'];

        $tarif = $tarifsChevalModel->getByCheval($id);
        $totalTarif = $tarif['totalTarif'] ?? 0;

        $voir = '<a class="btn btn-sm btn-outline-primary" href="' . base_url('cheval_voir-' . $id) . '">Inspecter</a>';

        $modifier = '<a class="btn btn-sm btn-outline-warning" href="' . base_url('cheval_modif-' . $id) . '">Modifier</a>';

        $supprimer = '
            <form action="' . base_url('cheval-supprimer-' . $id) . '" method="post" style="display:inline;" data-confirm="Supprimer ce cheval ? Cette action est irréversible.">
                <button type="submit" class="btn btn-sm btn-outline-danger">
                    Supprimer
                </button>
            </form>
        ';

        $table->addRow(
            esc($cheval['nom']),
            esc($cheval['numSire']),
            esc($totalTarif) . ' €',
            $voir,
            $modifier,
            $supprimer
        );
    }
    ?>

    <?php if (empty($chevauxListe)) : ?>
        <div class="table-responsive">
            <div class="empty-state">
                <div class="empty-icon">🐴</div>
                <?php if (!empty($search)) : ?>
                    <div class="empty-title">Aucun résultat</div>
                    <div class="empty-desc">Aucun cheval ne correspond à « <?= esc($search) ?> ».</div>
                    <a href="<?= current_url() ?>" class="btn btn-outline-secondary btn-sm">Réinitialiser la recherche</a>
                <?php else : ?>
                    <div class="empty-title">Aucun cheval pour le moment</div>
                    <div class="empty-desc">Ajoutez votre premier cheval pour commencer à suivre sa pension et ses tarifs.</div>
                    <a href="<?= base_url('ajout_cheval') ?>" class="btn btn-primary btn-sm">Ajouter un cheval</a>
                <?php endif; ?>
            </div>
        </div>
    <?php else : ?>
        <div class="table-responsive">
            <?= $table->generate(); ?>
        </div>
    <?php endif; ?>

</section>

<?= $this->endSection() ?>
