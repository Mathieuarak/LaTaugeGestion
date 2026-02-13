<?= $this->extend('layout') ?>
<?= $this->section('contenu') ?>

<h1>Ajouter un cours</h1>

<form action="<?= route_to('tarif_cours_create') ?>" method="post">

    <div class="form-grid" style="display:flex;gap:24px;align-items:flex-start">
        <div class="form-main" style="flex:1">

            <p>
                <label for="clients_idclients">Client :</label>
                <select name="client" id="clients_idclients" required>
                    <option value="">-- Sélectionner un client --</option>
                    <?php foreach ($clients as $client): ?>
                        <option value="<?= esc($client['idclients']) ?>">
                            <?= esc($client['nom'] . ' ' . $client['prenom']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </p>
            <p>
                <label for="coursDate">Date du cours :</label>
                <input type="date" name="coursDate" id="coursDate" required>
            </p>

            <p>
                <label for="description">Description :</label>
                <input type="text" name="description" id="description">
            </p>
            <p style="color:#000">
                <strong>Type :</strong><br>
                <label><input type="radio" name="type_cours" value="unique" checked> Cours à l’unité</label><br>
                <label><input type="radio" name="type_cours" value="forfait"> Forfait</label>
            </p>

            <p style="text-align:center;">
                <button type="submit" class="btn">Enregistrer le cours</button>
            </p>

        </div>
        <aside class="form-tarif" style="width:340px;min-height:420px">
            <div id="bloc-unique">
                <?php
                $optionsUnique = [
                    'tarifCourCollectifs'   => 'Cours collectif',
                    'tarifCourADeux'        => 'Cours à deux',
                    'tarifCourParticulier'  => 'Cours particulier',
                    'tarifTravailCheval'    => 'Travail du cheval'
                ];
                ?>
                <div class="tarif-box" style="border:1px solid #ddd;padding:12px;border-radius:6px;text-align:right;background:#fafafa">

                    <div class="total-box">
                        <div class="total-label">Tarif du cours</div>
                        <div id="totalDisplay">0 €</div>
                    </div>

                    <hr>
                    <h2 class="options-title">Options</h2>

                    <div class="options-list options-black" style="margin-top:10px;max-width:300px;font-size:0.95em;color:#000">
                        <?php foreach ($optionsUnique as $field => $label): ?>
                            <p>
                                <label>
                                    <input type="radio" name="option_unique" value="<?= $field ?>" data-price="<?= esc($tarifs[$field]) ?>">
                                    <?= $label ?> (+<?= esc($tarifs[$field]) ?> €)
                                </label>
                            </p>
                        <?php endforeach; ?>
                    </div>

                </div>
            </div>
            <div id="bloc-forfait" style="display:none">
                <div class="tarif-box" style="border:1px solid #ddd;padding:12px;border-radius:6px;text-align:right;background:#fafafa">

                    <div class="total-box">
                        <div class="total-label">Tarif du forfait</div>
                        <div id="totalDisplayForfait">0 €</div>
                    </div>

                    <hr>
                    <h2 class="options-title">Options forfait</h2>

                    <div class="options-list options-black" style="margin-top:10px;max-width:300px;font-size:0.95em;color:#000">
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
                            <div style="margin-bottom:8px;">
                                <strong><?= esc($forfait['libelle'] ?? 'Forfait') ?></strong>
                                <?php foreach ($groups as $group): ?>
                                    <div style="margin-top:6px;text-align:left">
                                        <em><?= $group['label'] ?></em>
                                        <?php foreach ($group['keys'] as $key => $label):
                                            if (!empty($forfait[$key]) && is_numeric($forfait[$key])):
                                        ?>
                                                <p style="margin:6px 0;">
                                                    <label>
                                                        <input type="radio"
                                                            name="forfait_option"
                                                            value="<?= $key ?>|<?= $forfait['idtarifCours'] ?>"
                                                            data-price="<?= esc($forfait[$key]) ?>">
                                                        <?= $label ?> (+<?= esc(number_format($forfait[$key], 2)) ?> €)
                                                    </label>
                                                </p>
                                        <?php endif;
                                        endforeach; ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <hr>
                        <?php endforeach; ?>
                    </div>

                </div>
            </div>

            <input type="hidden" name="total_tarif" id="total_tarif" value="0">

        </aside>

    </div>



</form>

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
                total = 0;
                document.querySelectorAll('#bloc-forfait input[type=radio]:checked').forEach(el => {
                    total = parseFloat(el.dataset.price) || total;
                });
                totalDisplayForfait.textContent = total + ' €';
            }
            totalInput.value = total;
        }

        // toggle blocs
        document.querySelectorAll('input[name="type_cours"]').forEach(el => {
            el.addEventListener('change', () => {
                blocUnique.style.display = el.value === 'unique' ? 'block' : 'none';
                blocForfait.style.display = el.value === 'forfait' ? 'block' : 'none';
                updateTotal();
            });
        });

        document.querySelectorAll('#bloc-unique input').forEach(el => el.addEventListener('change', updateTotal));
        document.querySelectorAll('#bloc-forfait input[type=radio]').forEach(el => el.addEventListener('change', updateTotal));

        updateTotal();

    });
</script>

<?= $this->endSection() ?>