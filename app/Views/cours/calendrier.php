<?= $this->extend('layout') ?>
<?= $this->section('contenu') ?>

<section class="container-fluid">

    <div class="page-header">
        <div>
            <h1>Calendrier des cours</h1>
            <p class="mb-0">Vue hebdomadaire des cours à l'unité programmés.</p>
        </div>
        <a href="<?= base_url('ajout_cours') ?>" class="btn btn-primary btn-sm">Ajouter un cours</a>
    </div>

    <div class="calendar-nav">
        <a href="<?= route_to('cours_calendrier') ?>?semaine=<?= $offsetPrev ?>" class="btn btn-secondary btn-sm">← Semaine préc.</a>
        <span class="week-label"><?= esc($weekLabel) ?></span>
        <a href="<?= route_to('cours_calendrier') ?>?semaine=<?= $offsetNext ?>" class="btn btn-secondary btn-sm">Semaine suiv. →</a>
        <?php if ($offsetActuel !== 0) : ?>
            <a href="<?= route_to('cours_calendrier') ?>" class="btn btn-outline-secondary btn-sm">Aujourd'hui</a>
        <?php endif; ?>
    </div>

    <div class="calendar-grid">
        <?php foreach ($jours as $jour) : ?>
            <div class="calendar-day <?= $jour['isToday'] ? 'is-today' : '' ?>">
                <div class="calendar-day-header">
                    <span class="calendar-day-name"><?= esc($jour['nom']) ?></span>
                    <span class="calendar-day-number"><?= esc($jour['numero']) ?></span>
                </div>

                <?php if (empty($jour['cours'])) : ?>
                    <div class="calendar-empty">Aucun cours</div>
                <?php else : ?>
                    <?php foreach ($jour['cours'] as $c) : ?>
                        <a class="calendar-event" href="<?= route_to('cours_client', $c['clientId']) ?>">
                            <span class="event-time"><?= $c['heure'] ? esc(substr($c['heure'], 0, 5)) : 'Heure libre' ?></span>
                            <span class="event-client"><?= esc($c['client']) ?></span>
                            <?php if ($c['option']) : ?>
                                <span class="event-option"><?= esc($c['option']) ?></span>
                            <?php endif; ?>
                        </a>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>

</section>

<?= $this->endSection() ?>
