<?= $this->extend('layout') ?>
<?= $this->section('contenu') ?>

<section>

<h1 style="display: flex; justify-content: space-between; align-items: center;">
    Cours de <?= esc($client['nom'] . ' ' . $client['prenom']) ?>
    <button type="button" class="btn" onclick="window.location.href='<?= route_to('cours') ?>'">
        ← Retour aux clients
    </button>
</h1>

<p>Nombre de cours : <strong><?= count($cours) ?></strong></p>

<?php
$table = new \CodeIgniter\View\Table();
$table->setHeading('Date', 'Description', 'Options', 'Prix', 'Payé', 'Modifier', 'Supprimer');

foreach ($cours as $c) {

    $options = '';
    $prix = 0;
    if ($c['optCollectif']) {
        $options .= 'Collectif<br>';
        $prix += $c['tarifCollectif'];
    }
    if ($c['optDeux']) {
        $options .= 'À deux<br>';
        $prix += $c['tarifDeux'];
    }
    if ($c['optParticulier']) {
        $options .= 'Particulier<br>';
        $prix += $c['tarifParticulier'];
    }
    if ($c['optCheval']) {
        $options .= 'Travail cheval<br>';
        $prix += $c['tarifCheval'];
    }

    // Formulaire pour cocher payé et rester sur la même page
    $payeForm = '<form action="' . route_to('cours_toggle_paye', $c['idcoursReg']) . '" method="post" style="display:inline;">
                    <input type="hidden" name="redirect" value="' . current_url() . '">
                    <input type="checkbox" name="paye" onchange="this.form.submit();" ' . ($c['paye'] ? 'checked' : '') . '>
                 </form>';

    // Bouton modifier, redirection vers la même page client après modification
    $modifier = '<button type="button" class="btn" onclick="window.location.href=\''
        . route_to('tarif_cours_modifier', $c['idcoursReg'])
        . '?redirect=' . $client['idclients'] . '\'">Modifier</button>';

    // Formulaire supprimer, reste sur la même page après suppression
    $supprimerForm = '<form action="' . route_to('tarif_cours_supprimer', $c['idcoursReg']) . '" method="post" style="display:inline;">
                        <input type="hidden" name="redirect" value="' . current_url() . '">
                        <button type="submit" class="btn" onclick="return confirm(\'Supprimer ce cours ?\')">Supprimer</button>
                     </form>';

    $table->addRow(
        date('d/m/Y', strtotime($c['coursDate'])),
        esc($c['description']),
        $options,
        number_format($prix, 2) . ' €',
        $payeForm,
        $modifier,
        $supprimerForm
    );
}
?>

<?= $table->generate(); ?>

</section>

<?= $this->endSection() ?>
