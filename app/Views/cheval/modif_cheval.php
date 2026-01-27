<?= $this->extend('layout') ?>
<?= $this->section('contenu') ?>

<h1>Modifier un cheval</h1>

<form action="<?= url_to('cheval_update', $cheval['idpensions']) ?>" method="post">

    <div class="form-grid" style="display:flex;gap:24px;align-items:flex-start">

        <!-- Colonne gauche : Formulaire cheval -->
        <div class="form-main" style="flex:1;">

            <p>
                <label for="clients_idclients">Client :</label>
                <select name="clients_idclients" id="clients_idclients" required>
                    <option value="">-- Sélectionner un client --</option>
                    <?php foreach ($clients as $client): ?>
                        <option value="<?= esc($client['idclients']) ?>" <?= old('clients_idclients', $cheval['clients_idclients']) == $client['idclients'] ? 'selected' : '' ?>>
                            <?= esc($client['nom'] . ' ' . $client['prenom']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </p>

            <p>
                <label>Nom :</label>
                <input type="text" name="nom" value="<?= esc(old('nom', $cheval['nom'])) ?>">
            </p>

            <p>
                <label>Numéro SIRE :</label>
                <input type="text" name="numSire" value="<?= esc(old('numSire', $cheval['numSire'])) ?>" maxlength="15" pattern="[0-9]{15}">
            </p>

            <p>
                <label>Date de naissance :</label>
                <input type="date" name="dateNaissance" value="<?= esc(old('dateNaissance', $cheval['dateNaissance'])) ?>">
            </p>

            <p>
                <label>Date d'arrivée :</label>
                <input type="date" name="dateArrivee" value="<?= esc(old('dateArrivee', $cheval['dateArrivee'])) ?>">
            </p>

            <p>
                <label>Dernier vaccin :</label>
                <input type="date" name="vaccin" value="<?= esc(old('vaccin', $cheval['vaccin'])) ?>">
            </p>

            <p><button type="submit">Valider</button></p>
        </div>

        <!-- Colonne droite : Options et total -->
        <aside class="form-tarif" style="width:340px;">

            <?php
            $base = $tarif['tarifBase'];
            $options = $cheval['tarifs_cheval'] ?? [];
            ?>

            <div class="total-box">
                <div class="total-label">Total mensuel</div>
                <div id="totalDisplay" class="total-price"><?= esc($options['totalTarif'] ?? $base) ?> €</div>
            </div>

            <div class="base-price">
                Tarif de base : <strong id="basePrice"><?= esc($base) ?> €</strong>
            </div>

            <hr>

            <h2>Options</h2>
            <div class="options-list">

                <div class="alim-options" style="margin-bottom:12px;">
                    <strong>Alimentation floconnée (choisir 1)</strong>
                    <?php
                    $alimOptions = [
                        'alimFloconne1'  => 'Alimentation floconnée 1 L/J',
                        'alimFloconne13' => 'Alimentation floconnée 1/3 L/J',
                        'alimFloconne'   => 'Alimentation floconnée 3/6 L/J'
                    ];
                    foreach ($alimOptions as $field => $label):
                        $checked = !empty($options[$field]) ? 'checked' : '';
                    ?>
                        <p>
                            <label>
                                <input type="checkbox" name="<?= $field ?>" class="alim-floconne" data-price="<?= esc($tarif[$field]) ?>" <?= $checked ?>>
                                <?= $label ?> (+<?= esc($tarif[$field]) ?> €)
                            </label>
                        </p>
                    <?php endforeach; ?>
                </div>

                <?php
                $otherOptions = [
                    'optBoxe' => 'Option boxe',
                    'optInstallation' => 'Option installation',
                    'optPaddockSolo' => 'Paddock solo',
                    'optPaddockDuo' => 'Paddock duo',
                    'optSortiPaddockHerbe' => 'Sortie paddock herbe',
                    'forfaitAutreAlim' => 'Forfait autre alimentation'
                ];
                foreach ($otherOptions as $field => $label):
                    $checked = !empty($options[$field]) ? 'checked' : '';
                ?>
                    <p>
                        <label>
                            <input type="checkbox" name="<?= $field ?>" data-price="<?= esc($tarif[$field]) ?>" <?= $checked ?>>
                            <?= $label ?> (+<?= esc($tarif[$field]) ?> €)
                        </label>
                    </p>
                <?php endforeach; ?>

            </div>

            <input type="hidden" name="total_tarif" id="total_tarif" value="<?= esc($options['totalTarif'] ?? $base) ?>">

        </aside>

    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const basePrice = <?= $base ?>;
    const totalDisplay = document.getElementById('totalDisplay');
    const totalInput = document.getElementById('total_tarif');
    const optionEls = document.querySelectorAll('input[type=checkbox][data-price]');

    function updateTotal() {
        let total = basePrice;
        optionEls.forEach(el => {
            if (el.checked) total += parseFloat(el.dataset.price);
        });
        totalDisplay.textContent = total + ' €';
        totalInput.value = total;
    }

    optionEls.forEach(el => el.addEventListener('change', updateTotal));
    updateTotal();

    const alimCheckboxes = document.querySelectorAll('.alim-floconne');
    alimCheckboxes.forEach(cb => {
        cb.addEventListener('change', function() {
            if (this.checked) {
                alimCheckboxes.forEach(other => {
                    if (other !== this) other.checked = false;
                });
            }
            updateTotal();
        });
    });
});
</script>

<?= $this->endSection() ?>
