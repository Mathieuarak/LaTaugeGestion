<?= $this->extend('layout') ?>
<?= $this->section('contenu') ?>

<h1>Modifier un client</h1>

<?php if (session()->getFlashdata('errors')) : ?>
    <div class="errors" style="color: red; margin-bottom: 1rem;">
        <?php foreach (session()->getFlashdata('errors') as $error) : ?>
            <div><?= esc($error) ?></div>
        <?php endforeach ?>
    </div>
<?php endif ?>

<form action="<?= url_to('client_update', $client['idclients']) ?>" method="post">
    <?= csrf_field() ?>

    <div class="form-grid" style="display:flex;gap:24px;align-items:flex-start">

        <!-- PARTIE GAUCHE : FORMULAIRE -->
        <div class="form-main" style="flex:1">

            <p>
                <label for="nom">Nom :</label>
                <input
                    type="text"
                    name="nom"
                    id="nom"
                    value="<?= esc(old('nom', $client['nom'])) ?>"
                    maxlength="15"
                    required
                    style="background-color: transparent; border:1px solid #ccc; padding:6px 10px; border-radius:4px; width:100%;"
                >
            </p>

            <p>
                <label for="prenom">Prénom :</label>
                <input
                    type="text"
                    name="prenom"
                    id="prenom"
                    value="<?= esc(old('prenom', $client['prenom'])) ?>"
                    maxlength="15"
                    required
                    style="background-color: transparent; border:1px solid #ccc; padding:6px 10px; border-radius:4px; width:100%;"
                >
            </p>

            <p>
                <label for="adressePost">Adresse postale :</label>
                <input
                    type="text"
                    name="adressePost"
                    id="adressePost"
                    value="<?= esc(old('adressePost', $client['adressePost'])) ?>"
                    style="background-color: transparent; border:1px solid #ccc; padding:6px 10px; border-radius:4px; width:100%;"
                >
            </p>

            <p>
                <label for="adresseMail">Adresse mail :</label>
                <input
                    type="email"
                    name="adresseMail"
                    id="adresseMail"
                    value="<?= esc(old('adresseMail', $client['adresseMail'])) ?>"
                    required
                    style="background-color: transparent; border:1px solid #ccc; padding:6px 10px; border-radius:4px; width:100%;"
                >
            </p>

            <p>
                <label for="tel">Téléphone :</label>
                <?php
                $raw = preg_replace('/\D+/', '', old('tel', $client['tel']));
                $formatted = $raw;
                if (strlen($raw) === 10) {
                    $formatted = preg_replace(
                        '/(\d{2})(\d{2})(\d{2})(\d{2})(\d{2})/',
                        '$1 / $2 / $3 / $4 / $5',
                        $raw
                    );
                }
                ?>
                <input
                    type="text"
                    name="tel"
                    id="tel"
                    value="<?= esc($formatted) ?>"
                    maxlength="22"
                    placeholder="00 / 00 / 00 / 00 / 00"
                    required
                    style="background-color: transparent; border:1px solid #ccc; padding:6px 10px; border-radius:4px; width:100%;"
                >
            </p>

            <p>
                <button type="submit" style="padding:6px 12px; border:none; background:#4CAF50; border-radius:4px; cursor:pointer;">Valider</button>
            </p>

        </div>

    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const tel = document.getElementById('tel');
    if (!tel) return;

    tel.addEventListener('input', function (e) {
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
