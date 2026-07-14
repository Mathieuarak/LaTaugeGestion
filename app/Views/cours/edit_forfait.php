<?= $this->extend('layout') ?>
<?= $this->section('contenu') ?>

<section class="container my-4">

    <h1 class="mb-4">Modifier le forfait</h1>

    <form action="<?= route_to('cours_forfait_update', $cours['idcoursfor']) ?>" method="post">

        <div class="row g-4">

            <!-- Partie principale du formulaire -->
            <div class="col-md-8">

                <div class="mb-3">
                    <label for="clients_idclients" class="form-label">Client :</label>
                    <select name="clients_idclients" id="clients_idclients" class="form-select" required>
                        <option value="">-- Sélectionner un client --</option>
                        <?php foreach ($clients as $client): ?>
                            <option value="<?= esc($client['idclients']) ?>" <?= $cours['clients_idclients'] == $client['idclients'] ? 'selected' : '' ?>>
                                <?= esc($client['nom'] . ' ' . $client['prenom']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="dateAjout" class="form-label">Date :</label>
                    <input type="date" name="dateAjout" id="dateAjout" value="<?= esc($cours['dateAjout']) ?>" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description :</label>
                    <input type="text" name="description" id="description" value="<?= esc($cours['description']) ?>" class="form-control">
                </div>

                <input type="hidden" name="idTarif" value="<?= esc($link['tarifCourForfait_idtarifCours'] ?? '') ?>">

                <div class="text-center mt-4">
                    <input type="hidden" name="redirectClient" value="<?= esc($cours['clients_idclients']) ?>">
                    <button type="submit" class="btn btn-primary">Modifier le forfait</button>
                </div>

            </div>

            <!-- Partie tarif -->
            <div class="col-md-4">

                <!-- Forfaits -->
                <div id="bloc-forfait">
                    <h6 class="mb-2">Forfaits</h6>
                    <div class="card p-3">

                        <div class="d-flex justify-content-between mb-2">
                            <span>Tarif du forfait</span>
                            <span id="totalDisplayForfait">0 €</span>
                        </div>
                        <hr>

                        <div class="options-list">
                            <?php
                            $groups = [
                                'five' => [
                                    'label' => 'Forfait 5 jours',
                                    'keys' => [
                                        'tarifCoursCollec5' => 'Cours collectif 5',
                                        'tarifCoursDuo5' => 'Cours à deux 5',
                                        'tarifCoursSolo5' => 'Cours solo 5',
                                    ],
                                ],
                                'ten' => [
                                    'label' => 'Forfait 10 jours',
                                    'keys' => [
                                        'tarifCoursCollec10' => 'Cours collectif 10',
                                        'tarifCoursDuo10' => 'Cours à deux 10',
                                        'tarifCoursSolo10' => 'Cours solo 10',
                                    ],
                                ],
                                'travail' => [
                                    'label' => 'Travail cheval',
                                    'keys' => [
                                        'travailCheval1' => 'Travail cheval 1',
                                        'travailCheval2' => 'Travail cheval 2',
                                    ],
                                ],
                            ];

                            foreach ($tarifsForfait as $forfait): ?>
                                <div class="mb-3">
                                    <strong><?= esc($forfait['libelle'] ?? 'Forfait') ?></strong>
                                    <?php foreach ($groups as $group): ?>
                                        <div class="mt-2">
                                            <em><?= $group['label'] ?></em>
                                            <?php foreach ($group['keys'] as $key => $label):
                                                if (!empty($forfait[$key]) && is_numeric($forfait[$key])):
                                                    $checked = isset($link['tarifCourForfait_idtarifCours']) && $link['tarifCourForfait_idtarifCours'] == $forfait['idtarifCours'] && (!empty($link[$key]) || floatval($link[$key]) > 0);
                                            ?>
                                                    <div class="form-check mt-1">
                                                        <input class="form-check-input" type="radio"
                                                            name="forfait_option"
                                                            value="<?= $key ?>|<?= $forfait['idtarifCours'] ?>"
                                                            data-price="<?= esc($forfait[$key]) ?>"
                                                            id="<?= $key ?>_<?= $forfait['idtarifCours'] ?>" <?= $checked ? 'checked' : '' ?>>
                                                        <label class="form-check-label" for="<?= $key ?>_<?= $forfait['idtarifCours'] ?>">
                                                            <?= $label ?> (+<?= esc(number_format($forfait[$key], 2)) ?> €)
                                                        </label>
                                                    </div>
                                            <?php endif; endforeach; ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <hr>
                            <?php endforeach; ?>
                        </div>

                    </div>
                </div>

                <input type="hidden" name="total_tarif" id="total_tarif" value="0">

            </div>

        </div>

    </form>

</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const totalDisplayForfait = document.getElementById('totalDisplayForfait');
    const totalInput = document.getElementById('total_tarif');

    function updateTotalForfait() {
        let total = 0;
        const selected = document.querySelector('#bloc-forfait input[type=radio]:checked');
        if (selected) total = parseFloat(selected.dataset.price) || 0;
        totalDisplayForfait.textContent = total.toFixed(2) + ' €';
        totalInput.value = total;
    }

    document.querySelectorAll('#bloc-forfait input[type=radio]').forEach(el => el.addEventListener('change', updateTotalForfait));

    updateTotalForfait();
});
</script>

<?= $this->endSection() ?>
