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
        redirect('/admin/oficinas.php');
    }

    $name = trim((string) ($_POST['name'] ?? ''));
    $description = trim((string) ($_POST['description'] ?? ''));
    $status = in_array($_POST['status'] ?? 'active', ['active', 'inactive'], true) ? $_POST['status'] : 'active';

    if ($name === '' || $description === '') {
        setFlash('error', 'Nome e descrição da oficina são obrigatórios.');
        redirect('/admin/oficinas.php');
    }

    $stmt = $db->prepare('INSERT INTO workshops (name, description, status) VALUES (:name, :description, :status)');
    $stmt->execute([
        ':name' => $name,
        ':description' => $description,
        ':status' => $status,
    ]);

    setFlash('success', 'Oficina cadastrada com sucesso.');
    redirect('/admin/oficinas.php');
}

$workshops = $db->query("SELECT * FROM workshops ORDER BY name ASC")->fetchAll() ?: [];

renderHeader('Oficinas | Projeto Semente');
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
                <span class="eyebrow">Programa</span>
                <h1>Gestão de oficinas</h1>
            </div>
        </div>

        <section class="admin-card">
            <h2>Cadastrar oficina</h2>
            <form method="post" action="/admin/oficinas.php">
                <?php echo Csrf::field(); ?>
                <div class="form-grid">
                    <div>
                        <label for="name">Nome da oficina</label>
                        <input id="name" name="name" type="text" required>
                    </div>
                    <div>
                        <label for="status">Status</label>
                        <select id="status" name="status">
                            <option value="active">Ativa</option>
                            <option value="inactive">Inativa</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label for="description">Descrição</label>
                    <textarea id="description" name="description" rows="5" required></textarea>
                </div>
                <button type="submit" class="btn primary">Salvar oficina</button>
            </form>
        </section>

        <section class="admin-card">
            <h2>Oficinas cadastradas</h2>
            <?php if ($workshops): ?>
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Status</th>
                                <th>Descrição</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($workshops as $workshop): ?>
                                <tr>
                                    <td><?php echo e($workshop['name']); ?></td>
                                    <td><?php echo e($workshop['status']); ?></td>
                                    <td><?php echo e(substr($workshop['description'], 0, 120)); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="empty-state compact">
                    <p>Nenhuma oficina cadastrada.</p>
                </div>
            <?php endif; ?>
        </section>
    </main>
</div>
<?php renderFooter(); ?>
