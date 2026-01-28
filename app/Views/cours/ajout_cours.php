<?= $this->extend('layout') ?>
<?= $this->section('contenu') ?>

<style>
:root {
    --primary: #1d4ed8; /* bleu */
    --primary-dark: #2563eb;
    --text-dark: #1a1a1a;
    --text-light: #ffffff;
    --transition: 200ms cubic-bezier(0.2, 0.9, 0.3, 1);
}

body {
    background: url('<?= base_url("chevel.jpg") ?>') no-repeat center center / cover fixed;
    min-height: 100vh;
    font-family: 'Segoe UI', Roboto, 'Helvetica Neue', system-ui, -apple-system;
    color: var(--text-light);
    padding: 24px 16px;
}

h1 {
    font-size: 3.5rem;
    font-weight: 900;
    text-align: center;
    text-shadow: 0 8px 30px rgba(0,0,0,0.45);
    margin-bottom: 40px;
}

/* Formulaire général */
form {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 32px;
    width: 100%;
    max-width: 960px;
    margin: 0 auto;
}

.form-grid {
    display: flex;
    gap: 24px;
    align-items: flex-start;
    width: 100%;
    flex-wrap: wrap;
}

.form-main {
    flex: 1;
    min-width: 300px;
}

.form-main p {
    margin-bottom: 16px;
    color: #000000;
}

.form-main label {
    display: block;
    margin-bottom: 6px;
    font-weight: 600;
}

.form-main input,
.form-main select {
    width: 100%;
    padding: 12px 16px;
    border-radius: 8px;
    border: 1px solid #ccc;
    font-size: 1rem;
    outline: none;
}

/* Options côté */
.form-side {
    width: 320px;
    min-width: 280px;
    background: #ffffff; /* fond blanc */
    padding: 16px;
    border-radius: 12px;
    box-shadow: 0 6px 18px rgba(0,0,0,0.1);
}

.form-side h3 {
    margin-bottom: 16px;
    color: var(--text-dark);
    text-align: center;
}

/* Boutons d'options */
.option-btn {
    display: block;
    width: 100%;
    padding: 12px;
    margin-bottom: 12px;
    border: 1px solid var(--primary);
    border-radius: 10px;
    background: #f9f9f9;
    color: var(--text-dark);
    font-weight: 600;
    cursor: pointer;
    text-align: left;
    transition: all var(--transition);
}

.option-btn.selected {
    background: var(--primary);
    color: #fff;
}

/* Bouton envoyer */
button.btn {
    padding: 16px 32px;
    font-size: 1.1rem;
    font-weight: 700;
    border: none;
    border-radius: 12px;
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    color: #fff;
    cursor: pointer;
    transition: all var(--transition);
    box-shadow: 0 12px 36px rgba(0,0,0,0.35);
}

button.btn:hover {
    transform: translateY(-4px) scale(1.03);
    box-shadow: 0 24px 60px rgba(0,0,0,0.45);
    background: linear-gradient(135deg, var(--primary-dark), var(--primary));
}

/* Responsive */
@media (max-width: 768px) {
    h1 { font-size: 2.8rem; }
    .form-grid { flex-direction: column; align-items: center; }
    .form-side { width: 100%; max-width: 400px; }
}

@media (max-width: 480px) {
    h1 { font-size: 2.4rem; }
    button.btn { width: 100%; padding: 14px 0; }
}
</style>

<h1>Ajouter un cours</h1>

<form action="<?= route_to('tarif_cours_create') ?>" method="post">

    <div class="form-grid">

        <!-- Partie principale -->
        <div class="form-main">

            <p>
                <label for="clients_idclients">Client :</label>
                <select name="client" id="clients_idclients" required>
                    <option value="">-- Sélectionner un client --</option>
                    <?php foreach ($clients as $client): ?>
                        <option value="<?= esc($client['idclients']) ?>">
                            <?= esc($client['nom'].' '.$client['prenom']) ?>
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

        </div>

        <!-- Options côté -->
        <div class="form-side">
            <h3>Options du cours</h3>

            <input type="hidden" name="idTarif" value="<?= $tarifs['idtarifCourReg'] ?>">

            <?php
            $options = [
                'tarifCourCollectifs' => 'Cours collectif',
                'tarifCourADeux' => 'Cours à deux',
                'tarifCourParticulier' => 'Cours particulier',
                'tarifTravailCheval' => 'Travail du cheval'
            ];
            foreach ($options as $field => $label):
                $price = $tarifs[$field];
            ?>
                <button type="button" class="option-btn" data-input="<?= $field ?>">
                    <?= $label ?> (<?= $price ?> €)
                    <input type="radio" name="option_unique" value="<?= $field ?>" style="display:none;">
                </button>
            <?php endforeach; ?>

        </div>

    </div>

    <p style="text-align:center;">
        <button type="submit" class="btn">Enregistrer le cours</button>
    </p>

</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const optionButtons = document.querySelectorAll('.option-btn');

    optionButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            // décocher tous les boutons
            optionButtons.forEach(b => {
                b.classList.remove('selected');
                b.querySelector('input[type=radio]').checked = false;
            });
            // sélectionner celui cliqué
            this.classList.add('selected');
            this.querySelector('input[type=radio]').checked = true;
        });
    });
});
</script>

<?= $this->endSection() ?>
