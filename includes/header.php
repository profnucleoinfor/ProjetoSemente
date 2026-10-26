<?php
function renderHeader(string $title = 'Projeto Semente'): void
{
    $currentUser = $_SESSION['user'] ?? null;
    ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($title); ?></title>
    <style>
        :root {
            --verde: #05401F;
            --verde-claro: #1a6b43;
            --cinza: #f4f5f7;
            --texto: #1d1d1f;
            --erro: #7a1f1f;
            --sucesso: #1f5f3b;
            --borda: #dfe3e8;
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: #f8faf9;
            color: var(--texto);
        }
        a { color: var(--verde); text-decoration: none; }
        .container { max-width: 1100px; margin: 0 auto; padding: 24px 20px; }
        .topbar {
            background: var(--verde);
            color: #fff;
            padding: 14px 0;
        }
        .topbar .wrap {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            flex-wrap: wrap;
        }
        .nav {
            display: flex;
            gap: 18px;
            flex-wrap: wrap;
            align-items: center;
        }
        .nav a, .nav button {
            color: #fff;
            border: none;
            background: transparent;
            cursor: pointer;
            font-size: 0.95rem;
        }
        .card {
            background: #fff;
            border: 1px solid var(--borda);
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 2px 10px rgba(5,64,31,.05);
        }
        .alert {
            padding: 14px 16px;
            border-radius: 8px;
            margin-bottom: 18px;
            border: 1px solid transparent;
        }
        .alert.error {
            background: #fff0f0;
            border-color: #e9b7b7;
            color: var(--erro);
        }
        .alert.success {
            background: #eefaf2;
            border-color: #b5dab9;
            color: var(--sucesso);
        }
        form { display: grid; gap: 12px; }
        label { font-weight: 600; display: block; margin-bottom: 6px; }
        input, select, textarea, button {
            width: 100%;
            padding: 12px 14px;
            border-radius: 8px;
            border: 1px solid var(--borda);
            font-size: 1rem;
        }
        button {
            background: var(--verde);
            color: #fff;
            border: none;
            font-weight: 700;
            cursor: pointer;
        }
        .row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 18px;
        }
        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 16px;
        }
        .stat {
            padding: 20px;
            background: #fff;
            border: 1px solid var(--borda);
            border-radius: 10px;
        }
        .muted { color: #4d4d4d; }
        @media (max-width: 700px) {
            .topbar .wrap { flex-direction: column; align-items: flex-start; }
        }
    </style>
</head>
<body>
    <header class="topbar">
        <div class="container wrap">
            <strong>Projeto Semente</strong>
            <nav class="nav" aria-label="Navegação principal">
                <a href="/index.php">Início</a>
                <?php if ($currentUser): ?>
                    <a href="/admin/index.php">Painel</a>
                    <a href="/logout.php">Sair</a>
                <?php else: ?>
                    <a href="/login.php">Login</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>
    <main class="container">
<?php
}

function renderFooter(): void
{
    ?>
    </main>
</body>
</html>
<?php
}
