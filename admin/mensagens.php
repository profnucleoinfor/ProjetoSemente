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
        redirect('/admin/conteudo.php');
    }

    $key = trim((string) ($_POST['content_key'] ?? ''));
    $value = trim((string) ($_POST['content_value'] ?? ''));
    $type = in_array($_POST['content_type'] ?? 'text', ['text', 'html', 'json', 'boolean'], true) ? $_POST['content_type'] : 'text';

    if ($key === '' || $value === '') {
        setFlash('error', 'Chave e valor do conteúdo são obrigatórios.');
        redirect('/admin/conteudo.php');
    }

    $stmt = $db->prepare(
        'INSERT INTO site_content (content_key, content_value, content_type) VALUES (:key, :value, :type) ON DUPLICATE KEY UPDATE content_value = VALUES(content_value), content_type = VALUES(content_type), updated_at = NOW()'
    );

    $stmt->execute([
        ':key' => $key,
        ':value' => $value,
        ':type' => $type,
    ]);

    setFlash('success', 'Conteúdo atualizado com sucesso.');
    redirect('/admin/conteudo.php');
}

$contents = $db->query("SELECT content_key, content_value, content_type, updated_at FROM site_content ORDER BY content_key ASC")->fetchAll() ?: [];

renderHeader('Conteúdo | Projeto Semente');
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
                <span class="eyebrow">Configuração</span>
                <h1>Conteúdo institucional</h1>
            </div>
        </div>

        <section class="admin-card">
            <h2>Atualizar conteúdo</h2>
            <form method="post" action="/admin/conteudo.php">
                <?php echo Csrf::field(); ?>
                <div class="form-grid">
                    <div>
                        <label for="content_key">Chave</label>
                        <input id="content_key" name="content_key" type="text" required>
                    </div>
                    <div>
                        <label for="content_type">Tipo</label>
                        <select id="content_type" name="content_type">
                            <option value="text">Texto</option>
                            <option value="html">HTML</option>
                            <option value="json">JSON</option>
                            <option value="boolean">Booleano</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label for="content_value">Valor</label>
                    <textarea id="content_value" name="content_value" rows="5" required></textarea>
                </div>
                <button type="submit" class="btn primary">Salvar conteúdo</button>
            </form>
        </section>

        <section class="admin-card">
            <h2>Conteúdos cadastrados</h2>
            <?php if ($contents): ?>
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>Chave</th>
                                <th>Tipo</th>
                                <th>Valor</th>
                                <th>Atualizado em</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($contents as $content): ?>
                                <tr>
                                    <td><?php echo e($content['content_key']); ?></td>
                                    <td><?php echo e($content['content_type']); ?></td>
                                    <td><?php echo e(substr($content['content_value'], 0, 120)); ?></td>
                                    <td><?php echo e(date('d/m/Y H:i', strtotime($content['updated_at']))); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="empty-state compact">
                    <p>Nenhum conteúdo cadastrado.</p>
                </div>
            <?php endif; ?>
        </section>
    </main>
</div>
<?php renderFooter(); ?>
