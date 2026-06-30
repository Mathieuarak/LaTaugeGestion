<?= $this->extend('layout') ?>
<?= $this->section('contenu') ?>

<div class="container-fluid">

    <h1 class="h3 mb-4">Ajouter un cours</h1>

    <form action="<?= route_to('tarif_cours_create') ?>" method="post">
        <?= csrf_field() ?>

        <div class="row g-4">

            <!-- COLONNE FORMULAIRE -->
            <div class="col-12 col-lg-6">

                <div class="card shadow-sm">
                    <div class="card-body">

                        <!-- Client -->
                        <div class="mb-3">
                            <label for="clients_idclients" class="form-label">Client</label>
                            <select name="clients_idclients" id="clients_idclients" class="form-select" required>
                                <option value="">-- Sélectionner un client --</option>
                                <?php foreach ($clients as $client): ?>
                                    <option value="<?= esc($client['idclients']) ?>">
                                        <?= esc($client['nom'] . ' ' . $client['prenom']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Date du cours -->
                        <div class="mb-3">
                            <label for="coursDate" class="form-label">Date du cours</label>
                            <input type="date" name="coursDate" id="coursDate" class="form-control" required>
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <input type="text" name="description" id="description" class="form-control">
                        </div>

                        <!-- Type du cours -->
                        <div class="mb-3">
                            <label class="form-label d-block">Type</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="type_cours" value="unique" id="typeUnique" checked>
                                <label class="form-check-label" for="typeUnique">Cours à l’unité</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="type_cours" value="forfait" id="typeForfait">
                                <label class="form-check-label" for="typeForfait">Forfait</label>
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Enregistrer le cours</button>
                        </div>

                    </div>
                </div>

            </div>

            <!-- COLONNE TARIFS -->
            <div class="col-12 col-lg-6">

                <!-- Bloc Unique -->
                <div id="bloc-unique" class="card shadow-sm mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Tarif du cours</h5>
                        <div id="totalDisplay" class="fs-5 mb-3">0 €</div>
                        <hr>
                        <h6>Options</h6>
                        <?php
                        $optionsUnique = [
                            'tarifCourCollectifs'   => 'Cours collectif',
                            'tarifCourADeux'        => 'Cours à deux',
                            'tarifCourParticulier30'=> 'Cours particulier 30 min',
                            'tarifCourParticulier60'=> 'Cours particulier 60 min',
                            'tarifTravailCheval'    => 'Travail du cheval'
                        ];
                        ?>
                        <?php foreach ($optionsUnique as $field => $label): ?>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="option_unique" value="<?= $field ?>" data-price="<?= esc($tarifs[$field] ?? 0) ?>" id="<?= $field ?>">
                                <label class="form-check-label" for="<?= $field ?>">
                                    <?= $label ?> (+<?= esc($tarifs[$field] ?? 0) ?> €)
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Bloc Forfait -->
                <div id="bloc-forfait" class="card shadow-sm mb-3" style="display:none;">
                    <div class="card-body">
                        <h5 class="card-title">Tarif du forfait</h5>
                        <div id="totalDisplayForfait" class="fs-5 mb-3">0 €</div>
                        <hr>
                        <h6>Options forfait</h6>

                        <?php
                        $groups = [
                            'five' => ['label'=>'Forfait 5 jours','keys'=>['tarifCoursCollec5'=>'Cours collectif 5','tarifCoursDuo5'=>'Cours à deux 5','tarifCoursSolo5_30'=>'Cours solo 5 - 30 min','tarifCoursSolo5_60'=>'Cours solo 5 - 60 min']],
                            'ten' => ['label'=>'Forfait 10 jours','keys'=>['tarifCoursCollec10'=>'Cours collectif 10','tarifCoursDuo10'=>'Cours à deux 10','tarifCoursSolo10_30'=>'Cours solo 10 - 30 min','tarifCoursSolo10_60'=>'Cours solo 10 - 60 min']],
                            'travail' => ['label'=>'Travail cheval','keys'=>['travailCheval1'=>'Travail cheval 1','travailCheval2'=>'Travail cheval 2']],
                        ];
                        ?>

                        <?php foreach ($tarifsForfait as $forfait): ?>
                            <strong><?= esc($forfait['libelle'] ?? 'Forfait') ?></strong>
                            <?php foreach ($groups as $group): ?>
                                <div class="ms-3 mb-2">
                                    <em><?= $group['label'] ?></em>
                                    <?php foreach ($group['keys'] as $key => $label):
                                        if (!empty($forfait[$key]) && is_numeric($forfait[$key])):
                                    ?>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio"
                                                name="forfait_option"
                                                value="<?= $key ?>|<?= $forfait['idtarifCours'] ?>"
                                                data-price="<?= esc($forfait[$key]) ?>"
                                                id="<?= $key ?>_<?= $forfait['idtarifCours'] ?>">
                                            <label class="form-check-label" for="<?= $key ?>_<?= $forfait['idtarifCours'] ?>">
                                                <?= $label ?> (+<?= esc(number_format($forfait[$key],2)) ?> €)
                                            </label>
                                        </div>
                                    <?php endif; endforeach; ?>
                                </div>
                            <?php endforeach; ?>
                            <hr>
                        <?php endforeach; ?>

                    </div>
                </div>

                <input type="hidden" name="total_tarif" id="total_tarif" value="0">

            </div>

        </div>
    </form>

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const totalInput = document.getElementById('total_tarif');
    const totalDisplay = document.getElementById('totalDisplay');
    const totalDisplayForfait = document.getElementById('totalDisplayForfait');
    const blocUnique = document.getElementById('bloc-unique');
    const blocForfait = document.getElementById('bloc-forfait');

    function updateTotal() {
        let total = 0;
        if (document.querySelector('input[name="type_cours"]:checked').value === 'unique') {
            document.querySelectorAll('#bloc-unique input[type=radio][data-price]').forEach(el => {
                if (el.checked) total = parseFloat(el.dataset.price);
            });
            totalDisplay.textContent = total + ' €';
        } else {
            document.querySelectorAll('#bloc-forfait input[type=radio]').forEach(el => {
                if (el.checked) total = parseFloat(el.dataset.price) || 0;
            total = parseFloat(el.dataset.price) || total;
            });
            totalDisplayForfait.textContent = total + ' €';
        }
        totalInput.value = total;
    }

    document.querySelectorAll('input[name="type_cours"]').forEach(el => {
        el.addEventListener('change', () => {
            blocUnique.style.display = el.value === 'unique' ? 'block' : 'none';
            blocForfait.style.display = el.value === 'forfait' ? 'block' : 'none';
            updateTotal();
        });
    });

    document.querySelectorAll('#bloc-unique input[type=radio], #bloc-forfait input[type=radio]').forEach(el => {
        el.addEventListener('change', updateTotal);
    });

    updateTotal();
});
</script>

<?= $this->endSection() ?>
