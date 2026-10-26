<?php
$path = $_SERVER['REQUEST_URI'] ?? '';
$menu = [
    ['label' => 'Resumo', 'href' => '/admin/index.php'],
    ['label' => 'Alunos', 'href' => '/admin/alunos.php'],
    ['label' => 'Oficinas', 'href' => '/admin/oficinas.php'],
    ['label' => 'Frequência', 'href' => '/admin/frequencia.php'],
    ['label' => 'Conteúdo', 'href' => '/admin/conteudo.php'],
    ['label' => 'Mensagens', 'href' => '/admin/mensagens.php'],
    ['label' => 'Usuários', 'href' => '/admin/usuarios.php'],
];
?>
<aside class="admin-sidebar">
    <div class="brand-box">
        <strong>Projeto Semente</strong>
        <small>Administração</small>
    </div>
    <nav class="admin-nav" aria-label="Menu administrativo">
        <?php foreach ($menu as $item): ?>
            <a href="<?php echo e($item['href']); ?>" class="<?php echo str_contains($path, basename($item['href'])) ? 'active' : ''; ?>">
                <?php echo e($item['label']); ?>
            </a>
        <?php endforeach; ?>
    </nav>
    <a class="logout-link" href="/logout.php">Sair do sistema</a>
</aside>
