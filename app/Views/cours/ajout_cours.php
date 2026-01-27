<?= $this->extend('layout') ?>
<?= $this->section('contenu') ?>

<h1>Ajouter un cours</h1>

<form action="<?= route_to('tarif_cours_create') ?>" method="post">

    <div class="form-grid" style="display:flex;gap:24px;align-items:flex-start">

        <div class="form-main" style="flex:1">

            <!-- Client -->
            <p>
                <label for="clients_idclients">Client :</label><br>
                <select name="client" id="clients_idclients" required>
                    <option value="">-- Sélectionner un client --</option>
                    <?php foreach ($clients as $client): ?>
                        <option value="<?= esc($client['idclients']) ?>">
                            <?= esc($client['nom'].' '.$client['prenom']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </p>

            <!-- Date -->
            <p>
                <label for="coursDate">Date du cours :</label><br>
                <input type="date" name="coursDate" id="coursDate" required>
            </p>

            <!-- Description -->
            <p>
                <label for="description">Description :</label><br>
                <input type="text" name="description" id="description">
            </p>

        </div>

        <!-- OPTIONS -->
        <div class="form-side" style="width:320px">

            <h3>Options du cours</h3>

            <input type="hidden" name="idTarif" value="<?= $tarifs['idtarifCourReg'] ?>">

            <p>
                <label>
                    <input type="checkbox" name="tarifCourCollectifs" value="1">
                    Cours collectif (<?= $tarifs['tarifCourCollectifs'] ?> €)
                </label>
            </p>

            <p>
                <label>
                    <input type="checkbox" name="tarifCourADeux" value="1">
                    Cours à deux (<?= $tarifs['tarifCourADeux'] ?> €)
                </label>
            </p>

            <p>
                <label>
                    <input type="checkbox" name="tarifCourParticulier" value="1">
                    Cours particulier (<?= $tarifs['tarifCourParticulier'] ?> €)
                </label>
            </p>

            <p>
                <label>
                    <input type="checkbox" name="tarifTravailCheval" value="1">
                    Travail du cheval (<?= $tarifs['tarifTravailCheval'] ?> €)
                </label>
            </p>

        </div>
    </div>

    <p>
        <button type="submit" class="btn">Enregistrer le cours</button>
    </p>

</form>

<?= $this->endSection() ?>
