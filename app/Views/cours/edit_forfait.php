<?= $this->extend('layout') ?>
<?= $this->section('contenu') ?>

<h1>Modifier le forfait</h1>

<form action="<?= route_to('cours_forfait_update', $cours['idcoursfor']) ?>" method="post">

    <p>
        <label for="description">Description :</label>
        <input type="text" name="description" id="description" value="<?= esc($cours['description']) ?>">
    </p>

    <p>
        <label for="dateAjout">Date :</label>
        <input type="date" name="dateAjout" id="dateAjout" value="<?= esc($cours['dateAjout']) ?>">
    </p>

    <h2>Forfait lié</h2>
    <?php foreach ($tarifsForfait as $forfait):
        $prix = 0;
        $fields = ['tarifCoursCollec10','tarifCoursDuo10','tarifCoursSolo10','travailCheval1','tarifCoursCollec5','tarifCoursDuo5','tarifCoursSolo5','travailCheval2'];
        foreach ($fields as $f) if (!empty($forfait[$f])) $prix += floatval($forfait[$f]);
        $checked = isset($link['tarifCourForfait_idtarifCours']) && $link['tarifCourForfait_idtarifCours']==$forfait['idtarifCours'];
    ?>
        <p>
            <label>
                <input type="radio" name="forfait_id" value="<?= esc($forfait['idtarifCours']) ?>" <?= $checked?'checked':''?>>
                <?= esc($forfait['libelle'] ?? 'Forfait') ?> (+<?= esc(number_format($prix,2)) ?> €)
            </label>
        </p>
    <?php endforeach; ?>

    <p style="text-align:center;">
        <button class="btn">Enregistrer</button>
    </p>

</form>

<?= $this->endSection() ?>
