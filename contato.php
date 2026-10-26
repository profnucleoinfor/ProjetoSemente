<?php
require_once __DIR__ . '/includes/functions.php';

renderHeader('Parceiros | Projeto Semente');
$flash = getFlash();
if ($flash) {
    echo '<div class="alert ' . e($flash['type']) . '">' . e($flash['message']) . '</div>';
}
?>

<section class="section page-intro">
    <div class="section-heading">
        <span class="eyebrow">Parceiros</span>
        <h1>Parcerias e apoio da comunidade</h1>
    </div>
</section>

<section class="section">
    <div class="feature-grid">
        <article class="feature-card">
            <h2>Parcerias institucionais</h2>
            <p>O Projeto Semente valoriza alianças e ações conjuntas com organizações, lideranças e agentes locais.</p>
        </article>
        <article class="feature-card">
            <h2>Comunidade</h2>
            <p>O protagonismo comunitário é essencial para a construção de uma rede de apoio e fortalecimento social.</p>
        </article>
        <article class="feature-card">
            <h2>Colaboração</h2>
            <p>Os parceiros atuam em apoio à educação, cultura, esporte e cidadania, sempre respeitando os objetivos da iniciativa.</p>
        </article>
    </div>
    <p class="muted">A lista institucional será atualizada conforme os parceiros forem oficialmente cadastrados e validados.</p>
</section>

<?php renderFooter(); ?>
