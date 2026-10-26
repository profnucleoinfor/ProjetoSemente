<?php
namespace App\Core;

use RuntimeException;

final class Auth
{
    public static function isLoggedIn(): bool
    {
        return !empty($_SESSION['user']['id']);
    }

    public static function currentUser(): ?array
    {
        return $_SESSION['user'] ?? null;
    }

    public static function login(string $email, string $password): ?array
    {
        $email = strtolower(trim($email));

        if (!Validator::email($email)) {
            return null;
        }

        $db = Database::getConnection();
        $stmt = $db->prepare('SELECT * FROM users WHERE email = :email AND status = :status LIMIT 1');
        $stmt->execute([
            ':email' => $email,
            ':status' => 'active',
        ]);

        $user = $stmt->fetch();

        if (!$user || !password_verify($password, $user['password_hash'] ?? '')) {
            return null;
        }

        session_regenerate_id(true);

        $_SESSION['user'] = [
            'id' => (int) $user['id'],
            'name' => (string) $user['name'],
            'email' => (string) $user['email'],
            'profile' => (string) $user['profile'],
        ];

        return $_SESSION['user'];
    }

    public static function logout(): void
    {
        $_SESSION = [];

        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );
        }

        session_destroy();
    }

    public static function requireLogin(): void
    {
        if (!self::isLoggedIn()) {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Você precisa estar autenticado para acessar esta área.'];
            header('Location: /login.php');
            exit;
        }
    }

    public static function requireRole(array $allowedRoles): void
    {
        self::requireLogin();

        $profile = $_SESSION['user']['profile'] ?? null;

        if (!in_array($profile, $allowedRoles, true)) {
            http_response_code(403);
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Você não tem permissão para acessar esta operação.'];
            header('Location: /admin/index.php');
            exit;
        }
    }
}
