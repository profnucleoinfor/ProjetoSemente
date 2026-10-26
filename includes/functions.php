<?php
require_once __DIR__ . '/../App/Core/Database.php';
require_once __DIR__ . '/../App/Core/Auth.php';
require_once __DIR__ . '/../App/Core/Csrf.php';
require_once __DIR__ . '/../App/Core/Validator.php';

if (session_status() === PHP_SESSION_NONE) {
    $config = require __DIR__ . '/../App/Config/config.php';
    $sessionConfig = $config['session'] ?? [];

    session_name($sessionConfig['name'] ?? 'projeto_semente_session');
    session_set_cookie_params([
        'lifetime' => (int) ($sessionConfig['lifetime'] ?? 3600),
        'path' => '/',
        'secure' => (bool) ($sessionConfig['secure'] ?? false),
        'httponly' => (bool) ($sessionConfig['httponly'] ?? true),
        'samesite' => $sessionConfig['samesite'] ?? 'Lax',
    ]);

    session_start();
}

date_default_timezone_set('America/Sao_Paulo');

function config(string $key, mixed $default = null): mixed
{
    static $config = null;

    if ($config === null) {
        $configPath = __DIR__ . '/../App/Config/config.php';
        if (!is_file($configPath)) {
            return $default;
        }

        $config = require $configPath;
    }

    return $config[$key] ?? $default;
}

function e(mixed $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function setFlash(string $type, string $message): void
{
    $_SESSION['flash'] = [
        'type' => $type,
        'message' => $message,
    ];
}

function getFlash(): ?array
{
    $flash = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']);
    return $flash;
}

function redirect(string $location): void
{
    header('Location: ' . $location, true, 302);
    exit;
}

function currentUser(): ?array
{
    return $_SESSION['user'] ?? null;
}

function requireLogin(): void
{
    \App\Core\Auth::requireLogin();
}

function requireRole(array $roles): void
{
    \App\Core\Auth::requireRole($roles);
}
