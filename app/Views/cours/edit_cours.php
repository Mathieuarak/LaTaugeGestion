<?= $this->extend('layout') ?>
<?= $this->section('contenu') ?>

<h1>Modifier le cours</h1>

<form action="<?= route_to('tarif_cours_update', $cours['idcoursReg']) ?>" method="post">

<div class="form-grid" style="display:flex;gap:24px;align-items:flex-start">

    <div class="form-main" style="flex:1">
        <p>
            <label for="clients_idclients">Client :</label>
            <select name="client" id="clients_idclients" required>
                <option value="">-- Sélectionner un client --</option>
                <?php foreach ($clients as $client): ?>
                    <option value="<?= esc($client['idclients']) ?>"
                        <?= $cours['clients_idclients']==$client['idclients']?'selected':''?>>
                        <?= esc($client['nom'].' '.$client['prenom']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </p>

        <p>
            <label for="coursDate">Date du cours :</label>
            <input type="date" name="coursDate" id="coursDate" value="<?= esc($cours['coursDate']) ?>" required>
        </p>

        <p>
            <label for="description">Description :</label>
            <input type="text" name="description" id="description" value="<?= esc($cours['description']) ?>">
        </p>

        <input type="hidden" name="idTarif" value="<?= esc($options['tarifCourReg_idtarifCourReg'] ?? '') ?>">

        <p>
            <strong>Type :</strong><br>
            <label>
                <input type="radio" name="type_cours" value="unique" <?= empty($cours['tarifCourForfait_idtarifCours'])?'checked':''?>>
                Cours à l’unité
            </label><br>
            <label>
                <input type="radio" name="type_cours" value="forfait" <?= !empty($cours['tarifCourForfait_idtarifCours'])?'checked':''?>>
                Forfait
            </label>
        </p>

    </div>

    <aside class="form-tarif" style="width:340px">

        <div id="bloc-unique">
            <div class="tarif-box" style="border:1px solid #ddd;padding:12px;border-radius:6px;text-align:right;background:#fafafa">
                <div class="total-box">
                    <div class="total-label">Tarif du cours</div>
                    <div id="totalDisplay" class="total-price">0 €</div>
                </div>
                <hr>
                <h2>Options</h2>
                <div class="options-list">
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
                        <p>
                            <label>
                                <input type="radio" name="option_unique" value="<?= $field ?>" data-price="<?= esc($tarifs[$field]) ?>" <?= $checked?'checked':''?>>
                                <?= $label ?> (+<?= esc($tarifs[$field]) ?> €)
                            </label>
                        </p>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div id="bloc-forfait" style="display:none">
            <h2 class="options-title">Forfaits</h2>
            <div class="tarif-box" style="border:1px solid #ddd;padding:12px;border-radius:6px;text-align:right;background:#fafafa">
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
                    <p>
                        <label>
                            <input type="radio" name="forfait_id" value="<?= esc($forfait['idtarifCours']) ?>" data-price="<?= esc($prix) ?>" <?= $checked?'checked':''?>>
                            <?= esc($forfait['libelle'] ?? 'Forfait') ?> (+<?= esc($prix) ?> €)
                        </label>
                    </p>
                <?php endforeach; ?>
            </div>
        </div>

        <input type="hidden" name="total_tarif" id="total_tarif" value="0">

    </aside>

</div>

<p style="text-align:center;">
    <input type="hidden" name="redirectClient" value="<?= esc($cours['clients_idclients']) ?>">
    <button type="submit" class="btn">Modifier le cours</button>
</p>

</form>

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
