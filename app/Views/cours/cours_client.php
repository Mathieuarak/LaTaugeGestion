<?= $this->extend('layout') ?>
<?= $this->section('contenu') ?>



<section>
<h1>Cours de <?= esc($client['nom'].' '.$client['prenom']) ?>
    <button class="btn" onclick="window.location.href='<?= route_to('cours') ?>'">← Retour aux clients</button>
</h1>

<h2>Cours à l’unité</h2>
<table class="table">
    <thead>
        <tr>
            <th>Date</th><th>Description</th><th>Options</th><th>Prix</th><th>Payé</th><th>Modifier</th><th>Supprimer</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($cours as $c): 
        $options = '';
        $prix = 0;
        if($c['optCollectif']) { $options .= 'Collectif<br>'; $prix += $c['tarifCollectif']; }
        if($c['optDeux']) { $options .= 'À deux<br>'; $prix += $c['tarifDeux']; }
        if($c['optParticulier']) { $options .= 'Particulier<br>'; $prix += $c['tarifParticulier']; }
        if($c['optCheval']) { $options .= 'Travail cheval<br>'; $prix += $c['tarifCheval']; }

        $payeForm = '<form action="'.route_to('cours_toggle_paye',$c['idcoursReg']).'" method="post" style="display:inline;">
                        <input type="hidden" name="redirect" value="'.current_url().'">
                        <input type="checkbox" onchange="this.form.submit();" '.($c['paye'] ? 'checked' : '').'>
                     </form>';

        $modifier = '<button class="btn" onclick="window.location.href=\''.route_to('tarif_cours_modifier',$c['idcoursReg']).'?redirect='.$client['idclients'].'\'">Modifier</button>';

        $supprimer = '<form action="'.route_to('tarif_cours_supprimer',$c['idcoursReg']).'" method="post" style="display:inline;">
                        <input type="hidden" name="redirect" value="'.current_url().'">
                        <button onclick="return confirm(\'Supprimer ce cours ?\')" class="btn">Supprimer</button>
                     </form>';
    ?>
        <tr>
            <td><?= date('d/m/Y',strtotime($c['coursDate'])) ?></td>
            <td><?= esc($c['description']) ?></td>
            <td><?= $options ?></td>
            <td><?= number_format($prix,2) ?> €</td>
            <td><?= $payeForm ?></td>
            <td><?= $modifier ?></td>
            <td><?= $supprimer ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<h2>Forfaits</h2>
<table class="table">
    <thead>
        <tr>
            <th>Date</th>
            <th>Description</th>
            <th>Option choisie</th>
            <th>Stade</th>
            <th>Prix</th>
            <th>Payé</th>
            <th>Modifier</th>
            <th>Supprimer</th>
        </tr>
    </thead>
    <tbody>

    <?php if (!empty($forfaits)) : ?>
        <?php foreach ($forfaits as $f): ?>
            <tr>
                <td><?= date('d/m/Y', strtotime($f['dateAjout'])) ?></td>
                <td><?= esc($f['description']) ?></td>
                <td><?= esc($f['option']) ?></td>
                <td>
                    <?php
                        $field = $f['optionField'] ?? null;
                        // Determine steps depending on the option field
                        if ($field && (strpos($field, 'travailCheval1') !== false || $field === 'travailCheval1')) {
                            // travail cheval 1 = once per month -> 4 checkboxes
                            $steps = 4;
                        } elseif ($field && (strpos($field, 'travailCheval2') !== false || $field === 'travailCheval2')) {
                            // travail cheval 2 = twice per month -> 8 checkboxes
                            $steps = 8;
                        } elseif ($field && strpos($field, '10') !== false) {
                            $steps = 10;
                        } elseif ($field && strpos($field, '5') !== false) {
                            $steps = 5;
                        } else {
                            $steps = 1;
                        }
                        $stade = isset($f['stade']) ? intval($f['stade']) : 0;
                    ?>
                    <div class="stade-container" data-id="<?= $f['idcoursfor'] ?>" data-url="<?= site_url('cours/updateStade/'.$f['idcoursfor']) ?>" data-stade="<?= $stade ?>">
                        <?php for ($i = 1; $i <= $steps; $i++): ?>
                            <input type="checkbox" class="stade-checkbox" data-step="<?= $i ?>" <?= $i <= $stade ? 'checked' : '' ?>>
                        <?php endfor; ?>
                    </div>
                </td>
                <td><?= number_format($f['prixFinal'], 2) ?> €</td>

                <?php
                    $payeFormForfait = '<form action="'.route_to('cours_forfait_toggle_paye',$f["idcoursfor"]).'" method="post" style="display:inline;">'
                        .'<input type="hidden" name="redirect" value="'.current_url().'">'
                        .'<input type="checkbox" onchange="this.form.submit();" '.($f['paye'] ? 'checked' : '').'>'
                        .'</form>';
                ?>

                <td><?= $payeFormForfait ?></td>

                <td>
                    <button class="btn"
                        onclick="window.location.href='<?= route_to('cours_forfait_modifier', $f['idcoursfor']) ?>'">
                        Modifier
                    </button>
                </td>

                <td>
                    <form action="<?= route_to('cours_forfait_supprimer', $f['idcoursfor']) ?>"
                          method="post"
                          style="display:inline;">
                        <button onclick="return confirm('Supprimer ce forfait ?')"
                                class="btn">
                            Supprimer
                        </button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="8" style="text-align:center;">
                Aucun forfait enregistré
            </td>
        </tr>
    <?php endif; ?>

    </tbody>
</table>

</section>
<style>
    .stade-container { display:inline-flex; gap:6px; align-items:center; }
    .stade-container input[type="checkbox"] { width:18px; height:18px; appearance:none; border:1px solid #999; border-radius:3px; cursor:pointer; }
    .stade-container input[type="checkbox"]:checked { background:#4CAF50; border-color:#4CAF50; }
</style>
<script>
document.addEventListener('DOMContentLoaded', function(){
    const csrfName = '<?= csrf_token() ?>';
    const csrfHash = '<?= csrf_hash() ?>';

    document.querySelectorAll('.stade-container').forEach(function(container){
        container.querySelectorAll('.stade-checkbox').forEach(function(cb){
            cb.addEventListener('click', function(e){
                e.preventDefault();
                const step = parseInt(this.dataset.step, 10);
                const current = parseInt(container.dataset.stade, 10) || 0;
                let newStade = (step <= current) ? (step - 1) : step;
                if (newStade < 0) newStade = 0;

                const url = container.dataset.url;
                const body = csrfName + '=' + encodeURIComponent(csrfHash) + '&step=' + encodeURIComponent(newStade);

                fetch(url, {
                    method: 'POST',
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    body: body
                }).then(function(resp){ return resp.json(); })
                .then(function(data){
                    if (data && data.success) {
                        container.dataset.stade = data.stade;
                        // update UI
                        container.querySelectorAll('.stade-checkbox').forEach(function(box){
                            const s = parseInt(box.dataset.step, 10);
                            box.checked = s <= data.stade;
                        });
                    } else {
                        alert('Erreur lors de la mise à jour');
                    }
                }).catch(function(){ alert('Erreur réseau'); });
            });
        });
    });
});
</script>
<?= $this->endSection() ?>
