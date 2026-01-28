<?= $this->extend('layout') ?>
<?= $this->section('contenu') ?>

<h1>Modifier le cours</h1>

<form action="<?= route_to('tarif_cours_update', $cours['idcoursReg']) ?>" method="post">

    <div class="form-grid" style="display:flex;gap:24px;align-items:flex-start">

        <div class="form-main" style="flex:1">
            <p>
                <label for="clients_idclients">Client :</label><br>
                <select name="client" id="clients_idclients" required>
                    <option value="">-- Sélectionner un client --</option>
                    <?php foreach ($clients as $client): ?>
                        <option value="<?= esc($client['idclients']) ?>"
                            <?= $cours['clients_idclients'] == $client['idclients'] ? 'selected' : '' ?>>
                            <?= esc($client['nom'].' '.$client['prenom']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </p>

            <p>
                <label for="coursDate">Date du cours :</label><br>
                <input type="date" name="coursDate" id="coursDate" 
                       value="<?= esc($cours['coursDate']) ?>" required>
            </p>

            <p>
                <label for="description">Description :</label><br>
                <input type="text" name="description" id="description" 
                       value="<?= esc($cours['description']) ?>">
            </p>

        </div>

        <div class="form-side" style="width:320px">

            <h3>Options du cours</h3>

            <input type="hidden" name="idTarif" value="<?= $options['tarifCourReg_idtarifCourReg'] ?>">

            <p>
                <label>
                    <input type="checkbox" name="tarifCourCollectifs" value="1"
                        <?= $options['tarifCourCollectifs'] ? 'checked' : '' ?>>
                    Cours collectif (<?= $tarifs['tarifCourCollectifs'] ?> €)
                </label>
            </p>

            <p>
                <label>
                    <input type="checkbox" name="tarifCourADeux" value="1"
                        <?= $options['tarifCourADeux'] ? 'checked' : '' ?>>
                    Cours à deux (<?= $tarifs['tarifCourADeux'] ?> €)
                </label>
            </p>

            <p>
                <label>
                    <input type="checkbox" name="tarifCourParticulier" value="1"
                        <?= $options['tarifCourParticulier'] ? 'checked' : '' ?>>
                    Cours particulier (<?= $tarifs['tarifCourParticulier'] ?> €)
                </label>
            </p>

            <p>
                <label>
                    <input type="checkbox" name="tarifTravailCheval" value="1"
                        <?= $options['tarifTravailCheval'] ? 'checked' : '' ?>>
                    Travail du cheval (<?= $tarifs['tarifTravailCheval'] ?> €)
                </label>
            </p>

        </div>
   </div>

    <p>
        <input type="hidden" name="redirectClient" value="<?= esc($cours['clients_idclients']) ?>">
        
        <button type="submit" class="btn">Modifier le cours</button>
    </p>

</form>

<?= $this->endSection() ?>
