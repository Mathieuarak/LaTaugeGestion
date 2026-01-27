<?= $this->extend('layout') ?>
<?= $this->section('contenu') ?>

<h1>Ajouter un cheval</h1>

<form action="<?= url_to('cheval_create') ?>" method="post">

    <div class="form-grid" style="display:flex;gap:24px;align-items:flex-start">
        <div class="form-main" style="flex:1">

            <p>
                <label for="clients_idclients">Client :</label>
                <select name="clients_idclients" id="clients_idclients" required>
                    <option value="">-- Sélectionner un client --</option>
                    <?php foreach ($clients as $client): ?>
                        <option value="<?= esc($client['idclients']) ?>" <?= old('clients_idclients') == $client['idclients'] ? 'selected' : '' ?>>
                            <?= esc($client['nom'] . ' ' . $client['prenom']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </p>

            <p>
                <label for="nom">Nom :</label>
                <input type="text" name="nom" id="nom" value="<?= esc(old('nom')) ?>" required>
            </p>

            <p>
                <label for="numSire">Numéro SIRE :</label>
                <input type="text" name="numSire" id="numSire" value="<?= esc(old('numSire')) ?>" maxlength="15" pattern="[0-9]{15}" required>
            </p>

            <p>
                <label for="dateNaissance">Date de naissance :</label>
                <input type="date" name="dateNaissance" id="dateNaissance" value="<?= esc(old('dateNaissance')) ?>">
            </p>

            <p>
                <label for="dateArrivee">Date d'arrivée :</label>
                <input type="date" name="dateArrivee" id="dateArrivee" value="<?= esc(old('dateArrivee')) ?>">
            </p>

            <p>
                <label for="vaccin">Dernier vaccin :</label>
                <input type="date" name="vaccin" id="vaccin" value="<?= esc(old('vaccin')) ?>">
            </p>

            <p>
                <button type="submit">Valider</button>
            </p>
        </div>
        <aside class="form-tarif" style="width:340px">

            <?php $base = $tarif['tarifBase']; ?>

            <div class="tarif-box" style="border:1px solid #ddd;padding:12px;border-radius:6px;text-align:right;background:#fafafa">
                <div class="total-box">
                    <div class="total-label">Total mensuel</div>
                    <div id="totalDisplay" class="total-price"><?= esc($base) ?> €</div>
                </div>
                <div class="base-price">
                    Tarif de base : <strong id="basePrice"><?= esc($base) ?> €</strong>
                </div>

                <hr>
                <h2>Options</h2>
                <div class="options-list" style="margin-top:10px">
                    <div class="alim-options" style="margin-bottom:12px;">
                        <?php
                        $alimOptions = [
                            'alimFloconne1'  => 'Alimentation floconnée 1 L/J',
                            'alimFloconne13' => 'Alimentation floconnée 1/3 L/J',
                            'alimFloconne'   => 'Alimentation floconnée 3/6 L/J'
                        ];
                        foreach ($alimOptions as $field => $label): ?>
                            <p>
                                <label>
                                    <input type="checkbox" name="<?= $field ?>" class="alim-floconne" data-price="<?= esc($tarif[$field]) ?>">
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
                    foreach ($otherOptions as $field => $label): ?>
                        <p>
                            <label>
                                <input type="checkbox" name="<?= $field ?>" data-price="<?= esc($tarif[$field]) ?>">
                                <?= $label ?> (+<?= esc($tarif[$field]) ?> €)
                            </label>
                        </p>
                    <?php endforeach; ?>
                </div>

                <input type="hidden" name="total_tarif" id="total_tarif" value="<?= esc($base) ?>">
            </div>
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
