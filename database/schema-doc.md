# Documentação do esquema do banco de dados

## Banco

- Nome padrão: `projeto_semente`
- Charset: `utf8mb4`
- Collation: `utf8mb4_unicode_ci`
- Engine: `InnoDB`

## Tabelas

### users

- `id`: identificador principal
- `name`: nome completo do usuário
- `email`: e-mail único para login
- `password_hash`: hash gerado por `password_hash()`
- `profile`: perfil do usuário (`admin` ou `professor`)
- `status`: estado da conta (`active`, `inactive`)
- `created_at`: data de criação
- `updated_at`: data da última atualização

Principais restrições:
- `email` obrigatório e único
- `profile` limitado aos perfis previstos
- índice em `email` e `profile`

### students

- `id`: identificador principal
- `full_name`: nome completo do aluno
- `birth_date`: data de nascimento (opcional)
- `phone`: telefone principal
- `email`: e-mail de contato (opcional)
- `guardian_name`: nome do responsável (quando aplicável)
- `guardian_contact`: contato do responsável
- `status`: estado do cadastro (`active` ou `inactive`)
- `created_at`: data de criação
- `updated_at`: data da última atualização

### workshops

- `id`: identificador principal
- `name`: nome da oficina
- `description`: descrição da oficina
- `status`: estado (`active`, `inactive`)
- `created_at`: criação
- `updated_at`: atualização

### attendance_records

- `id`: identificador principal
- `student_id`: referência para `students.id`
- `workshop_id`: referência para `workshops.id`
- `attendance_date`: data do registro
- `status`: presença (`present`, `absent`, `late`)
- `recorded_by`: usuário responsável pela marcação
- `created_at`: data de criação

Restrições:
- `UNIQUE(student_id, workshop_id, attendance_date)` para evitar duplicidade
- chaves estrangeiras com `ON UPDATE CASCADE` e `ON DELETE RESTRICT`

### contact_messages

- `id`: identificador principal
- `sender_name`: nome do remetente
- `sender_email`: e-mail de contato
- `subject`: assunto
- `message`: mensagem enviada
- `status`: status do contato (`new`, `in_progress`, `resolved`)
- `received_at`: data do recebimento

### site_content

- `id`: identificador principal
- `content_key`: chave do conteúdo
- `content_value`: valor do conteúdo
- `content_type`: tipo do conteúdo (`text`, `html`, `json`, `boolean`)
- `updated_at`: data de atualização

Restrições:
- `content_key` único para evitar chaves duplicadas

## Relacionamentos

- `attendance_records.student_id` -> `students.id`
- `attendance_records.workshop_id` -> `workshops.id`
- `attendance_records.recorded_by` -> `users.id`

## Índices principais

- `users(email, profile)`
- `students(status, full_name)`
- `workshops(status, name)`
- `attendance_records(attendance_date, status)`
- `contact_messages(status, received_at)`

## Observações

- Toda a estrutura está em UTF-8 com `utf8mb4`.
- Dados sensíveis devem permanecer fora da documentação versionada.
- A criação inicial do primeiro administrador deve ser feita por um processo controlado e protegido, não por uma conta padrão.
