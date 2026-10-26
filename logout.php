<?php
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/App/Core/Auth.php';
require_once __DIR__ . '/App/Core/Csrf.php';
require_once __DIR__ . '/App/Core/Validator.php';

use App\Core\Auth;
use App\Core\Csrf;
use App\Core\Validator;

if (Auth::isLoggedIn()) {
    redirect('/admin/index.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    Csrf::requirePost();

    if (!Csrf::validate($_POST['csrf_token'] ?? '')) {
        setFlash('error', 'Token de segurança inválido.');
        redirect('/login.php');
    }

    $email = trim((string) ($_POST['email'] ?? ''));
    $password = (string) ($_POST['password'] ?? '');
    $errors = [];

    if (!Validator::email($email)) {
        $errors[] = 'Informe um e-mail válido.';
    }

    if (!Validator::lengthBetween($password, 8, 255)) {
        $errors[] = 'A senha deve ter no mínimo 8 caracteres.';
    }

    if ($errors) {
        setFlash('error', implode(' ', $errors));
        redirect('/login.php');
    }

    $user = Auth::login($email, $password);
    if ($user) {
        redirect('/admin/index.php');
    }

    setFlash('error', 'Credenciais inválidas ou conta inativa.');
    redirect('/login.php');
}

renderHeader('Login | Projeto Semente');
$flash = getFlash();
if ($flash) {
    echo '<div class="alert ' . e($flash['type']) . '">' . e($flash['message']) . '</div>';
}
?>
<div class="card" style="max-width: 520px; margin: 40px auto;">
    <h1>Login administrativo</h1>
    <p class="muted">Acesso restrito ao painel do Projeto Semente.</p>

    <form method="post" action="/login.php" novalidate>
        <?php echo Csrf::field(); ?>

        <div>
            <label for="email">E-mail</label>
            <input id="email" type="email" name="email" value="" required autocomplete="username">
        </div>

        <div>
            <label for="password">Senha</label>
            <input id="password" type="password" name="password" required autocomplete="current-password">
        </div>

        <button type="submit">Entrar</button>
    </form>

    <p class="muted" style="margin-top: 18px;">
        Primeiro acesso? Use o processo de instalação em <a href="/instalar.php">/instalar.php</a>.
    </p>
</div>
<?php renderFooter();
