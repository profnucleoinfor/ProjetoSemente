:root {
    --verde: #05401F;
    --verde-escuro: #032d18;
    --verde-claro: #2d7d57;
    --verde-suave: #eaf6ef;
    --branco: #ffffff;
    --cinza: #f4f5f5;
    --cinza-escuro: #495057;
    --texto: #1d1d1f;
    --borda: #dfe5df;
    --erro: #7a1f1f;
    --sucesso: #16643b;
    --sombra: 0 10px 30px rgba(5, 64, 31, 0.08);
    --sidebar: #113a2b;
    --sidebar-bg: #0c2d20;
}

* { box-sizing: border-box; }
html { scroll-behavior: smooth; }
body {
    margin: 0;
    font-family: Arial, Helvetica, sans-serif;
    background: var(--cinza);
    color: var(--texto);
    line-height: 1.6;
}

a { color: var(--verde); text-decoration: none; }
a:hover { text-decoration: underline; }
img { max-width: 100%; height: auto; }

.container {
    max-width: 1160px;
    margin: 0 auto;
    padding: 0 20px;
}

.site-header {
    background: var(--verde);
    color: var(--branco);
    position: sticky;
    top: 0;
    z-index: 10;
    box-shadow: var(--sombra);
}

.site-header .container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    min-height: 72px;
    gap: 20px;
}

.brand {
    font-size: 1.3rem;
    font-weight: 700;
    letter-spacing: 0.02em;
}

.main-nav {
    display: flex;
    align-items: center;
    gap: 16px;
    flex-wrap: wrap;
}

.main-nav a {
    color: var(--branco);
    opacity: 0.9;
    font-weight: 600;
}

.main-nav a:hover { opacity: 1; }

main {
    padding-bottom: 48px;
}

.section {
    max-width: 1160px;
    margin: 0 auto;
    padding: 48px 20px 0;
}

.section.alt {
    background: var(--verde-suave);
    border-radius: 18px;
    padding: 42px 20px;
    margin-top: 48px;
}

.section-heading {
    margin-bottom: 26px;
}

.eyebrow {
    color: var(--verde-claro);
    text-transform: uppercase;
    letter-spacing: 0.08em;
    font-weight: 700;
    font-size: 0.78rem;
}

h1, h2, h3 {
    margin-top: 0;
    color: var(--verde-escuro);
    line-height: 1.2;
}

.hero {
    max-width: 1160px;
    margin: 0 auto;
    padding: 36px 20px 0;
    display: grid;
    grid-template-columns: 1.25fr 1fr;
    gap: 32px;
    align-items: center;
}

.hero-copy h1 {
    font-size: clamp(2.4rem, 4vw, 4rem);
    margin: 12px 0 16px;
}

.hero-copy p {
    font-size: 1.08rem;
    max-width: 620px;
}

.hero-actions {
    display: flex;
    gap: 16px;
    flex-wrap: wrap;
    margin-top: 24px;
}

.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-height: 46px;
    border-radius: 999px;
    padding: 0 22px;
    font-weight: 700;
    transition: 0.2s ease-in-out;
    border: 1px solid transparent;
    cursor: pointer;
}

.btn.primary {
    background: var(--verde);
    color: var(--branco);
}

.btn.secondary {
    background: transparent;
    color: var(--verde);
    border-color: var(--verde);
}

.btn:hover {
    opacity: 0.95;
    text-decoration: none;
}

.hero-visual {
    min-height: 420px;
    border-radius: 24px;
    background: linear-gradient(135deg, rgba(5,64,31,0.84), rgba(45,125,87,0.7)),
        url('../img/hero-bg.jpg') center/cover no-repeat;
    display: flex;
    align-items: flex-end;
    padding: 24px;
    box-shadow: var(--sombra);
}

.hero-card {
    background: rgba(255,255,255,0.12);
    backdrop-filter: blur(2px);
    color: var(--branco);
    padding: 18px 20px;
    border-radius: 14px;
    border: 1px solid rgba(255,255,255,0.18);
    max-width: 260px;
}

.feature-grid,
.info-grid,
.gallery-grid,
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 20px;
}

.feature-card,
.info-card,
.contact-card,
.contact-info,
.box-card,
.empty-state,
.cta-box,
.admin-card,
.stat-box {
    background: var(--branco);
    border: 1px solid var(--borda);
    border-radius: 18px;
    padding: 24px;
    box-shadow: var(--sombra);
}

.two-column {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 22px;
}

.contact-layout {
    display: grid;
    grid-template-columns: 1.3fr 0.7fr;
    gap: 24px;
}

form {
    display: grid;
    gap: 16px;
}

label {
    display: block;
    font-weight: 700;
    margin-bottom: 8px;
    color: var(--verde-escuro);
}

