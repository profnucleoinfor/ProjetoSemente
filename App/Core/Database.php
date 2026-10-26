<?php
namespace App\Core;

use PDO;
use PDOException;

final class Database
{
    private static ?PDO $connection = null;

    public static function getConnection(): PDO
    {
        if (self::$connection instanceof PDO) {
            return self::$connection;
        }

        $configFile = __DIR__ . '/../Config/config.php';

        if (!is_file($configFile)) {
            throw new \RuntimeException('Arquivo de configuração do banco não encontrado: ' . $configFile);
        }

        $config = require $configFile;
        $dbConfig = $config['database'] ?? null;

        if (!is_array($dbConfig)) {
            throw new \RuntimeException('Configuração do banco de dados ausente ou inválida.');
        }

        $dsn = sprintf(
            'mysql:host=%s;port=%d;dbname=%s;charset=%s',
            $dbConfig['host'],
            (int) ($dbConfig['port'] ?? 3306),
            $dbConfig['name'],
            $dbConfig['charset'] ?? 'utf8mb4'
        );

        try {
            self::$connection = new PDO(
                $dsn,
                $dbConfig['user'] ?? '',
                $dbConfig['password'] ?? '',
                $dbConfig['options'] ?? []
            );
        } catch (PDOException $exception) {
            error_log('[DATABASE] Falha ao conectar: ' . $exception->getMessage());
            throw new \RuntimeException('Não foi possível conectar ao banco de dados. Verifique as credenciais e o status do MySQL.', 0, $exception);
        }

        return self::$connection;
    }

    public static function testConnection(): bool
    {
        try {
            self::getConnection()->query('SELECT 1');
            return true;
        } catch (\Throwable $exception) {
            error_log('[DATABASE] Teste de conexão falhou: ' . $exception->getMessage());
            return false;
        }
    }
}
