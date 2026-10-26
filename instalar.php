<?php
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../App/Core/Auth.php';
require_once __DIR__ . '/../App/Core/Database.php';

use App\Core\Auth;
use App\Core\Database;

Auth::requireRole(['admin', 'professor']);

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
<div class="card">
    <h1>Painel administrativo</h1>
    <p class="muted">Bem-vindo(a), <?php echo e($_SESSION['user']['name'] ?? 'Usuário'); ?>.</p>
    <p class="muted">Perfil: <?php echo e($_SESSION['user']['profile'] ?? 'indefinido'); ?></p>
</div>

<div class="stats" style="margin-top: 24px;">
    <div class="stat">
        <strong>Alunos ativos</strong>
        <div style="font-size: 2rem; margin-top: 12px;"><?php echo e($studentCount); ?></div>
    </div>
    <div class="stat">
        <strong>Oficinas ativas</strong>
        <div style="font-size: 2rem; margin-top: 12px;"><?php echo e($workshopCount); ?></div>
    </div>
    <div class="stat">
        <strong>Mensagens novas</strong>
        <div style="font-size: 2rem; margin-top: 12px;"><?php echo e($messageCount); ?></div>
    </div>
</div>

<div class="row" style="margin-top: 24px;">
    <div class="card">
        <h2>Resumo operacional</h2>
        <p class="muted">Esta área está protegida por autenticação e autorização no servidor.</p>
        <ul>
            <li>Gestão de alunos</li>
            <li>Gestão de oficinas</li>
            <li>Registro de frequência</li>
            <li>Conteúdo institucional</li>
            <li>Mensagens recebidas</li>
        </ul>
    </div>
    <div class="card">
        <h2>Ações rápidas</h2>
        <p><a href="/logout.php">Encerrar sessão</a></p>
        <p><a href="/instalar.php">Procedimento de instalação</a></p>
    </div>
</div>
<?php renderFooter();