input, textarea, select, button {
    font: inherit;
}

input, textarea, select {
    width: 100%;
    border: 1px solid var(--borda);
    border-radius: 12px;
    padding: 12px 14px;
    background: var(--branco);
}

button {
    border: none;
    cursor: pointer;
}

textarea {
    resize: vertical;
    min-height: 140px;
}

.gallery-item {
    margin: 0;
    background: var(--branco);
    border: 1px solid var(--borda);
    border-radius: 18px;
    overflow: hidden;
    box-shadow: var(--sombra);
}

.gallery-placeholder {
    min-height: 220px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, rgba(5,64,31,0.12), rgba(45,125,87,0.05));
    border-bottom: 1px solid var(--borda);
    color: var(--verde-escuro);
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.gallery-item figcaption {
    padding: 14px 18px 16px;
    color: var(--cinza-escuro);
}

.page-intro {
    padding-top: 42px;
}

.cta-box {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 20px;
    flex-wrap: wrap;
}

.alert {
    max-width: 1160px;
    margin: 24px auto 0;
    border-radius: 12px;
    padding: 14px 18px;
    border: 1px solid transparent;
}

.alert.error {
    background: #fff1f1;
    color: var(--erro);
    border-color: #f0b4b4;
}

.alert.success {
    background: #edf9f0;
    color: var(--sucesso);
    border-color: #b8dcbc;
}

.admin-shell {
    max-width: 1360px;
    margin: 32px auto 0;
    display: grid;
    grid-template-columns: 250px minmax(0, 1fr);
    gap: 24px;
    padding: 0 20px 48px;
}

.admin-sidebar {
    background: var(--sidebar-bg);
    color: var(--branco);
    border-radius: 18px;
    padding: 18px 14px;
    min-height: 520px;
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.brand-box {
    padding: 12px 10px 18px;
    border-bottom: 1px solid rgba(255,255,255,0.12);
}

.brand-box strong,
.brand-box small {
    display: block;
}

.admin-nav {
    display: grid;
    gap: 8px;
}

.admin-nav a {
    display: block;
    color: var(--branco);
    opacity: 0.85;
    padding: 10px 12px;
    border-radius: 10px;
}

.admin-nav a.active,
.admin-nav a:hover {
    background: rgba(255,255,255,0.08);
    opacity: 1;
    text-decoration: none;
}

.logout-link {
    margin-top: auto;
    color: var(--branco);
    opacity: 0.8;
}

.admin-main {
    display: grid;
    gap: 20px;
}

.panel-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.form-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 16px;
}

.table-wrap {
    overflow-x: auto;
}

table {
    width: 100%;
    border-collapse: collapse;
    min-width: 720px;
}

th, td {
    text-align: left;
    padding: 12px 10px;
    border-bottom: 1px solid var(--borda);
    vertical-align: top;
}

th {
    background: #f7f8f7;
    color: var(--verde-escuro);
}

.stat-box {
    display: grid;
    gap: 10px;
    min-height: 140px;
    align-content: center;
}

.stat-box strong {
    font-size: 2rem;
    color: var(--verde-escuro);
}

.message-card {
    display: grid;
    gap: 12px;
}

.message-header {
    display: flex;
    justify-content: space-between;
    gap: 12px;
    align-items: center;
    flex-wrap: wrap;
}

.small-text {
    font-size: 0.85rem;
    color: var(--cinza-escuro);
}

.badge {
    display: inline-flex;
    align-items: center;
    border-radius: 999px;
    padding: 6px 10px;
    text-transform: uppercase;
    font-size: 0.7rem;
    font-weight: 700;
}

.status-new { background: #fff0d9; color: #9c6400; }
.status-in_progress { background: #ebf0ff; color: #2947a9; }
.status-resolved { background: #eafaf1; color: #0d6b2d; }

.inline-form {
    display: grid;
    gap: 12px;
}

.inline-actions {
    display: flex;
    gap: 12px;
    align-items: center;
    flex-wrap: wrap;
}

.small {
    min-height: 42px;
    padding-inline: 18px;
}

.empty-state {
    text-align: center;
}

.empty-state.compact {
    padding: 28px 18px;
}

footer {
    max-width: 1160px;
    margin: 48px auto 0;
    padding: 18px 20px 40px;
    color: var(--cinza-escuro);
    text-align: center;
}

@media (max-width: 840px) {
    .hero,
    .two-column,
    .contact-layout,
    .admin-shell {
        grid-template-columns: 1fr;
    }

    .site-header .container,
    .cta-box,
    .panel-header,
    .message-header {
        flex-direction: column;
        align-items: flex-start;
    }

    .admin-sidebar {
        min-height: auto;
    }
}
