# Projeto Semente

## Fase 2 – Estrutura e banco de dados

Esta etapa cria a base técnica da aplicação antes da implementação das telas e do painel administrativo.

### Estrutura inicial criada

- `App/Config/config.example.php`: modelo de configuração para ambientes locais e produção.
- `App/Config/config.php`: configuração local do ambiente atual.
- `App/Core/Database.php`: conexão PDO com tratamento de erros e validação rápida.
- `database/schema.sql`: criação do banco e das tabelas do sistema.
- `database/schema-doc.md`: documentação do esquema e relacionamentos.
- `.gitignore`: exclusão de arquivos sensíveis e temporários.
- `.htaccess`: bloqueio básico de acesso direto a diretórios sensíveis.

### Como executar localmente

1. Instale o XAMPP e inicie Apache e MySQL.
2. Acesse o phpMyAdmin ou o cliente MySQL.
3. Crie o banco `projeto_semente`.
4. Importe o arquivo `database/schema.sql`.
5. Ajuste o arquivo `App/Config/config.php` com as credenciais do ambiente local.
6. Verifique a conexão usando a classe `App\Core\Database`.

### Configuração do arquivo de ambiente

O projeto usa um arquivo de configuração separado para evitar segredos no repositório.

Modelo:

```php
<?php
return [
    'database' => [
        'host' => '127.0.0.1',
        'port' => 3306,
        'name' => 'projeto_semente',
        'user' => 'root',
        'password' => '',
        'charset' => 'utf8mb4',
    ],
];
```

### Considerações de segurança

- `config.php` deve permanecer fora do controle de versão em produção.
- O diretório `storage/` e arquivos sensíveis devem ser protegidos por `.htaccess` ou pela estrutura fora da raiz pública.
- O uso de `PDO` e prepared statements será obrigatório nas operações subsequentes.

### Limitações conhecidas

- Esta fase cria a base técnica e a estrutura do banco, mas não executa a autenticação nem as telas do sistema.
- A validação funcional completa depende do ambiente de execução com PHP e MySQL disponíveis.

### Critério da fase

Concluído para a estrutura inicial: banco importável, arquivo de configuração e conexão PDO preparados para a próxima fase de segurança e autenticação.
