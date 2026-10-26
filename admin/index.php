<?php
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../App/Core/Database.php';
require_once __DIR__ . '/../App/Core/Csrf.php';

use App\Core\Csrf;
use App\Core\Database;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

requireLogin();
requireRole(['admin']);

$db = Database::getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    Csrf::requirePost();

    if (!Csrf::validate($_POST['csrf_token'] ?? '')) {
        setFlash('error', 'Token CSRF inválido.');
        redirect('/admin/mensagens.php');
    }

    $id = (int) ($_POST['message_id'] ?? 0);
    $status = in_array($_POST['status'] ?? 'new', ['new', 'in_progress', 'resolved'], true) ? $_POST['status'] : 'new';

    if ($id <= 0) {
        setFlash('error', 'Mensagem inválida.');
        redirect('/admin/mensagens.php');
    }

    $stmt = $db->prepare('UPDATE contact_messages SET status = :status WHERE id = :id');
    $stmt->execute([
        ':status' => $status,
        ':id' => $id,
    ]);

    setFlash('success', 'Status da mensagem atualizado.');
    redirect('/admin/mensagens.php');
}

$messages = $db->query("SELECT * FROM contact_messages ORDER BY received_at DESC")->fetchAll() ?: [];

renderHeader('Mensagens | Projeto Semente');
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
                <span class="eyebrow">Comunicados</span>
                <h1>Mensagens recebidas</h1>
            </div>
        </div>

        <?php if ($messages): ?>
            <?php foreach ($messages as $message): ?>
                <article class="admin-card message-card">
                    <div class="message-header">
                        <div>
                            <strong><?php echo e($message['sender_name']); ?></strong>
                            <div class="small-text"><?php echo e($message['sender_email']); ?></div>
                        </div>
                        <span class="badge status-<?php echo e($message['status']); ?>"><?php echo e($message['status']); ?></span>
                    </div>
                    <p><strong>Assunto:</strong> <?php echo e($message['subject']); ?></p>
                    <p><?php echo nl2br(e($message['message'])); ?></p>
                    <form method="post" action="/admin/mensagens.php" class="inline-form">
                        <?php echo Csrf::field(); ?>
                        <input type="hidden" name="message_id" value="<?php echo e($message['id']); ?>">
                        <label for="status_<?php echo e($message['id']); ?>">Atualizar status</label>
                        <div class="inline-actions">
                            <select id="status_<?php echo e($message['id']); ?>" name="status">
                                <option value="new" <?php echo $message['status'] === 'new' ? 'selected' : ''; ?>>Novo</option>
                                <option value="in_progress" <?php echo $message['status'] === 'in_progress' ? 'selected' : ''; ?>>Em andamento</option>
                                <option value="resolved" <?php echo $message['status'] === 'resolved' ? 'selected' : ''; ?>>Resolvido</option>
                            </select>
                            <button type="submit" class="btn primary small">Salvar</button>
                        </div>
                    </form>
                </article>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="empty-state compact">
                <p>Nenhuma mensagem recebida até o momento.</p>
            </div>
        <?php endif; ?>
    </main>
</div>
<?php renderFooter(); ?>
