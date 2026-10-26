<?php
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/App/Core/Database.php';

use App\Core\Database;

$workshops = [];

try {
    $db = Database::getConnection();
    $stmt = $db->query("SELECT id, name, description, status FROM workshops WHERE status = 'active' ORDER BY name ASC");
    $workshops = $stmt->fetchAll() ?: [];
} catch (Throwable $exception) {
    $workshops = [];
}

renderHeader('Oficinas | Projeto Semente');
$flash = getFlash();
if ($flash) {
    echo '<div class="alert ' . e($flash['type']) . '">' . e($flash['message']) . '</div>';
}
?>

<section class="section page-intro">
    <div class="section-heading">
        <span class="eyebrow">Oficinas</span>
        <h1>Ações de aprendizado, cultura e protagonismo</h1>
    </div>
</section>

<section class="section">
    <?php if ($workshops): ?>
        <div class="feature-grid">
            <?php foreach ($workshops as $workshop): ?>
                <article class="feature-card">
                    <h2><?php echo e($workshop['name']); ?></h2>
                    <p><?php echo nl2br(e($workshop['description'])); ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="empty-state">
            <h2>Oficinas em atualização</h2>
            <p>As atividades do Projeto Semente serão divulgadas conforme a programação institucional for definida e validada.</p>
        </div>
    <?php endif; ?>
</section>

<section class="section alt">
    <div class="cta-box">
        <p>Quer participar ou conhecer mais sobre as ações em andamento?</p>
        <a class="btn primary" href="/contato.php">Fale com a equipe</a>
    </div>
</section>

<?php renderFooter(); ?>
