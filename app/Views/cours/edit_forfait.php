<?= $this->extend('layout') ?>
<?= $this->section('contenu') ?>

<h1>Modifier le forfait</h1>


<form action="<?= route_to('cours_forfait_update', $cours['idcoursfor']) ?>" method="post">

<div class="form-grid" style="display:flex;gap:24px;align-items:flex-start">

    <div class="form-main" style="flex:1">
        <p>
            <label for="clients_idclients">Client :</label>
            <select name="client" id="clients_idclients" required>
                <option value="">-- Sélectionner un client --</option>
                <?php foreach ($clients as $client): ?>
                    <option value="<?= esc($client['idclients']) ?>" <?= $cours['clients_idclients']==$client['idclients']?'selected':''?>>
                        <?= esc($client['nom'].' '.$client['prenom']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </p>

        <p>
            <label for="dateAjout">Date :</label>
            <input type="date" name="dateAjout" id="dateAjout" value="<?= esc($cours['dateAjout']) ?>" required>
        </p>

        <p>
            <label for="description">Description :</label>
            <input type="text" name="description" id="description" value="<?= esc($cours['description']) ?>">
        </p>

        <input type="hidden" name="idTarif" value="<?= esc($link['tarifCourForfait_idtarifCours'] ?? '') ?>">

        <p>
            <strong>Type :</strong><br>
            <label>
                <input type="radio" name="type_cours" value="unique" <?= empty($link['tarifCourForfait_idtarifCours'])?'checked':''?>>
                Cours à l’unité
            </label><br>
            <label>
                <input type="radio" name="type_cours" value="forfait" <?= !empty($link['tarifCourForfait_idtarifCours'])?'checked':''?>>
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
                        $checked = !empty($link[$field]);
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

                <div class="total-box">
                    <div class="total-label">Tarif du forfait</div>
                    <div id="totalDisplayForfait">0 €</div>
                </div>

                <hr>

                <div class="options-list options-black" style="margin-top:10px;text-align:left">
                    <?php
                    $fields = [
                        'tarifCoursCollec10' => 'Cours collectif 10',
                        'tarifCoursDuo10'    => 'Cours à deux 10',
                        'tarifCoursSolo10'   => 'Cours solo 10',
                        'travailCheval1'     => 'Travail cheval 1',
                        'tarifCoursCollec5'  => 'Cours collectif 5',
                        'tarifCoursDuo5'     => 'Cours à deux 5',
                        'tarifCoursSolo5'    => 'Cours solo 5',
                        'travailCheval2'     => 'Travail cheval 2'
                    ];

                    foreach ($tarifsForfait as $forfait): ?>
                        <div style="margin-bottom:8px;">
                            <strong><?= esc($forfait['libelle'] ?? 'Forfait') ?></strong>
                            <?php foreach ($fields as $key => $label):
                                if (!empty($forfait[$key]) && is_numeric($forfait[$key])):
                                    $checked = isset($link['tarifCourForfait_idtarifCours']) && $link['tarifCourForfait_idtarifCours']==$forfait['idtarifCours'] && (!empty($link[$key]) || floatval($link[$key])>0);
                            ?>
                                <p style="margin:6px 0;">
                                    <label>
                                        <input type="radio"
                                            name="forfait_option"
                                            value="<?= $key ?>|<?= $forfait['idtarifCours'] ?>"
                                            data-price="<?= esc($forfait[$key]) ?>"
                                            <?= $checked ? 'checked' : '' ?>
                                        >
                                        <?= $label ?> (+<?= esc(number_format($forfait[$key],2)) ?> €)
                                    </label>
                                </p>
                            <?php endif; endforeach; ?>
                        </div>
                        <hr>
                    <?php endforeach; ?>
                </div>

            </div>
        </div>
    </aside>

</div>

<p style="text-align:center;">
    <input type="hidden" name="redirectClient" value="<?= esc($cours['clients_idclients']) ?>">
    <button type="submit" class="btn">Modifier le forfait</button>
</p>

</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const totalDisplay = document.getElementById('totalDisplay');
    const totalInput = document.getElementById('total_tarif');
    const blocUnique = document.getElementById('bloc-unique');
    const blocForfait = document.getElementById('bloc-forfait');

    function updateType() {
        const sel = document.querySelector('input[name="type_cours"]:checked');
        const type = sel ? sel.value : 'forfait';
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const totalInput = document.getElementById('total_tarif');
    const totalDisplayForfait = document.getElementById('totalDisplayForfait');

    function updateTotalForfait() {
        let total = 0;
        const sel = document.querySelector('input[name="forfait_id"]:checked');
        if (sel) total = parseFloat(sel.dataset.price) || 0;
        totalDisplayForfait.textContent = total.toFixed(2) + ' €';
        totalInput.value = total;
    }

    document.querySelectorAll('input[name="forfait_id"]').forEach(el => el.addEventListener('change', updateTotalForfait));

    updateTotalForfait();

});
</script>

<?= $this->endSection() ?>
