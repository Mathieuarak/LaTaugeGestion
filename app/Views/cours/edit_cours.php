<?= $this->extend('layout') ?>
<?= $this->section('contenu') ?>

<section class="container my-4">

    <h1 class="mb-4">Modifier le cours</h1>

    <form action="<?= route_to('tarif_cours_update', $cours['idcoursReg']) ?>" method="post">

        <div class="row g-4">

            <!-- Partie principale du formulaire -->
            <div class="col-md-8">

                <div class="mb-3">
                    <label for="clients_idclients" class="form-label">Client :</label>
                    <select name="clients_idclients" id="clients_idclients" class="form-select" required>
                        <option value="">-- Sélectionner un client --</option>
                        <?php foreach ($clients as $client): ?>
                            <option value="<?= esc($client['idclients']) ?>"
                                <?= $cours['clients_idclients']==$client['idclients']?'selected':''?>>
                                <?= esc($client['nom'].' '.$client['prenom']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="coursDate" class="form-label">Date du cours :</label>
                    <input type="date" name="coursDate" id="coursDate" value="<?= esc($cours['coursDate']) ?>" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description :</label>
                    <input type="text" name="description" id="description" value="<?= esc($cours['description']) ?>" class="form-control">
                </div>

                <input type="hidden" name="idTarif" value="<?= esc($options['tarifCourReg_idtarifCourReg'] ?? '') ?>">

                <div class="mb-3">
                    <strong>Type :</strong><br>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="type_cours" id="typeUnique" value="unique" <?= empty($cours['tarifCourForfait_idtarifCours'])?'checked':''?>>
                        <label class="form-check-label" for="typeUnique">Cours à l’unité</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="type_cours" id="typeForfait" value="forfait" <?= !empty($cours['tarifCourForfait_idtarifCours'])?'checked':''?>>
                        <label class="form-check-label" for="typeForfait">Forfait</label>
                    </div>
                </div>

            </div>

            <!-- Partie tarif -->
            <div class="col-md-4">

                <!-- Cours unique -->
                <div id="bloc-unique" class="mb-3">
                    <div class="card p-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Tarif du cours</span>
                            <span id="totalDisplay" class="fw-bold">0 €</span>
                        </div>
                        <hr>
                        <h6>Options</h6>
                        <?php
                        $optionsCours = [
                            'tarifCourCollectifs'=>'Cours collectif',
                            'tarifCourADeux'=>'Cours à deux',
                            'tarifCourParticulier'=>'Cours particulier',
                            'tarifTravailCheval'=>'Travail du cheval'
                        ];
                        foreach($optionsCours as $field=>$label):
                            $checked = !empty($options[$field]);
                        ?>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="option_unique" value="<?= $field ?>" data-price="<?= esc($tarifs[$field]) ?>" id="<?= $field ?>" <?= $checked?'checked':''?>>
                                <label class="form-check-label" for="<?= $field ?>"><?= $label ?> (+<?= esc($tarifs[$field]) ?> €)</label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Forfaits -->
                <div id="bloc-forfait" style="display:none">
                    <h6 class="mb-2">Forfaits</h6>
                    <div class="card p-3">
                        <?php foreach($tarifsForfait as $forfait):
                            $prix = floatval($forfait['tarifCoursCollec10'])
                                  + floatval($forfait['tarifCoursDuo10'])
                                  + floatval($forfait['tarifCoursSolo10'])
                                  + floatval($forfait['travailCheval1'])
                                  + floatval($forfait['tarifCoursCollec5'])
                                  + floatval($forfait['tarifCoursDuo5'])
                                  + floatval($forfait['tarifCoursSolo5'])
                                  + floatval($forfait['travailCheval2']);
                            $checked = isset($cours['tarifCourForfait_idtarifCours']) && $cours['tarifCourForfait_idtarifCours']==$forfait['idtarifCours'];
                        ?>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="forfait_id" value="<?= esc($forfait['idtarifCours']) ?>" data-price="<?= esc($prix) ?>" id="forfait<?= $forfait['idtarifCours'] ?>" <?= $checked?'checked':''?>>
                                <label class="form-check-label" for="forfait<?= $forfait['idtarifCours'] ?>">
                                    <?= esc($forfait['libelle'] ?? 'Forfait') ?> (+<?= esc($prix) ?> €)
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <input type="hidden" name="total_tarif" id="total_tarif" value="0">

            </div>

        </div>

        <div class="text-center mt-4">
            <input type="hidden" name="redirectClient" value="<?= esc($cours['clients_idclients']) ?>">
            <button type="submit" class="btn btn-primary">Modifier le cours</button>
        </div>

    </form>

</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const totalDisplay = document.getElementById('totalDisplay');
    const totalInput = document.getElementById('total_tarif');
    const blocUnique = document.getElementById('bloc-unique');
    const blocForfait = document.getElementById('bloc-forfait');

    function updateType() {
        const type = document.querySelector('input[name="type_cours"]:checked').value;
        blocUnique.style.display = (type==='unique')?'block':'none';
        blocForfait.style.display = (type==='forfait')?'block':'none';
        updateTotal();
    }

    function updateTotal() {
        let total=0;
        const type = document.querySelector('input[name="type_cours"]:checked').value;
        if(type==='unique'){
            document.querySelectorAll('#bloc-unique input[type=radio][data-price]').forEach(opt=>{
                if(opt.checked) total=parseFloat(opt.dataset.price);
            });
        }
        if(type==='forfait'){
            const selected=document.querySelector('#bloc-forfait input[type=radio]:checked');
            if(selected) total=parseFloat(selected.dataset.price);
        }
        totalDisplay.textContent = total+' €';
        totalInput.value = total;
    }

    document.querySelectorAll('input[type=radio]').forEach(el=>el.addEventListener('change', ()=>{
        updateType();
        updateTotal();
    }));

    updateType();
});
</script>

<?= $this->endSection() ?>
