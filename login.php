<?php
require_once __DIR__ . '/App/Core/Database.php';
require_once __DIR__ . '/App/Core/Auth.php';
require_once __DIR__ . '/App/Core/Csrf.php';
require_once __DIR__ . '/App/Core/Validator.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

use App\Core\Auth;
use App\Core\Csrf;
use App\Core\Validator;

if (Auth::isLoggedIn()) {
    header('Location: /admin/index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    Csrf::requirePost();

    if (!Csrf::validate($_POST['csrf_token'] ?? '')) {
        $_SESSION['flash'] = ['type' => 'error', 'message' => 'Token CSRF inválido.'];
        header('Location: /login.php');
        exit;
    }

    $email = strtolower(trim((string) ($_POST['email'] ?? '')));
    $password = (string) ($_POST['password'] ?? '');
    $errors = [];

    if (!Validator::email($email)) {
        $errors[] = 'Informe um e-mail válido.';
    }
    if (!Validator::lengthBetween($password, 8, 255)) {
        $errors[] = 'A senha deve ter no mínimo 8 caracteres.';
    }

    if ($errors) {
        $_SESSION['flash'] = ['type' => 'error', 'message' => implode(' ', $errors)];
        header('Location: /login.php');
        exit;
    }

    $user = Auth::login($email, $password);
    if ($user) {
        header('Location: /admin/index.php');
        exit;
    }

    $_SESSION['flash'] = ['type' => 'error', 'message' => 'Credenciais inválidas ou conta inativa.'];
    header('Location: /login.php');
    exit;
}

header('Location: /index.php');
exit;
