<?= $this->extend('layout') ?>
<?= $this->section('contenu') ?>

<div class="container-fluid">

    <h1 class="h3 mb-4">Modifier un client</h1>

    <!-- Affichage des erreurs -->
    <?php if (session()->getFlashdata('errors')) : ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach ?>
            </ul>
        </div>
    <?php endif ?>

    <form action="<?= url_to('client_update', $client['idclients']) ?>" method="post">
        <?= csrf_field() ?>

        <div class="row">

            <!-- COLONNE PRINCIPALE -->
            <div class="col-12 col-lg-8">

                <div class="card shadow-sm">
                    <div class="card-body">

                        <!-- Nom -->
                        <div class="mb-3">
                            <label for="nom" class="form-label">Nom</label>
                            <input type="text"
                                name="nom"
                                id="nom"
                                class="form-control"
                                value="<?= esc(old('nom', $client['nom'])) ?>"
                                maxlength="15"
                                required>
                        </div>

                        <!-- Prénom -->
                        <div class="mb-3">
                            <label for="prenom" class="form-label">Prénom</label>
                            <input type="text"
                                name="prenom"
                                id="prenom"
                                class="form-control"
                                value="<?= esc(old('prenom', $client['prenom'])) ?>"
                                maxlength="15"
                                required>
                        </div>

                        <!-- Adresse postale -->
                        <div class="mb-3">
                            <label for="adressePost" class="form-label">Adresse postale</label>
                            <input type="text"
                                name="adressePost"
                                id="adressePost"
                                class="form-control"
                                value="<?= esc(old('adressePost', $client['adressePost'])) ?>">
                        </div>

                        <!-- Adresse mail -->
                        <div class="mb-3">
                            <label for="adresseMail" class="form-label">Adresse mail</label>
                            <input type="email"
                                name="adresseMail"
                                id="adresseMail"
                                class="form-control"
                                value="<?= esc(old('adresseMail', $client['adresseMail'])) ?>"
                                required>
                        </div>

                        <!-- Téléphone -->
                        <?php
                        $raw = preg_replace('/\D+/', '', old('tel', $client['tel']));
                        $formatted = strlen($raw) === 10
                            ? preg_replace('/(\d{2})(\d{2})(\d{2})(\d{2})(\d{2})/', '$1 / $2 / $3 / $4 / $5', $raw)
                            : old('tel', $client['tel']);
                        ?>
                        <div class="mb-3">
                            <label for="tel" class="form-label">Téléphone</label>
                            <input type="text"
                                name="tel"
                                id="tel"
                                class="form-control"
                                value="<?= esc($formatted) ?>"
                                maxlength="22"
                                placeholder="00 / 00 / 00 / 00 / 00"
                                required>
                        </div>

                        <!-- Boutons -->
                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary">
                                Valider
                            </button>
                            <a href="<?= base_url('liste_clients') ?>" class="btn btn-outline-secondary ms-2">
                                Annuler
                            </a>
                        </div>

                    </div>
                </div>

            </div>

        </div>
    </form>

</div>

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
