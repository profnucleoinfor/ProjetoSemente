<?php
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../App/Core/Database.php';

use App\Core\Database;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

requireLogin();
requireRole(['admin']);

$db = Database::getConnection();
$stmt = $db->query("SELECT id, name, email, profile, status, created_at FROM users ORDER BY created_at DESC");
$users = $stmt->fetchAll() ?: [];

renderHeader('Usuários | Projeto Semente');
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
                <span class="eyebrow">Administração</span>
                <h1>Gestão de usuários</h1>
            </div>
        </div>

        <?php if ($users): ?>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>E-mail</th>
                            <th>Perfil</th>
                            <th>Status</th>
                            <th>Criado em</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?php echo e($user['name']); ?></td>
                                <td><?php echo e($user['email']); ?></td>
                                <td><?php echo e($user['profile']); ?></td>
                                <td><?php echo e($user['status']); ?></td>
                                <td><?php echo e(date('d/m/Y H:i', strtotime($user['created_at']))); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="empty-state compact">
                <p>Nenhum usuário cadastrado no sistema.</p>
            </div>
        <?php endif; ?>
    </main>
</div>
<?php renderFooter(); ?>
