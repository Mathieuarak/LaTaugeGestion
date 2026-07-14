<?= $this->extend('layout') ?>
<?= $this->section('contenu') ?>

<section class="container my-4">

    <!-- Titre et retour -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="m-0">Cours de <?= esc($client['nom'].' '.$client['prenom']) ?></h1>
        <button class="btn btn-success"
                onclick="window.location.href='<?= route_to('cours') ?>'">
            ← Retour aux clients
        </button>
    </div>

    <!-- Cours à l’unité -->
    <h2 class="mb-3">Cours à l’unité</h2>
    <div class="table-responsive mb-5">
        <table class="table table-striped table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Date</th>
                    <th>Options</th>
                    <th>Prix</th>
                    <th>Payé</th>
                    <th>Modifier</th>
                    <th>Supprimer</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($cours as $c):
                $options = esc($c['option']);
                $prix = $c['prix'];

                $payeForm = '<form action="'.route_to('cours_toggle_paye',$c['idcoursReg']).'" method="post" class="d-inline">
                                <input type="hidden" name="redirect" value="'.current_url().'">
                                <input class="form-check-input" type="checkbox" onchange="this.form.submit();" '.($c['paye'] ? 'checked' : '').'>
                             </form>';

                $modifier = '<button class="btn btn-primary btn-sm" onclick="window.location.href=\''.route_to('tarif_cours_modifier',$c['idcoursReg']).'?redirect='.$client['idclients'].'\'">Modifier</button>';

                $supprimer = '<form action="'.route_to('tarif_cours_supprimer',$c['idcoursReg']).'" method="post" class="d-inline">
                                <input type="hidden" name="redirect" value="'.current_url().'">
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Supprimer ce cours ?\')">Supprimer</button>
                             </form>';
            ?>
                <tr>
                    <td><?= date('d/m/Y',strtotime($c['coursDate'])) ?></td>
                    <td><?= $options ?></td>
                    <td><?= number_format($prix,2) ?> €</td>
                    <td><?= $payeForm ?></td>
                    <td><?= $modifier ?></td>
                    <td><?= $supprimer ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Forfaits -->
    <h2 class="mb-3">Forfaits</h2>
    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Date</th>
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
                        <td><?= esc($f['option']) ?></td>
                        <td>
                            <?php
                                $field = $f['optionField'] ?? null;
                                if ($field && (strpos($field, 'travailCheval1') !== false || $field === 'travailCheval1')) { $steps = 4; }
                                elseif ($field && (strpos($field, 'travailCheval2') !== false || $field === 'travailCheval2')) { $steps = 8; }
                                elseif ($field && strpos($field, '10') !== false) { $steps = 10; }
                                elseif ($field && strpos($field, '5') !== false) { $steps = 5; }
                                else { $steps = 1; }
                                $stade = isset($f['stade']) ? intval($f['stade']) : 0;
                            ?>
                            <div class="stade-container" data-id="<?= $f['idcoursfor'] ?>" data-url="<?= site_url('cours/updateStade/'.$f['idcoursfor']) ?>" data-stade="<?= $stade ?>">
                                <?php for ($i = 1; $i <= $steps; $i++): ?>
                                    <input type="checkbox" class="form-check-input stade-checkbox" data-step="<?= $i ?>" <?= $i <= $stade ? 'checked' : '' ?>>
                                <?php endfor; ?>
                            </div>
                        </td>
                        <td><?= number_format($f['prixFinal'], 2) ?> €</td>
                        <?php
                            $payeFormForfait = '<form action="'.route_to('cours_forfait_toggle_paye',$f["idcoursfor"]).'" method="post" class="d-inline">'
                                .'<input type="hidden" name="redirect" value="'.current_url().'">'
                                .'<input class="form-check-input" type="checkbox" onchange="this.form.submit();" '.($f['paye'] ? 'checked' : '').'>'
                                .'</form>';
                        ?>
                        <td><?= $payeFormForfait ?></td>
                        <td>
                            <button class="btn btn-primary btn-sm"
                                onclick="window.location.href='<?= route_to('cours_forfait_modifier', $f['idcoursfor']) ?>'">
                                Modifier
                            </button>
                        </td>
                        <td>
                            <form action="<?= route_to('cours_forfait_supprimer', $f['idcoursfor']) ?>" method="post" class="d-inline">
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer ce forfait ?')">
                                    Supprimer
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" class="text-center">Aucun forfait enregistré</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

</section>

<style>
.stade-container { display:inline-flex; gap:6px; align-items:center; }
.stade-container .stade-checkbox { width:18px; height:18px; cursor:pointer; }
.stade-container .stade-checkbox:checked { background:#4CAF50; border-color:#4CAF50; }
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
                }).then(resp => resp.json())
                .then(data => {
                    if (data && data.success) {
                        container.dataset.stade = data.stade;
                        container.querySelectorAll('.stade-checkbox').forEach(box => {
                            const s = parseInt(box.dataset.step, 10);
                            box.checked = s <= data.stade;
                        });
                    } else {
                        alert('Erreur lors de la mise à jour');
                    }
                }).catch(() => alert('Erreur réseau'));
            });
        });
    });
});
</script>

<?= $this->endSection() ?>
