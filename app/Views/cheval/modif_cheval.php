<?= $this->extend('layout') ?>
<?= $this->section('contenu') ?>

<div class="container-fluid">

    <h1 class="h3 mb-4">Modifier un cheval</h1>

    <form action="<?= url_to('cheval_update', $cheval['idpensions']) ?>" method="post">

        <div class="row g-4">

            <!-- COLONNE GAUCHE : FORMULAIRE -->
            <div class="col-12 col-lg-8">

                <div class="card shadow-sm">
                    <div class="card-body">

                        <!-- Client -->
                        <div class="mb-3">
                            <label for="clients_idclients" class="form-label">Client</label>
                            <select name="clients_idclients" id="clients_idclients"
                                class="form-select" required>
                                <option value="">-- Sélectionner un client --</option>
                                <?php foreach ($clients as $client): ?>
                                    <option value="<?= esc($client['idclients']) ?>"
                                        <?= old('clients_idclients', $cheval['clients_idclients']) == $client['idclients'] ? 'selected' : '' ?>>
                                        <?= esc($client['nom'] . ' ' . $client['prenom']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Nom -->
                        <div class="mb-3">
                            <label for="nom" class="form-label">Nom</label>
                            <input type="text"
                                name="nom"
                                id="nom"
                                class="form-control"
                                value="<?= esc(old('nom', $cheval['nom'])) ?>"
                                required>
                        </div>

                        <!-- Numéro SIRE -->
                        <div class="mb-3">
                            <label for="numSire" class="form-label">Numéro SIRE</label>
                            <input type="text"
                                name="numSire"
                                id="numSire"
                                class="form-control"
                                value="<?= esc(old('numSire', $cheval['numSire'])) ?>"
                                maxlength="15"
                                pattern="[0-9]{15}"
                                required>
                            <div class="form-text">15 chiffres obligatoires.</div>
                        </div>

                        <!-- Dates -->
                        <div class="row">
                            <div class="col-12 col-md-4 mb-3">
                                <label class="form-label">Date de naissance</label>
                                <input type="date"
                                    name="dateNaissance"
                                    class="form-control"
                                    value="<?= esc(old('dateNaissance', $cheval['dateNaissance'])) ?>">
                            </div>

                            <div class="col-12 col-md-4 mb-3">
                                <label class="form-label">Date d'arrivée</label>
                                <input type="date"
                                    name="dateArrivee"
                                    class="form-control"
                                    value="<?= esc(old('dateArrivee', $cheval['dateArrivee'])) ?>">
                            </div>

                            <div class="col-12 col-md-4 mb-3">
                                <label class="form-label">Dernier vaccin</label>
                                <input type="date"
                                    name="vaccin"
                                    class="form-control"
                                    value="<?= esc(old('vaccin', $cheval['vaccin'])) ?>">
                            </div>
                        </div>

                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary">
                                Mettre à jour
                            </button>
                        </div>

                    </div>
                </div>
            </div>

            <!-- COLONNE DROITE : TARIFICATION -->
            <div class="col-12 col-lg-4">

                <?php
                $base = $tarif['tarifBase'];
                $options = $cheval['tarifs_cheval'] ?? [];
                $currentTotal = $options['totalTarif'] ?? $base;
                ?>

                <div class="card shadow-sm">
                    <div class="card-body">

                        <h5 class="card-title">Tarification</h5>

                        <div class="mb-3 text-end">
                            <div class="text-muted small">Total mensuel</div>
                            <div id="totalDisplay" class="fs-4 fw-bold text-primary">
                                <?= esc($currentTotal) ?> €
                            </div>
                        </div>

                        <div class="mb-3 text-end">
                            Tarif de base :
                            <strong id="basePrice"><?= esc($base) ?> €</strong>
                        </div>

                        <hr>

                        <h6 class="mb-2">Alimentation floconnée (choisir 1)</h6>

                        <?php
                        $alimOptions = [
                            'alimFloconne1'  => 'Alimentation floconnée 1 L/J',
                            'alimFloconne13' => 'Alimentation floconnée 1/3 L/J',
                            'alimFloconne'   => 'Alimentation floconnée 3/6 L/J'
                        ];
                        ?>

                        <?php foreach ($alimOptions as $field => $label):
                            $checked = !empty($options[$field]) ? 'checked' : '';
                        ?>
                            <div class="form-check">
                                <input class="form-check-input alim-floconne"
                                    type="checkbox"
                                    name="<?= $field ?>"
                                    id="<?= $field ?>"
                                    data-price="<?= esc($tarif[$field]) ?>"
                                    <?= $checked ?>>
                                <label class="form-check-label" for="<?= $field ?>">
                                    <?= $label ?> (+<?= esc($tarif[$field]) ?> €)
                                </label>
                            </div>
                        <?php endforeach; ?>

                        <hr>

                        <h6 class="mb-2">Autres options</h6>

                        <?php
                        $otherOptions = [
                            'optBoxe' => 'Option boxe',
                            'optInstallation' => 'Option installation',
                            'optPaddockSolo' => 'Paddock solo',
                            'optPaddockDuo' => 'Paddock duo',
                            'optSortiPaddockHerbe' => 'Sortie paddock herbe',
                            'forfaitAutreAlim' => 'Forfait autre alimentation'
                        ];
                        ?>

                        <?php foreach ($otherOptions as $field => $label):
                            $checked = !empty($options[$field]) ? 'checked' : '';
                        ?>
                            <div class="form-check">
                                <input class="form-check-input"
                                    type="checkbox"
                                    name="<?= $field ?>"
                                    id="<?= $field ?>"
                                    data-price="<?= esc($tarif[$field]) ?>"
                                    <?= $checked ?>>
                                <label class="form-check-label" for="<?= $field ?>">
                                    <?= $label ?> (+<?= esc($tarif[$field]) ?> €)
                                </label>
                            </div>
                        <?php endforeach; ?>

                        <input type="hidden"
                            name="total_tarif"
                            id="total_tarif"
                            value="<?= esc($currentTotal) ?>">

                    </div>
                </div>

            </div>

        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {

    const basePrice = <?= (float) $base ?>;
    const totalDisplay = document.getElementById('totalDisplay');
    const totalInput = document.getElementById('total_tarif');
    const optionEls = document.querySelectorAll('input[type=checkbox][data-price]');

    function updateTotal() {
        let total = basePrice;
        optionEls.forEach(el => {
            if (el.checked) {
                total += parseFloat(el.dataset.price);
            }
        });
        totalDisplay.textContent = total + ' €';
        totalInput.value = total;
    }

    optionEls.forEach(el => el.addEventListener('change', updateTotal));

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

    updateTotal();
});
</script>

<?= $this->endSection() ?>
