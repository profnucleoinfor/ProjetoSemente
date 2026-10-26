<?php
require_once __DIR__ . '/includes/functions.php';

renderHeader('Quem Somos | Projeto Semente');
$flash = getFlash();
if ($flash) {
    echo '<div class="alert ' . e($flash['type']) . '">' . e($flash['message']) . '</div>';
}
?>

<section class="section page-intro">
    <div class="section-heading">
        <span class="eyebrow">Quem somos</span>
        <h1>Uma iniciativa dedicada ao desenvolvimento humano e comunitário</h1>
    </div>
</section>

<section class="section">
    <div class="two-column">
        <div>
            <h2>História</h2>
            <p>
                O Projeto Semente nasce como uma iniciativa voltada ao fortalecimento da educação, da cultura,
                do esporte e da cidadania na cidade de Santa Rita, Paraíba. A proposta central é oferecer oportunidades
                reais de desenvolvimento, acolhimento e participação social para a comunidade.
            </p>
            <p>
                Sua atuação é pautada pelo respeito à diversidade, pela construção de vínculos comunitários e pela
                valorização do protagonismo das pessoas que fazem parte do processo.
            </p>
        </div>
        <div class="box-card">
            <h3>Missão</h3>
            <p>Promover ações educativas, culturais e esportivas que ampliem oportunidades de desenvolvimento e pertencimento.</p>
        </div>
    </div>
</section>

<section class="section alt">
    <div class="info-grid">
        <article class="info-card">
            <h3>Visão</h3>
            <p>Ser uma referência de atuação comunitária, com impacto positivo e duradouro na vida de pessoas e famílias.</p>
        </article>
        <article class="info-card">
            <h3>Valores</h3>
            <p>Acolhimento, responsabilidade social, inclusão, respeito, participação e compromisso com a comunidade.</p>
        </article>
    </div>
</section>

<section class="section">
    <div class="cta-box">
        <p>Quer conhecer mais sobre as ações desenvolvidas pelo Projeto Semente?</p>
        <a class="btn primary" href="/oficinas.php">Confira as oficinas</a>
    </div>
</section>

<?php renderFooter(); ?>
