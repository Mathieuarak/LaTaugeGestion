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
            <th>Date</th><th>Description</th><th>Options</th><th>Prix</th><th>Payé</th><th>Modifier</th><th>Supprimer</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($forfaits as $f):
        $total = array_sum(array_column($f['options'],'prix'));
        $optionsHtml = '';
        foreach($f['options'] as $opt) {
            $optionsHtml .= esc($opt['nom']) . ' (+' . number_format($opt['prix'],2) . ' €)<br>';
        }
    ?>
        <tr>
            <td><?= date('d/m/Y', strtotime($f['dateAjout'])) ?></td>
            <td><?= esc($f['description']) ?></td>
            <td><?= $optionsHtml ?></td>
            <td><?= number_format($total,2) ?> €</td>
            <td>-</td>
            <td>
                <button class="btn" onclick="window.location.href='<?= route_to('cours_forfait_modifier', $f['idcoursfor'] ?? '') ?>'">Modifier</button>
            </td>
            <td>
                <form action="<?= route_to('cours_forfait_supprimer', $f['idcoursfor'] ?? '') ?>" method="post" style="display:inline;">
                    <button onclick="return confirm('Supprimer ce forfait ?')" class="btn">Supprimer</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

</section>
<?= $this->endSection() ?>
