<?php
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/App/Core/Auth.php';

use App\Core\Auth;

Auth::logout();
setFlash('success', 'Sessão encerrada com sucesso.');
redirect('/login.php');
