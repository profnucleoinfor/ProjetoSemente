<?php
/**
 * Arquivo de configuração local do Projeto Semente.
 * Este arquivo deve ser mantido fora do controle de versão em ambientes reais.
 * Para uso local, copie os valores do config.example.php.
 */

return [
    'app_name' => 'Projeto Semente',
    'app_url' => 'http://localhost/projetosemente',
    'environment' => 'development',
    'display_errors' => true,
    'log_errors' => true,
    'default_timezone' => 'America/Sao_Paulo',

    'database' => [
        'host' => '127.0.0.1',
        'port' => 3306,
        'name' => 'projeto_semente',
        'user' => 'root',
        'password' => '',
        'charset' => 'utf8mb4',
        'options' => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ],
    ],

    'session' => [
        'name' => 'projeto_semente_session',
        'lifetime' => 3600,
        'secure' => false,
        'httponly' => true,
        'samesite' => 'Lax',
        'regen_id' => true,
    ],

    'paths' => [
        'base_dir' => __DIR__ . '/../../',
        'storage_dir' => __DIR__ . '/../../storage/',
        'logs_dir' => __DIR__ . '/../../storage/logs/',
        'exports_dir' => __DIR__ . '/../../storage/exports/',
        'temp_dir' => __DIR__ . '/../../storage/temp/',
    ],
];
