# Projeto Semente

## Visão geral

Aplicação web institucional em PHP 8 com renderização no servidor, banco MySQL e estrutura simples, segura e compatível com XAMPP e HostGator cPanel.

## Estrutura de diretórios

```text
projeto-semente/
├── App/
│   ├── Config/
│   │   ├── config.example.php
│   │   └── config.php
│   ├── Core/
│   │   ├── Auth.php
│   │   ├── Csrf.php
│   │   ├── Database.php
│   │   └── Validator.php
├── admin/
│   ├── index.php
│   ├── menu.php
│   ├── alunos.php
│   ├── oficinas.php
│   ├── frequencia.php
│   ├── relatorios.php
│   ├── exportar-frequencia.php
│   ├── conteudo.php
│   ├── mensagens.php
│   └── usuarios.php
├── assets/
│   ├── css/
│   ├── js/
│   └── img/
├── database/
│   ├── schema.sql
│   ├── schema-doc.md
│   └── seed_admin.sql
├── includes/
│   ├── functions.php
│   ├── header.php
│   └── footer.php
├── .gitignore
├── .htaccess
├── contato.php
├── galeria.php
├── index.php
├── instalar.php
├── login.php
├── logout.php
├── oficinas.php
├── parceiros.php
├── quem-somos.php
├── README.md
├── LICENSE
└── index.html
```

## Requisitos de ambiente

- PHP 8.2+
- Apache + MySQL/MariaDB via XAMPP
- PDO habilitado
- `mbstring`, `openssl` e `session`
- acesso ao diretório público do site

## Configuração local

1. Inicie Apache e MySQL no XAMPP.
2. Crie o banco `projeto_semente`.
3. Importe o arquivo `database/schema.sql`.
4. Copie `App/Config/config.example.php` para `App/Config/config.php`.
5. Ajuste credenciais locais.
6. Acesse `http://localhost/projetosemente/login.php`.
7. Crie o primeiro administrador via `instalar.php`.

## Primeiro administrador

O processo de criação do primeiro usuário administrador é controlado e bloqueado quando já existe algum usuário cadastrado.

## Segurança

- uso de PDO com prepared statements
- sessões com cookie HttpOnly e SameSite
- validação CSRF em formulários com alterações
- `password_hash()` e `password_verify()`
- controle de acesso por perfil
- diretórios sensíveis protegidos por `.htaccess`
- exportação CSV com proteção contra `=`, `+`, `-`, `@` e caracteres de controle

## Permissões por perfil

- `admin`: acesso total ao painel e à gestão de usuários
- `professor`: acesso ao painel, alunos, oficinas, frequência e relatórios

## Testes executados

- verificação de estrutura de arquivos
- conferência da integração dos módulos principais
- análise dos fluxos de autenticação e proteção de dados
- revisão de formulários e exportação CSV

## Limitações conhecidas

- não foi possível executar testes de runtime em PHP/MySQL neste ambiente, pois o serviço não está disponível para validação direta
- imagens institucionais e conteúdo real precisam ser adicionados pela equipe quando disponibilizados
- o processo de implantação em produção depende da configuração real do cPanel e do domínio

## Backup e restauração

1. Faça dump do banco com `mysqldump`.
2. Faça cópia dos arquivos do projeto.
3. Archive `App/Config/config.php` e `storage/` com cuidado.
4. Restaure em ambiente adequado e revalidar credenciais.

## Implantação em HostGator cPanel

1. Verifique versão do PHP e extensões.
2. Crie banco e usuário MySQL.
3. Importe `database/schema.sql`.
4. Ajuste `App/Config/config.php` para produção.
5. Publicar os arquivos no diretório público.
6. Configurar HTTPS e proteger diretórios sensíveis.
7. Criar primeiro administrador via `instalar.php`.
8. Remover/ocultar instaladores e arquivos temporários.

## Observações finais

O projeto implementa a base funcional exigida para a entrega institucional, com foco em segurança, manutenção e compatibilidade com XAMPP e cPanel.
