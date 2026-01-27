<?= $this->extend('layout') ?>
<?= $this->section('contenu') ?>
<style>
    :root {
        --primary: #d12323;
        --primary-dark: #db3c3c;
        --bg: #ffffff;
        --text: #1a1a1a;
        --muted: #666666;
        --border: #e5e5e5;
        --accent-green: #10b981;
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
        min-height: 100vh;
        background: var(--bg);
        color: var(--text);
        font-family: 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;
        line-height: 1.6;
    }

    .latauge-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        /* On reste en haut */
        min-height: 60vh;
        gap: 60px;
        padding: 100px 20px 60px 20px;
        /* padding-top plus grand pour descendre un peu */
        background: linear-gradient(135deg, #f9fafb 0%, #f0f4f8 100%);
    }


    .latauge-row {
        width: 100%;
        text-align: center;
        max-width: 900px;
    }

    .latauge-row h1 {
        font-size: 3.5rem;
        font-weight: 900;
        color: var(--text);
        margin: 0;
        letter-spacing: -1px;
        line-height: 1.2;
        margin-bottom: 16px;
        animation: slideDownTitle 0.8s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .latauge-row p {
        font-size: 1.2rem;
        color: var(--muted);
        margin-top: 12px;
        animation: slideDownTitle 0.8s cubic-bezier(0.34, 1.56, 0.64, 1) 0.1s backwards;
    }

    @keyframes slideDownTitle {
        from {
            opacity: 0;
            transform: translateY(-40px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .latauge-row h1::after {
        content: '';
        display: block;
        width: 80px;
        height: 4px;
        background: linear-gradient(90deg, transparent, var(--primary), transparent);
        border-radius: 2px;
        margin: 20px auto 0;
        animation: expandLine 0.8s cubic-bezier(0.34, 1.56, 0.64, 1) 0.3s forwards;
        opacity: 0;
    }

    @keyframes expandLine {
        from {
            width: 0;
            opacity: 0;
        }

        to {
            width: 80px;
            opacity: 1;
        }
    }

    .buttons-container {
        display: flex;
        flex-direction: row;
        gap: 24px;
        width: 100%;
        max-width: 900px;
        justify-content: center;
        align-items: stretch;
        flex-wrap: wrap;
    }

    .latauge-btn {
        flex: 1;
        min-width: 240px;
        padding: 28px 40px;
        border: 2px solid var(--primary);
        border-radius: 12px;
        background: var(--primary);
        color: #ffffff;
        font-size: 1.1rem;
        font-weight: 700;
        cursor: pointer;
        transition: all var(--transition);
        box-shadow: 0 8px 24px rgba(235, 37, 37, 0.15);
        position: relative;
        overflow: hidden;
        letter-spacing: 0.3px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        animation: slideUpBtn 0.8s cubic-bezier(0.34, 1.56, 0.64, 1) 0.2s backwards;
    }

    @keyframes slideUpBtn {
        from {
            opacity: 0;
            transform: translateY(40px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .latauge-btn::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        background: rgba(255, 255, 255, 0.15);
        border-radius: 50%;
        transform: translate(-50%, -50%);
        transition: width var(--transition), height var(--transition);
    }

    .latauge-btn:hover::before {
        width: 300px;
        height: 300px;
    }

    .latauge-btn:hover {
        transform: translateY(-4px);
        box-shadow: 0 16px 40px rgba(37, 99, 235, 0.25);
        background: var(--primary-dark);
        border-color: var(--primary-dark);
    }

    .latauge-btn:active {
        transform: translateY(-1px);
        box-shadow: 0 4px 16px rgba(37, 99, 235, 0.15);
    }

    .latauge-btn.secondary {
        background: transparent;
        color: var(--primary);
        border: 2px solid var(--primary);
        box-shadow: none;
    }

    .latauge-btn.secondary:hover {
        background: var(--primary);
        color: #ffffff;
        box-shadow: 0 16px 40px rgba(37, 99, 235, 0.25);
    }

    .btn-icon {
        font-size: 1.4em;
    }

    @media (max-width: 768px) {
        .latauge-container {
            min-height: 60vh;
            gap: 40px;
            padding: 40px 20px;
        }

        .latauge-row h1 {
            font-size: 2.5rem;
        }

        .latauge-row p {
            font-size: 1.05rem;
        }

        .buttons-container {
            flex-direction: column;
            gap: 16px;
        }

        .latauge-btn {
            min-width: 100%;
            padding: 24px 32px;
            font-size: 1rem;
        }
    }

    @media (max-width: 480px) {
        .latauge-container {
            min-height: 50vh;
            gap: 30px;
            padding: 30px 16px;
        }

        .latauge-row h1 {
            font-size: 2rem;
        }

        .latauge-row p {
            font-size: 0.95rem;
        }

        .latauge-btn {
            padding: 20px 24px;
            font-size: 0.95rem;
        }

        .btn-icon {
            font-size: 1.2em;
        }
    }

    ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }
</style>
</head>

<body>
    <div class="latauge-container">
        <div class="latauge-row">
            <h1>La Tauge Gestion</h1>
        </div>

        <div class="buttons-container">
            <button class="latauge-btn" type="button" onclick="window.location.href='client_ajout'">
                <span class="btn-icon">➕</span>
                <span>Ajouter un client</span>
            </button>
            <button class="latauge-btn" type="button" onclick="window.location.href='ajout_cheval'">
                <span class="btn-icon">🐴</span>
                <span>Ajouter un cheval</span>
            </button>
        </div>
    </div>
</body>

</html>
<?= $this->endSection() ?>