<?= $this->extend('layout') ?>
<?= $this->section('contenu') ?>

<h1>Ajouter un cheval</h1>

<form action="<?= url_to('cheval_create') ?>" method="post">

    <div class="form-grid" style="display:flex;gap:24px;align-items:flex-start">
        <div class="form-main" style="flex:1">

            <p>
                <label for="clients_idclients">Client :</label>
                <select name="clients_idclients" id="clients_idclients" required>
                    <option value="">-- Sélectionner un client --</option>
                    <?php foreach ($clients as $client): ?>
                        <option value="<?= esc($client['idclients']) ?>" <?= old('clients_idclients') == $client['idclients'] ? 'selected' : '' ?>>
                            <?= esc($client['nom'] . ' ' . $client['prenom']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </p>
        </div>
    </div>
</form>

<?= $this->endSection() ?>