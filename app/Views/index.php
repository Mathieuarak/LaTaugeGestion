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

    .activity-card {
        display: flex;
        align-items: center;
        gap: 22px;
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        box-shadow: var(--shadow-xs);
        padding: 18px 24px;
        max-width: 880px;
        margin: 16px auto 0;
        animation: homeUp 0.6s cubic-bezier(0.34, 1.4, 0.64, 1) 0.26s backwards;
    }
    .activity-rings { flex-shrink: 0; transform: rotate(-90deg); }
    .ring-track { fill: none; stroke: var(--surface-3); stroke-width: 11; }
    .ring-fill {
        fill: none;
        stroke-linecap: round;
        stroke-width: 11;
        transform-origin: 70px 70px;
        animation-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        animation-duration: 1.3s;
        animation-fill-mode: forwards;
    }
    .ring-fill-1 { stroke: var(--accent); stroke-dasharray: 326.7; stroke-dashoffset: 326.7; animation-name: ringFill1; animation-delay: 0.4s; }
    .ring-fill-2 { stroke: var(--blue);   stroke-dasharray: 238.8; stroke-dashoffset: 238.8; animation-name: ringFill2; animation-delay: 0.55s; }
    .ring-fill-3 { stroke: var(--purple); stroke-dasharray: 150.8; stroke-dashoffset: 150.8; animation-name: ringFill3; animation-delay: 0.7s; }
    @keyframes ringFill1 { to { stroke-dashoffset: 71.9; } }
    @keyframes ringFill2 { to { stroke-dashoffset: 19.1; } }
    @keyframes ringFill3 { to { stroke-dashoffset: 52.8; } }

    .activity-title { font-weight: 620; font-size: 1rem; color: var(--text); margin-bottom: 2px; }
    .activity-sub { color: var(--muted); font-size: 0.85rem; }
    .activity-legend { display: flex; gap: 16px; margin-top: 10px; flex-wrap: wrap; }
    .activity-legend span {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 0.78rem;
        color: var(--text-soft);
        font-weight: 500;
    }
    .activity-legend i {
        width: 9px;
        height: 9px;
        border-radius: 50%;
        display: inline-block;
    }
    .activity-legend .dot-accent { background: var(--accent); }
    .activity-legend .dot-blue   { background: var(--blue); }
    .activity-legend .dot-purple { background: var(--purple); }

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
    <div class="stat-tile">
        <div class="stat-icon is-orange">💳</div>
        <div>
            <div class="stat-value"><?= esc($stats['impayes']) ?></div>
            <div class="stat-label">Paiements en attente</div>
        </div>
    </div>
</div>

<div class="activity-card">
    <svg class="activity-rings" viewBox="0 0 140 140" width="110" height="110">
        <circle class="ring-track" cx="70" cy="70" r="52" />
        <circle class="ring-track" cx="70" cy="70" r="38" />
        <circle class="ring-track" cx="70" cy="70" r="24" />
        <circle class="ring-fill ring-fill-1" cx="70" cy="70" r="52" />
        <circle class="ring-fill ring-fill-2" cx="70" cy="70" r="38" />
        <circle class="ring-fill ring-fill-3" cx="70" cy="70" r="24" />
    </svg>
    <div>
        <div class="activity-title">Activité de l'écurie</div>
        <div class="activity-sub">Un aperçu vivant de la vie du centre — clients, chevaux et cours au quotidien.</div>
        <div class="activity-legend">
            <span><i class="dot-accent"></i>Clients</span>
            <span><i class="dot-blue"></i>Chevaux</span>
            <span><i class="dot-purple"></i>Cours</span>
        </div>
    </div>
</div>

<div class="home-grid">

    <div class="home-card" onclick="window.location.href='<?= base_url('client_ajout') ?>'">
        <div class="icon">➕</div>
        <div class="title">Ajouter un client</div>
        <div class="desc">Enregistrer un nouveau propriétaire et ses coordonnées.</div>
        <span class="go">Commencer →</span>
    </div>

    <div class="home-card" onclick="window.location.href='<?= base_url('ajout_cheval') ?>'">
        <div class="icon">🐴</div>
        <div class="title">Ajouter un cheval</div>
        <div class="desc">Créer une fiche pension avec options et tarifs.</div>
        <span class="go">Commencer →</span>
    </div>

    <div class="home-card" onclick="window.location.href='<?= base_url('ajout_cours') ?>'">
        <div class="icon">🏇</div>
        <div class="title">Ajouter un cours</div>
        <div class="desc">Planifier un cours à l'unité ou un forfait.</div>
        <span class="go">Commencer →</span>
    </div>

</div>

<?= $this->endSection() ?>
