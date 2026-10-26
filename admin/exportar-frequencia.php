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
requireRole(['admin', 'professor']);

$db = Database::getConnection();
$workshops = $db->query("SELECT id, name, status FROM workshops WHERE status = 'active' ORDER BY name ASC")->fetchAll() ?: [];
$students = $db->query("SELECT id, full_name FROM students WHERE status = 'active' ORDER BY full_name ASC")->fetchAll() ?: [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    Csrf::requirePost();

    if (!Csrf::validate($_POST['csrf_token'] ?? '')) {
        setFlash('error', 'Token CSRF inválido.');
        redirect('/admin/frequencia.php');
    }

    $workshopId = (int) ($_POST['workshop_id'] ?? 0);
    $attendanceDate = trim((string) ($_POST['attendance_date'] ?? ''));
    $studentId = (int) ($_POST['student_id'] ?? 0);
    $status = in_array($_POST['status'] ?? 'present', ['present', 'absent', 'late'], true) ? $_POST['status'] : 'present';

    if ($workshopId <= 0 || $studentId <= 0 || $attendanceDate === '') {
        setFlash('error', 'Selecione oficina, aluno e data válidos.');
        redirect('/admin/frequencia.php');
    }

    $userId = (int) ($_SESSION['user']['id'] ?? 0);
    if ($userId <= 0) {
        setFlash('error', 'Sessão inválida.');
        redirect('/admin/frequencia.php');
    }

    try {
        $stmt = $db->prepare(
            'INSERT INTO attendance_records (student_id, workshop_id, attendance_date, status, recorded_by) VALUES (:student_id, :workshop_id, :attendance_date, :status, :recorded_by)'
        );
        $stmt->execute([
            ':student_id' => $studentId,
            ':workshop_id' => $workshopId,
            ':attendance_date' => $attendanceDate,
            ':status' => $status,
            ':recorded_by' => $userId,
        ]);

        setFlash('success', 'Registro de frequência salvo com sucesso.');
        redirect('/admin/frequencia.php');
    } catch (Throwable $exception) {
        if (str_contains($exception->getMessage(), 'uq_attendance_record')) {
            setFlash('error', 'Já existe um registro de frequência para esse aluno, oficina e data.');
        } else {
            error_log('[ATTENDANCE] ' . $exception->getMessage());
            setFlash('error', 'Não foi possível registrar a frequência.');
        }
        redirect('/admin/frequencia.php');
    }
}

$records = $db->query(
    'SELECT ar.id, ar.attendance_date, ar.status, s.full_name, w.name AS workshop_name
     FROM attendance_records ar
     JOIN students s ON s.id = ar.student_id
     JOIN workshops w ON w.id = ar.workshop_id
     ORDER BY ar.attendance_date DESC, w.name ASC'
)->fetchAll() ?: [];

renderHeader('Frequência | Projeto Semente');
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
                <span class="eyebrow">Controle</span>
                <h1>Registro de frequência</h1>
            </div>
        </div>

        <section class="admin-card">
            <h2>Registrar presença</h2>
            <form method="post" action="/admin/frequencia.php">
                <?php echo Csrf::field(); ?>
                <div class="form-grid">
                    <div>
                        <label for="workshop_id">Oficina</label>
                        <select id="workshop_id" name="workshop_id" required>
                            <option value="">Selecione</option>
                            <?php foreach ($workshops as $workshop): ?>
                                <option value="<?php echo e($workshop['id']); ?>"><?php echo e($workshop['name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label for="attendance_date">Data</label>
                        <input id="attendance_date" name="attendance_date" type="date" required>
                    </div>
                    <div>
                        <label for="student_id">Aluno</label>
                        <select id="student_id" name="student_id" required>
                            <option value="">Selecione</option>
                            <?php foreach ($students as $student): ?>
                                <option value="<?php echo e($student['id']); ?>"><?php echo e($student['full_name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label for="status">Situação</label>
                        <select id="status" name="status">
                            <option value="present">Presente</option>
                            <option value="absent">Ausente</option>
                            <option value="late">Atrasado</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn primary">Salvar frequência</button>
            </form>
        </section>

        <section class="admin-card">
            <h2>Registros anteriores</h2>
            <?php if ($records): ?>
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>Data</th>
                                <th>Oficina</th>
                                <th>Aluno</th>
                                <th>Situação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($records as $record): ?>
                                <tr>
                                    <td><?php echo e(date('d/m/Y', strtotime($record['attendance_date']))); ?></td>
                                    <td><?php echo e($record['workshop_name']); ?></td>
                                    <td><?php echo e($record['full_name']); ?></td>
                                    <td><?php echo e($record['status']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="empty-state compact">
                    <p>Nenhum registro de frequência encontrado.</p>
                </div>
            <?php endif; ?>
        </section>
    </main>
</div>
<?php renderFooter(); ?>
