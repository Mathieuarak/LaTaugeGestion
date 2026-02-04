<?= $this->extend('layout') ?>
<?= $this->section('contenu') ?>

<style>
    :root {
        --primary: #2f2966;       /* Indigo clair */
        --primary-dark: #2b2d85;  /* Indigo foncé */
        --text: #ffffff;           /* Texte blanc pour contraste */
        --muted: rgba(156, 184, 216, 0.75);
        --transition: 200ms cubic-bezier(0.2, 0.9, 0.3, 1);
    }

    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    html {
        height: 100%;
        -webkit-font-smoothing: antialiased;
    }

    body {
        background: url('<?= base_url("cheche.jpg") ?>') no-repeat center center / cover fixed;
        min-height: 100vh;
        color: var(--text);
        font-family: 'Segoe UI', Roboto, 'Helvetica Neue', system-ui, -apple-system;
        line-height: 1.6;
        padding: 24px 16px;
    }

    /* ===============================
       Container principal
       =============================== */
    .latauge-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: flex-start;
        min-height: 60vh;
        gap: 60px;
        padding: 100px 20px 60px;
        background: transparent; /* PLUS DE FOND BLANC */
    }

    .latauge-row {
        width: 100%;
        text-align: center;
        max-width: 900px;
    }

    .latauge-row h1 {
        font-size: 4.5rem; /* Agrandi le titre */
        font-weight: 900;
        color: var(--text);
        letter-spacing: -1px;
        line-height: 1.2;
        margin-bottom: 16px;
        text-shadow: 0 8px 30px rgba(0, 0, 0, 0.45);
        animation: slideDownTitle 0.8s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .latauge-row h1::after {
        content: '';
        display: block;
        width: 100px; /* légèrement plus large que le titre */
        height: 4px;
        background: linear-gradient(90deg, transparent, var(--primary), transparent);
        border-radius: 2px;
        margin: 20px auto 0;
        animation: expandLine 0.8s cubic-bezier(0.34, 1.56, 0.64, 1) 0.3s forwards;
        opacity: 0;
    }

    @keyframes slideDownTitle {
        from { opacity: 0; transform: translateY(-40px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes expandLine {
        from { width: 0; opacity: 0; }
        to { width: 100px; opacity: 1; }
    }

    /* ===============================
       Boutons
       =============================== */
    .buttons-container {
        display: flex;
        gap: 24px;
        width: 100%;
        max-width: 900px;
        justify-content: center;
        flex-wrap: wrap;
    }

    .latauge-btn {
        flex: 1;
        min-width: 240px;
        padding: 28px 40px;
        border-radius: 14px;
        border: 2px solid var(--primary);
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: #ffffff;
        font-size: 1.1rem;
        font-weight: 700;
        cursor: pointer;
        transition: all var(--transition);
        box-shadow: 0 12px 36px rgba(0,0,0,0.35);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        position: relative;
        overflow: hidden;
        animation: slideUpBtn 0.8s cubic-bezier(0.34,1.56,0.64,1) 0.2s backwards;
    }

    @keyframes slideUpBtn {
        from { opacity: 0; transform: translateY(40px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .latauge-btn::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at center, rgba(255,255,255,0.2), transparent 70%);
        opacity: 0;
        transition: opacity var(--transition);
    }

    .latauge-btn:hover::before { opacity: 1; }

    .latauge-btn:hover {
        transform: translateY(-6px) scale(1.03);
        box-shadow: 0 24px 60px rgba(0,0,0,0.45);
    }

    .latauge-btn.full-width {
        flex: 0 0 100%;
        max-width: 400px;
        margin: 0 auto;
    }

    .btn-icon {
        font-size: 1.4em;
    }

    /* ===============================
       Responsive
       =============================== */
    @media (max-width: 768px) {
        .latauge-container { padding: 60px 20px; gap: 40px; }
        .latauge-row h1 { font-size: 3rem; }
        .buttons-container { flex-direction: column; }
        .latauge-btn { width: 100%; padding: 24px 32px; }
    }

    @media (max-width: 480px) {
        .latauge-row h1 { font-size: 2.5rem; }
        .latauge-btn { font-size: 1rem; padding: 20px 24px; }
    }
</style>

<div class="latauge-container">
    <div class="latauge-row">
        <h1>La Tauge Gestion</h1>
    </div>

    <div class="buttons-container">
        <button class="latauge-btn" onclick="window.location.href='client_ajout'">
            <span class="btn-icon">➕</span>
            Ajouter un client
        </button>

        <button class="latauge-btn" onclick="window.location.href='ajout_cheval'">
            <span class="btn-icon">🐴</span>
            Ajouter un cheval
        </button>

        <button class="latauge-btn full-width" onclick="window.location.href='ajout_cours'">
            <span class="btn-icon">🏇</span>
            Ajouter un cours
        </button>
    </div>
</div>

<?= $this->endSection() ?>
