<?php
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../App/Core/Database.php';

use App\Core\Database;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

requireLogin();
requireRole(['admin', 'professor']);

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    exit('Método não permitido.');
}

$db = Database::getConnection();
$workshopId = isset($_GET['workshop_id']) ? (int) $_GET['workshop_id'] : 0;
$startDate = trim((string) ($_GET['start_date'] ?? ''));
$endDate = trim((string) ($_GET['end_date'] ?? ''));

$conditions = [];
$params = [];

if ($workshopId > 0) {
    $conditions[] = 'ar.workshop_id = :workshop_id';
    $params[':workshop_id'] = $workshopId;
}

if ($startDate !== '') {
    $conditions[] = 'ar.attendance_date >= :start_date';
    $params[':start_date'] = $startDate;
}

if ($endDate !== '') {
    $conditions[] = 'ar.attendance_date <= :end_date';
    $params[':end_date'] = $endDate;
}

$query = 'SELECT ar.attendance_date, w.name AS workshop_name, s.full_name AS student_name, ar.status
          FROM attendance_records ar
          JOIN workshops w ON w.id = ar.workshop_id
          JOIN students s ON s.id = ar.student_id';

if ($conditions) {
    $query .= ' WHERE ' . implode(' AND ', $conditions);
}

$query .= ' ORDER BY ar.attendance_date DESC, w.name ASC, s.full_name ASC';
$stmt = $db->prepare($query);
$stmt->execute($params);
$rows = $stmt->fetchAll() ?: [];

$filename = 'frequencia-projeto-semente.csv';
header('Content-Type: text/csv; charset=UTF-8');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Pragma: no-cache');
header('Expires: 0');

$output = fopen('php://output', 'w');
$header = ['data', 'oficina', 'aluno', 'situacao'];

fputcsv($output, $header, ';', '"');

foreach ($rows as $row) {
    $data = [
        $row['attendance_date'],
        $row['workshop_name'],
        $row['student_name'],
        $row['status'],
    ];

    foreach ($data as $index => $value) {
        $data[$index] = preg_replace('/^([=+\-@\t\r\n])/i', "'\\1", (string) $value);
    }

    fputcsv($output, $data, ';', '"');
}

fclose($output);
exit;
