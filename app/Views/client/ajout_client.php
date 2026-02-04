<?= $this->extend('layout') ?>
<?= $this->section('contenu') ?>

<h1>Ajouter un client</h1>

<?php if (session()->getFlashdata('errors')) : ?>
    <div class="errors" style="color: red; margin-bottom: 1rem;">
        <?php foreach (session()->getFlashdata('errors') as $error) : ?>
            <div><?= esc($error) ?></div>
        <?php endforeach ?>
    </div>
<?php endif ?>

<form action="<?= url_to('client_create') ?>" method="post">
    <?= csrf_field() ?>

    <div class="form-grid" style="display:flex;gap:24px;align-items:flex-start">

        <!-- PARTIE GAUCHE : FORMULAIRE -->
        <div class="form-main" style="flex:1">

            <p>
                <label for="nom">Nom :</label>
                <input type="text" name="nom" id="nom" value="<?= esc(old('nom')) ?>">
            </p>

            <p>
                <label for="prenom">Prénom :</label>
                <input type="text" name="prenom" id="prenom" value="<?= esc(old('prenom')) ?>">
            </p>

            <p>
                <label for="adressePost">Adresse postale :</label>
                <input type="text" name="adressePost" id="adressePost" value="<?= esc(old('adressePost')) ?>">
            </p>

            <p>
                <label for="adresseMail">Adresse mail :</label>
                <input type="email" name="adresseMail" id="adresseMail" value="<?= esc(old('adresseMail')) ?>" required>
            </p>

            <p>
                <label for="tel">Téléphone :</label>
                <?php
                $rawTel = preg_replace('/\D+/', '', old('tel') ?? '');
                $formattedTel = '';
                if (strlen($rawTel) === 10) {
                    $formattedTel = preg_replace('/(\d{2})(\d{2})(\d{2})(\d{2})(\d{2})/', '$1 / $2 / $3 / $4 / $5', $rawTel);
                } else {
                    $formattedTel = old('tel');
                }
                ?>
                <input type="text" name="tel" id="tel" value="<?= esc($formattedTel) ?>" maxlength="22" placeholder="00 / 00 / 00 / 00 / 00">
            </p>

            <p>
                <button type="submit">Valider</button>
            </p>

        </div>

        <!-- PARTIE DROITE : (Optionnel si tu veux un bloc info ou tarif comme pour chevaux/cours) -->
        <!-- Pour un client simple, tu peux laisser vide ou ajouter un résumé/infos -->
        <!--
        <aside class="form-tarif" style="width:340px">
            <div class="tarif-box">
                <h2>Résumé client</h2>
                <p>...</p>
            </div>
        </aside>
        -->

    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tel = document.getElementById('tel');
    if (!tel) return;

    tel.addEventListener('input', function(e) {
        let digits = e.target.value.replace(/\D/g, '');
        if (digits.length > 10) digits = digits.slice(0, 10);

        const parts = [];
        for (let i = 0; i < digits.length; i += 2) {
            parts.push(digits.substring(i, i + 2));
        }

        e.target.value = parts.join(' / ');
    });
});
</script>

<?= $this->endSection() ?>
