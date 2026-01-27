<?= $this->extend('layout') ?>
<?= $this->section('contenu') ?>

<section>

    <h1 style="display: flex; justify-content: space-between; align-items: center;">
        Liste des cours
        <button type="button" class="btn" onclick="window.location.href='<?= base_url('ajout_cours') ?>'">
            Ajouter un cours
        </button>
    </h1>



</section>

<?= $this->endSection() ?>