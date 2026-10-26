<?php
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/App/Core/Database.php';

use App\Core\Database;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$pdo = Database::getConnection();

renderHeader('Projeto Semente');
$flash = getFlash();
if ($flash) {
    echo '<div class="alert ' . e($flash['type']) . '">' . e($flash['message']) . '</div>';
}
?>

<section class="hero">
    <div class="hero-copy">
        <span class="eyebrow">Uma semente para a vida</span>
        <h1>Projeto Semente</h1>
        <p>Promovemos educação, cultura, esporte e cidadania em Santa Rita, Paraíba, fortalecendo vínculos comunitários e oportunidades para crianças, adolescentes e famílias.</p>
        <div class="hero-actions">
            <a class="btn primary" href="/quem-somos.php">Conhecer o projeto</a>
            <a class="btn secondary" href="/oficinas.php">Ver oficinas</a>
        </div>
    </div>
    <div class="hero-visual" aria-label="Imagem institucional do Projeto Semente">
        <div class="hero-card">
            <strong>Compromisso com a comunidade</strong>
            <p>Espaço de acolhimento, aprendizado e transformação social.</p>
        </div>
    </div>
</section>

<section class="section">
    <div class="section-heading">
        <span class="eyebrow">Nossa proposta</span>
        <h2>Educação e cidadania em movimento</h2>
    </div>
    <div class="feature-grid">
        <article class="feature-card">
            <h3>Educação</h3>
            <p>Atividades artísticas, culturais e pedagógicas que ampliam oportunidades, protagonismo e pertencimento.</p>
        </article>
        <article class="feature-card">
            <h3>Cultura</h3>
            <p>Experiências criativas e fortalecedoras da identidade local, respeitando o contexto da comunidade.</p>
        </article>
        <article class="feature-card">
            <h3>Esporte</h3>
            <p>Práticas responsáveis e inclusivas que estimulam saúde, disciplina e convivência.</p>
        </article>
    </div>
</section>

<section class="section alt">
    <div class="section-heading">
        <span class="eyebrow">Como atuamos</span>
        <h2>Um espaço de acolhimento e desenvolvimento</h2>
    </div>
    <div class="info-grid">
        <div class="info-card">
            <h3>Missão</h3>
            <p>Contribuir para o desenvolvimento integral de pessoas e comunidades por meio de ações educativas, culturais e esportivas.</p>
        </div>
        <div class="info-card">
            <h3>Valores</h3>
            <p>Acolhimento, respeito, participação, responsabilidade social, cultura e inclusão.</p>
        </div>
    </div>
</section>

<section class="section">
    <div class="section-heading">
        <span class="eyebrow">Contato</span>
        <h2>Fale com a equipe</h2>
    </div>
    <div class="cta-box">
        <p>Se quiser conhecer mais sobre o Projeto Semente, solicitar informações ou enviar uma mensagem, entre em contato conosco.</p>
        <a class="btn primary" href="/contato.php">Entrar em contato</a>
    </div>
</section>

<?php renderFooter(); ?>
