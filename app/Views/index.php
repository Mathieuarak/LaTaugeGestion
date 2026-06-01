<?= $this->extend('layout') ?>
<?= $this->section('contenu') ?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700;900&family=DM+Sans:wght@400;500;600;700&display=swap');

    /* ===============================
       Container principal
       =============================== */
    .latauge-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: calc(100vh - 80px); /* 80px = hauteur navbar */
        gap: 56px;
        padding: 60px 20px;
    }

    /* ===============================
       Titre
       =============================== */
    .latauge-row {
        text-align: center;
    }

    .latauge-row h1 {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: clamp(2.8rem, 7vw, 5.5rem);
        font-weight: 900;
        color: #ffffff;
        letter-spacing: -1.5px;
        line-height: 1.15;
        margin-bottom: 0;
        text-shadow: 0 6px 32px rgba(0, 0, 0, 0.55);
        animation: slideDownTitle 0.9s cubic-bezier(0.34, 1.56, 0.64, 1) both;
    }

    .latauge-row .subtitle {
        font-family: 'DM Sans', sans-serif;
        font-size: clamp(0.9rem, 2vw, 1.1rem);
        font-weight: 500;
        color: rgba(255, 255, 255, 0.65);
        letter-spacing: 3px;
        text-transform: uppercase;
        margin-top: 14px;
        animation: fadeIn 1s ease 0.4s both;
    }

    /* Trait décoratif sous le titre */
    .title-line {
        width: 0;
        height: 3px;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.6), transparent);
        border-radius: 2px;
        margin: 20px auto 0;
        animation: expandLine 0.8s cubic-bezier(0.34, 1.56, 0.64, 1) 0.4s forwards;
    }

    @keyframes slideDownTitle {
        from { opacity: 0; transform: translateY(-50px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes expandLine {
        from { width: 0; opacity: 0; }
        to   { width: 120px; opacity: 1; }
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes slideUpBtn {
        from { opacity: 0; transform: translateY(50px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    /* ===============================
       Boutons
       =============================== */
    .buttons-container {
        display: flex;
        gap: 20px;
        width: 100%;
        max-width: 860px;
        justify-content: center;
        flex-wrap: wrap;
        align-items: stretch;
    }

    .latauge-btn {
        flex: 0 0 240px;
        width: 240px;
        padding: 30px 36px;
        border-radius: 16px;

        /* Glassmorphism */
        background: rgba(11, 46, 107, 0.45);
        backdrop-filter: blur(20px) saturate(160%);
        -webkit-backdrop-filter: blur(20px) saturate(160%);
        border: 1px solid rgba(255, 255, 255, 0.22);

        color: #ffffff;
        font-family: 'DM Sans', sans-serif;
        font-size: 1.05rem;
        font-weight: 700;
        letter-spacing: 0.3px;
        cursor: pointer;
        transition: all 250ms cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.30);

        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 14px;
        position: relative;
        overflow: hidden;

        animation: slideUpBtn 0.8s cubic-bezier(0.34, 1.56, 0.64, 1) backwards;
    }

    /* Décalage des animations */
    .latauge-btn:nth-child(1) { animation-delay: 0.15s; }
    .latauge-btn:nth-child(2) { animation-delay: 0.28s; }
    .latauge-btn:nth-child(3) { animation-delay: 0.40s; }

    /* Shimmer au hover */
    .latauge-btn::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(255,255,255,0.15) 0%, transparent 60%);
        opacity: 0;
        transition: opacity 250ms ease;
    }
    .latauge-btn:hover::before { opacity: 1; }

    .latauge-btn:hover {
        transform: translateY(-8px) scale(1.02);
        background: rgba(11, 46, 107, 0.70);
        border-color: rgba(255, 255, 255, 0.40);
        box-shadow: 0 20px 56px rgba(0, 0, 0, 0.40),
                    0 0 0 1px rgba(255,255,255,0.12);
    }

    .latauge-btn:active {
        transform: translateY(-2px) scale(0.99);
    }

    .btn-icon {
        font-size: 2rem;
        line-height: 1;
        filter: drop-shadow(0 2px 6px rgba(0,0,0,0.3));
        transition: transform 250ms ease;
    }
    .latauge-btn:hover .btn-icon {
        transform: scale(1.15) translateY(-2px);
    }

    .btn-label {
        font-size: 1rem;
        font-weight: 700;
        letter-spacing: 0.3px;
    }

    /* ===============================
       Responsive
       =============================== */
    @media (max-width: 768px) {
        .latauge-container { gap: 40px; padding: 40px 16px; }
        .buttons-container { flex-direction: column; align-items: center; }
        .latauge-btn { flex: 0 0 auto; width: 100%; max-width: 340px; padding: 24px 28px; flex-direction: row; }
        .latauge-btn.full-width { width: 100%; max-width: 340px; flex-direction: row; }
    }

    @media (max-width: 480px) {
        .latauge-btn { font-size: 0.95rem; padding: 20px 22px; }
        .btn-icon { font-size: 1.5rem; }
    }
</style>

<div class="latauge-container">

    <div class="latauge-row">
        <h1>La Tauge Gestion</h1>
        <div class="title-line"></div>
        <p class="subtitle">Gestion des chevaux </p>
    </div>

    <div class="buttons-container">

        <button class="latauge-btn" onclick="window.location.href='<?= base_url('client_ajout') ?>'">
            <span class="btn-icon">➕</span>
            <span class="btn-label">Ajouter un client</span>
        </button>

        <button class="latauge-btn" onclick="window.location.href='<?= base_url('ajout_cheval') ?>'">
            <span class="btn-icon">🐴</span>
            <span class="btn-label">Ajouter un cheval</span>
        </button>

        <button class="latauge-btn full-width" onclick="window.location.href='<?= base_url('ajout_cours') ?>'">
            <span class="btn-icon">🏇</span>
            <span class="btn-label">Ajouter un cours</span>
        </button>

    </div>

</div>

<?= $this->endSection() ?>