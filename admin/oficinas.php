<?php
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../App/Core/Database.php';
require_once __DIR__ . '/../App/Core/Csrf.php';
require_once __DIR__ . '/../App/Core/Validator.php';

use App\Core\Csrf;
use App\Core\Database;
use App\Core\Validator;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

requireLogin();
requireRole(['admin', 'professor']);

$db = Database::getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    Csrf::requirePost();

    if (!Csrf::validate($_POST['csrf_token'] ?? '')) {
        setFlash('error', 'Token CSRF inválido.');
        redirect('/admin/alunos.php');
    }

    $action = $_POST['action'] ?? 'create';
    $name = trim((string) ($_POST['full_name'] ?? ''));
    $birthDate = trim((string) ($_POST['birth_date'] ?? ''));
    $phone = trim((string) ($_POST['phone'] ?? ''));
    $email = strtolower(trim((string) ($_POST['email'] ?? '')));
    $guardianName = trim((string) ($_POST['guardian_name'] ?? ''));
    $guardianContact = trim((string) ($_POST['guardian_contact'] ?? ''));
    $status = in_array($_POST['status'] ?? 'active', ['active', 'inactive'], true) ? $_POST['status'] : 'active';

    $errors = [];

    if (!Validator::required($name)) {
        $errors[] = 'Nome completo obrigatório.';
    }

    if ($birthDate !== '' && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $birthDate)) {
        $errors[] = 'Data de nascimento inválida.';
    }

    if ($errors) {
        setFlash('error', implode(' ', $errors));
        redirect('/admin/alunos.php');
    }

    if ($action === 'create') {
        $stmt = $db->prepare(
            'INSERT INTO students (full_name, birth_date, phone, email, guardian_name, guardian_contact, status) VALUES (:full_name, :birth_date, :phone, :email, :guardian_name, :guardian_contact, :status)'
        );
        $stmt->execute([
            ':full_name' => $name,
            ':birth_date' => $birthDate !== '' ? $birthDate : null,
            ':phone' => $phone !== '' ? $phone : null,
            ':email' => $email !== '' ? $email : null,
            ':guardian_name' => $guardianName !== '' ? $guardianName : null,
            ':guardian_contact' => $guardianContact !== '' ? $guardianContact : null,
            ':status' => $status,
        ]);
        setFlash('success', 'Aluno cadastrado com sucesso.');
    } else {
        $id = (int) ($_POST['student_id'] ?? 0);
        if ($id <= 0) {
            setFlash('error', 'Identificador do aluno inválido.');
            redirect('/admin/alunos.php');
        }

        $stmt = $db->prepare(
            'UPDATE students SET full_name = :full_name, birth_date = :birth_date, phone = :phone, email = :email, guardian_name = :guardian_name, guardian_contact = :guardian_contact, status = :status, updated_at = NOW() WHERE id = :id'
        );
        $stmt->execute([
            ':full_name' => $name,
            ':birth_date' => $birthDate !== '' ? $birthDate : null,
            ':phone' => $phone !== '' ? $phone : null,
            ':email' => $email !== '' ? $email : null,
            ':guardian_name' => $guardianName !== '' ? $guardianName : null,
            ':guardian_contact' => $guardianContact !== '' ? $guardianContact : null,
            ':status' => $status,
            ':id' => $id,
        ]);
        setFlash('success', 'Aluno atualizado com sucesso.');
    }

    redirect('/admin/alunos.php');
}

$students = $db->query("SELECT * FROM students ORDER BY full_name ASC")->fetchAll() ?: [];

renderHeader('Alunos | Projeto Semente');
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
                <span class="eyebrow">Cadastro</span>
                <h1>Gestão de alunos</h1>
            </div>
        </div>

        <section class="admin-card">
            <h2>Cadastrar ou editar aluno</h2>
            <form method="post" action="/admin/alunos.php">
                <?php echo Csrf::field(); ?>
                <input type="hidden" name="action" value="create">
                <div class="form-grid">
                    <div>
                        <label for="full_name">Nome completo</label>
                        <input id="full_name" name="full_name" type="text" required>
                    </div>
                    <div>
                        <label for="birth_date">Data de nascimento</label>
                        <input id="birth_date" name="birth_date" type="date">
                    </div>
                    <div>
                        <label for="phone">Telefone</label>
                        <input id="phone" name="phone" type="text">
                    </div>
                    <div>
                        <label for="email">E-mail</label>
                        <input id="email" name="email" type="email">
                    </div>
                    <div>
                        <label for="guardian_name">Nome do responsável</label>
                        <input id="guardian_name" name="guardian_name" type="text">
                    </div>
                    <div>
                        <label for="guardian_contact">Contato do responsável</label>
                        <input id="guardian_contact" name="guardian_contact" type="text">
                    </div>
                    <div>
                        <label for="status">Status</label>
                        <select id="status" name="status">
                            <option value="active">Ativo</option>
                            <option value="inactive">Inativo</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn primary">Salvar aluno</button>
            </form>
        </section>

        <section class="admin-card">
            <h2>Alunos</h2>
            <?php if ($students): ?>
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Telefone</th>
                                <th>Status</th>
                                <th>Responsável</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($students as $student): ?>
                                <tr>
                                    <td><?php echo e($student['full_name']); ?></td>
                                    <td><?php echo e($student['phone'] ?? '-'); ?></td>
                                    <td><?php echo e($student['status']); ?></td>
                                    <td><?php echo e($student['guardian_name'] ?? '-'); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="empty-state compact">
                    <p>Nenhum aluno cadastrado até o momento.</p>
                </div>
            <?php endif; ?>
        </section>
    </main>
</div>
<?php renderFooter(); ?>
