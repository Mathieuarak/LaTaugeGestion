<?= $this->extend('layout') ?>
<?= $this->section('contenu') ?>

<section>

    <h1 style="display: flex; justify-content: space-between; align-items: center;">
        Liste des cours
        <button type="button" class="btn" onclick="window.location.href='<?= base_url('ajout_cours') ?>'">
            Ajouter un cours
        </button>
    </h1>

    <?php if (!empty($cours)) : ?>
        <table border="1" cellpadding="8" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Client</th>
                    <th>Description</th>
                    <th>Options</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cours as $c) : ?>
                    <tr>
                        <td><?= date('d/m/Y', strtotime($c['coursDate'])) ?></td>
                        <td><?= esc($c['nom'] . ' ' . $c['prenom']) ?></td>
                        <td><?= esc($c['description']) ?></td>
                        <td>
                            <?php if ($c['tarifCourCollectifs']) : ?>Collectif<br><?php endif; ?>
                        <?php if ($c['tarifCourADeux']) : ?>À deux<br><?php endif; ?>
                    <?php if ($c['tarifCourParticulier']) : ?>Particulier<br><?php endif; ?>
                <?php if ($c['tarifTravailCheval']) : ?>Travail cheval<br><?php endif; ?>
                        </td>
                        <td>
                            <a href="<?= route_to('tarif_cours_modifier', $c['idcoursReg']) ?>">Modifier</a>

                            <form action="<?= route_to('tarif_cours_supprimer', $c['idcoursReg']) ?>" method="post" style="display:inline">
                                <button type="submit" onclick="return confirm('Supprimer ce cours ?')">
                                    Supprimer
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else : ?>
        <p>Aucun cours enregistré.</p>
    <?php endif; ?>

</section>

<?= $this->endSection() ?>