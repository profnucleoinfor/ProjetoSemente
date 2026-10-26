<?php
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/App/Core/Auth.php';
require_once __DIR__ . '/App/Core/Database.php';
require_once __DIR__ . '/App/Core/Csrf.php';
require_once __DIR__ . '/App/Core/Validator.php';

use App\Core\Auth;
use App\Core\Csrf;
use App\Core\Database;
use App\Core\Validator;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    Csrf::requirePost();

    if (!Csrf::validate($_POST['csrf_token'] ?? '')) {
        setFlash('error', 'Token CSRF inválido.');
        redirect('/instalar.php');
    }

    $db = Database::getConnection();
    $adminCount = (int) $db->query('SELECT COUNT(*) FROM users')->fetchColumn();

    if ($adminCount > 0) {
        setFlash('error', 'O sistema já possui usuários cadastrados. O procedimento de instalação não pode ser reutilizado.');
        redirect('/login.php');
    }

    $name = trim((string) ($_POST['name'] ?? ''));
    $email = strtolower(trim((string) ($_POST['email'] ?? '')));
    $password = (string) ($_POST['password'] ?? '');
    $confirm = (string) ($_POST['password_confirm'] ?? '');

    $errors = [];

    if (!Validator::required($name)) {
        $errors[] = 'Informe o nome do administrador.';
    }

    if (!Validator::email($email)) {
        $errors[] = 'Informe um e-mail válido.';
    }

    if (!Validator::lengthBetween($password, 8, 255)) {
        $errors[] = 'A senha deve ter pelo menos 8 caracteres.';
    }

    if ($password !== $confirm) {
        $errors[] = 'As senhas informadas não conferem.';
    }

    if ($errors) {
        setFlash('error', implode(' ', $errors));
        redirect('/instalar.php');
    }

    $stmt = $db->prepare('INSERT INTO users (name, email, password_hash, profile, status) VALUES (:name, :email, :password_hash, :profile, :status)');
    $stmt->execute([
        ':name' => $name,
        ':email' => $email,
        ':password_hash' => password_hash($password, PASSWORD_DEFAULT),
        ':profile' => 'admin',
        ':status' => 'active',
    ]);

    setFlash('success', 'Primeiro administrador criado com sucesso.');
    redirect('/login.php');
}

renderHeader('Instalação | Projeto Semente');
$flash = getFlash();
if ($flash) {
    echo '<div class="alert ' . e($flash['type']) . '">' . e($flash['message']) . '</div>';
}
?>
<div class="card" style="max-width: 620px; margin: 40px auto;">
    <h1>Procedimento seguro de instalação</h1>
    <p class="muted">
        Este formulário deve ser usado somente em ambiente protegido e em rede local ou em produção após validação do servidor.
        O primeiro administrador é criado apenas quando ainda não existe nenhum usuário cadastrado.
    </p>

    <form method="post" action="/instalar.php" novalidate>
        <?php echo 
        App\Core\Csrf::field(); ?>

        <div>
            <label for="name">Nome completo</label>
            <input id="name" type="text" name="name" required>
        </div>

        <div>
            <label for="email">E-mail</label>
            <input id="email" type="email" name="email" required>
        </div>

        <div>
            <label for="password">Senha</label>
            <input id="password" type="password" name="password" required>
        </div>

        <div>
            <label for="password_confirm">Confirmar senha</label>
            <input id="password_confirm" type="password" name="password_confirm" required>
        </div>

        <button type="submit">Criar primeiro administrador</button>
    </form>
</div>
<?php renderFooter();
