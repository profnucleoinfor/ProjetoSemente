<?php
require_once __DIR__ . '/includes/functions.php';

renderHeader('Galeria | Projeto Semente');
$flash = getFlash();
if ($flash) {
    echo '<div class="alert ' . e($flash['type']) . '">' . e($flash['message']) . '</div>';
}
?>

<section class="section page-intro">
    <div class="section-heading">
        <span class="eyebrow">Galeria</span>
        <h1>Memórias e momentos do projeto</h1>
    </div>
</section>

<section class="section">
    <div class="gallery-grid">
        <?php for ($i = 1; $i <= 6; $i++): ?>
            <figure class="gallery-item">
                <div class="gallery-placeholder" aria-label="Imagem institucional placeholder <?php echo e($i); ?>">
                    <span>Foto <?php echo e($i); ?></span>
                </div>
                <figcaption>Registro institucional <?php echo e($i); ?></figcaption>
            </figure>
        <?php endfor; ?>
    </div>
    <p class="muted">As imagens oficiais serão adicionadas quando os arquivos institucionais forem disponibilizados pela equipe do projeto.</p>
</section>

<?php renderFooter(); ?>
