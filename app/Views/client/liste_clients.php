<?= $this->extend('layout') ?>
<?= $this->section('contenu') ?>

<div class="container-fluid">

    <!-- Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-3">
        <h1 class="h3 mb-2 mb-md-0">Liste des clients</h1>

        <a href="<?= base_url('client_ajout') ?>" class="btn btn-primary">
            Ajouter un client
        </a>
    </div>

    <p class="mb-3">
        Nombre de clients : <strong><?= count($clientListe) ?></strong>
    </p>

    <!-- Formulaire de recherche -->
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

    $table->setHeading('Nom', 'Prénom', 'Inspecter', 'Modifier', 'Supprimer');

    // Template Bootstrap
    $table->setTemplate([
        'table_open' => '<table class="table table-striped table-hover align-middle">'
    ]);

    foreach ($clientListe as $client) {

        $id = $client['idclients'];

        $voir = '<a class="btn btn-sm btn-outline-primary"
                    href="' . base_url('client_voir-' . $id) . '">
                    Inspecter
                 </a>';

        $modifier = '<a class="btn btn-sm btn-outline-warning"
                        href="' . base_url('client_modif-' . $id) . '">
                        Modifier
                     </a>';

        $supprimer = '
            <form action="' . base_url('client-supprimer-' . $id) . '" 
                  method="post" 
                  style="display:inline;">
                <button type="submit" 
                        class="btn btn-sm btn-outline-danger"
                        onclick="return confirm(\'Supprimer ce client ?\')">
                    Supprimer
                </button>
            </form>
        ';

        $table->addRow(
            esc($client['nom']),
            esc($client['prenom']),
            $voir,
            $modifier,
            $supprimer
        );
    }
    ?>

    <!-- Tableau responsive -->
    <div class="table-responsive">
        <?= $table->generate(); ?>
    </div>

</div>

<?= $this->endSection() ?>
