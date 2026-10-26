<?php
require_once __DIR__ . '/functions.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || !\App\Core\Csrf::validate((string) $_POST['csrf_token'])) {
        $_SESSION['flash'] = ['type' => 'error', 'message' => 'Token CSRF inválido.'];
        header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? '/login.php'));
        exit;
    }
}
