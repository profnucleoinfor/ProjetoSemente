<?php
/**
 * Configuração de exemplo do Projeto Semente.
 * Copie este arquivo para config.php e ajuste os valores conforme o ambiente.
 * Nunca versionar segredos reais junto ao repositório.
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
