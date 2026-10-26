<?php
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../App/Core/Database.php';

use App\Core\Database;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

requireLogin();
requireRole(['admin', 'professor']);

$db = Database::getConnection();
$studentCount = (int) $db->query("SELECT COUNT(*) FROM students WHERE status = 'active'")->fetchColumn();
$workshopCount = (int) $db->query("SELECT COUNT(*) FROM workshops WHERE status = 'active'")->fetchColumn();
$messageCount = (int) $db->query("SELECT COUNT(*) FROM contact_messages WHERE status = 'new'")->fetchColumn();

renderHeader('Painel | Projeto Semente');
$flash = getFlash();
if ($flash) {
    echo '<div class="alert ' . e($flash['type']) . '">' . e($flash['message']) . '</div>';
}
?>
<div class="admin-shell">
    <?php include __DIR__ . '/menu.php'; ?>
    <main class="admin-main">
        <div class="panel-header">
            <div>
                <span class="eyebrow">Dashboard</span>
                <h1>Resumo operacional</h1>
            </div>
        </div>

        <div class="stats-grid">
            <div class="stat-box">
                <span>Alunos ativos</span>
                <strong><?php echo e($studentCount); ?></strong>
            </div>
            <div class="stat-box">
                <span>Oficinas ativas</span>
                <strong><?php echo e($workshopCount); ?></strong>
            </div>
            <div class="stat-box">
                <span>Mensagens novas</span>
                <strong><?php echo e($messageCount); ?></strong>
            </div>
        </div>

        <section class="admin-card">
            <h2>Boas-vindas</h2>
            <p>Bem-vindo(a), <?php echo e($_SESSION['user']['name'] ?? 'Usuário'); ?>. Esta área centraliza a administração do projeto.</p>
            <p>Use o menu lateral para acessar os módulos de gestão, frequência, conteúdo e mensagens.</p>
        </section>
    </main>
</div>
<?php renderFooter(); ?>
