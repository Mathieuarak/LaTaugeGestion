<?= $this->extend('layout') ?>
<?= $this->section('contenu') ?>

<style>
    .home-hero {
        text-align: center;
        padding: 36px 20px 12px;
        animation: homeFade 0.6s ease both;
    }
    .home-hero .eyebrow {
        display: inline-block;
        font-size: 0.78rem;
        font-weight: 600;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: var(--accent-dark);
        background: var(--accent-soft);
        padding: 5px 14px;
        border-radius: var(--radius-pill);
        margin-bottom: 18px;
    }
    .home-hero h1 {
        font-size: clamp(2.1rem, 5vw, 3.2rem);
        font-weight: 700;
        letter-spacing: -0.03em;
        margin-bottom: 10px;
    }
    .home-hero p {
        color: var(--muted);
        font-size: 1.05rem;
        max-width: 540px;
        margin: 0 auto;
    }

    .stat-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 16px;
        max-width: 880px;
        margin: 40px auto 0;
    }
    .stat-tile {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        box-shadow: var(--shadow-xs);
        padding: 18px 20px;
        display: flex;
        align-items: center;
        gap: 14px;
        animation: homeUp 0.6s cubic-bezier(0.34, 1.4, 0.64, 1) backwards;
    }
    .stat-tile:nth-child(1) { animation-delay: 0.02s; }
    .stat-tile:nth-child(2) { animation-delay: 0.08s; }
    .stat-tile:nth-child(3) { animation-delay: 0.14s; }
    .stat-tile:nth-child(4) { animation-delay: 0.2s; }
    .stat-tile .stat-icon {
        width: 40px;
        height: 40px;
        flex-shrink: 0;
        display: grid;
        place-items: center;
        border-radius: 11px;
        font-size: 1.15rem;
    }
    .stat-tile .stat-value {
        font-size: 1.5rem;
        font-weight: 650;
        letter-spacing: -0.02em;
        color: var(--text);
        line-height: 1.1;
    }
    .stat-tile .stat-label {
        font-size: 0.78rem;
        color: var(--muted);
        font-weight: 500;
    }
    .stat-icon.is-accent  { background: var(--accent-soft); color: var(--accent-dark); }
    .stat-icon.is-blue    { background: var(--blue-soft);   color: var(--blue); }
    .stat-icon.is-purple  { background: var(--purple-soft); color: var(--purple); }
    .stat-icon.is-orange  { background: var(--orange-soft); color: var(--orange); }

    .stat-tile-link {
        text-decoration: none;
        color: inherit;
        transition: transform var(--transition), box-shadow var(--transition);
    }
    .stat-tile-link:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-sm);
        text-decoration: none;
    }

    .home-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 20px;
        max-width: 880px;
        margin: 44px auto 0;
    }

    .home-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 30px 26px;
        text-align: left;
        cursor: pointer;
        box-shadow: var(--shadow-sm);
        transition: transform var(--transition), box-shadow var(--transition), border-color var(--transition);
        display: flex;
        flex-direction: column;
        gap: 14px;
        animation: homeUp 0.6s cubic-bezier(0.34, 1.4, 0.64, 1) backwards;
    }
    .home-card:nth-child(1) { animation-delay: 0.05s; }
    .home-card:nth-child(2) { animation-delay: 0.13s; }
    .home-card:nth-child(3) { animation-delay: 0.21s; }

    .home-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-md);
        border-color: var(--accent-light);
    }

    .home-card .icon {
        width: 48px;
        height: 48px;
        display: grid;
        place-items: center;
        border-radius: 12px;
        background: var(--accent-soft);
        font-size: 1.5rem;
    }
    .home-card .title { font-weight: 650; font-size: 1.1rem; color: var(--text); }
    .home-card .desc { color: var(--muted); font-size: 0.9rem; }
    .home-card .go {
        margin-top: auto;
        color: var(--accent);
        font-weight: 600;
        font-size: 0.88rem;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: gap var(--transition);
    }
    .home-card:hover .go { gap: 10px; }

    @keyframes homeFade { from { opacity: 0; } to { opacity: 1; } }
    @keyframes homeUp {
        from { opacity: 0; transform: translateY(16px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .vaccine-alert-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-left: 4px solid var(--warning);
        border-radius: var(--radius);
        box-shadow: var(--shadow-xs);
        padding: 18px 22px;
        max-width: 880px;
        margin: 16px auto 0;
        animation: homeUp 0.6s cubic-bezier(0.34, 1.4, 0.64, 1) 0.24s backwards;
    }
    .vaccine-alert-card .vaccine-header {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 12px;
        font-weight: 620;
        color: var(--text);
        font-size: 0.95rem;
    }
    .vaccine-list { display: flex; flex-direction: column; gap: 8px; }
    .vaccine-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        padding: 9px 13px;
        border-radius: var(--radius-sm);
        background: var(--surface-2);
        text-decoration: none;
        color: inherit;
        transition: background var(--transition);
    }
    .vaccine-row:hover { background: var(--surface-3); }
    .vaccine-row .vaccine-name { font-weight: 560; font-size: 0.88rem; color: var(--text); }
    .vaccine-row .vaccine-client { font-size: 0.78rem; color: var(--muted); }
    .vaccine-row .vaccine-badge {
        font-size: 0.72rem;
        font-weight: 600;
        padding: 3px 9px;
        border-radius: var(--radius-pill);
        white-space: nowrap;
    }
    .vaccine-badge.is-overdue { background: var(--danger-soft); color: var(--danger); }
    .vaccine-badge.is-soon    { background: var(--warning-soft); color: var(--warning); }
</style>

<div class="home-hero">
    <span class="eyebrow">La Tauge Gestion</span>
    <h1>Bienvenue sur votre espace</h1>
    <p>Gérez vos clients, vos chevaux et vos cours depuis une interface unique et claire.</p>
</div>

<div class="stat-row">
    <div class="stat-tile">
        <div class="stat-icon is-accent">👥</div>
        <div>
            <div class="stat-value"><?= esc($stats['clients']) ?></div>
            <div class="stat-label">Clients</div>
        </div>
    </div>
    <div class="stat-tile">
        <div class="stat-icon is-blue">🐴</div>
        <div>
            <div class="stat-value"><?= esc($stats['chevaux']) ?></div>
            <div class="stat-label">Chevaux</div>
        </div>
    </div>
    <div class="stat-tile">
        <div class="stat-icon is-purple">🏇</div>
        <div>
            <div class="stat-value"><?= esc($stats['coursMois']) ?></div>
            <div class="stat-label">Cours ce mois-ci</div>
        </div>
    </div>
    <a class="stat-tile stat-tile-link" href="<?= route_to('cours_impayes') ?>">
        <div class="stat-icon is-orange">💳</div>
        <div>
            <div class="stat-value"><?= esc($stats['impayes']) ?></div>
            <div class="stat-label">Paiements en attente</div>
        </div>
    </a>
</div>

<?php if (!empty($vaccinAlertes)) : ?>
<div class="vaccine-alert-card">
    <div class="vaccine-header">
        <span>💉</span>
        <span>Rappels de vaccination à prévoir</span>
    </div>
    <div class="vaccine-list">
        <?php foreach ($vaccinAlertes as $v) : ?>
            <a class="vaccine-row" href="<?= route_to('cheval_voir', $v['idpensions']) ?>">
                <span>
                    <span class="vaccine-name"><?= esc($v['nom']) ?></span>
                    <span class="vaccine-client"> — <?= esc($v['client']) ?></span>
                </span>
                <?php if ($v['jours'] < 0) : ?>
                    <span class="vaccine-badge is-overdue">En retard de <?= abs($v['jours']) ?> j</span>
                <?php else : ?>
                    <span class="vaccine-badge is-soon">Dans <?= $v['jours'] ?> j</span>
                <?php endif; ?>
            </a>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

<div class="home-grid">

    <div class="home-card" onclick="window.location.href='<?= base_url('client_ajout') ?>'">
        <div class="icon">➕</div>
        <div class="title">Ajouter un client</div>
        <span class="go">Commencer →</span>
    </div>

    <div class="home-card" onclick="window.location.href='<?= base_url('ajout_cheval') ?>'">
        <div class="icon">🐴</div>
        <div class="title">Ajouter un cheval</div>
        <span class="go">Commencer →</span>
    </div>

    <div class="home-card" onclick="window.location.href='<?= base_url('ajout_cours') ?>'">
        <div class="icon">🏇</div>
        <div class="title">Ajouter un cours</div>
        <span class="go">Commencer →</span>
    </div>

</div>

<?= $this->endSection() ?>
