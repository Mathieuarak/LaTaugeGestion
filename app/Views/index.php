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
