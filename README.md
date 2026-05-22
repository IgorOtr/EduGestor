# EduGestor

Sistema de gestão de recursos escolares municipais, desenvolvido em Laravel 13.

---

## 📋 Requisitos

Antes de começar, certifique-se de ter instalado em sua máquina:

| Ferramenta | Versão mínima |
|-----------|---------------|
| PHP | 8.3+ |
| Composer | 2.x |
| Node.js | 18+ |
| MySQL | 8.0+ |
| Git | qualquer |

---

## 🚀 Instalação

### 1. Clone o repositório

```bash
git clone https://github.com/IgorOtr/EduGestor.git
cd EduGestor
```

### 2. Instale as dependências PHP

```bash
composer install
```

### 3. Instale as dependências Node

```bash
npm install
```

### 4. Configure o ambiente

Copie o arquivo de exemplo e ajuste as variáveis:

```bash
cp .env.example .env
```

Abra o `.env` e preencha as configurações do banco de dados:

```env
APP_NAME=EduGestor
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=edugestor
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
```

### 5. Gere a chave da aplicação

```bash
php artisan key:generate
```

### 6. Crie o banco de dados

No seu cliente MySQL (MySQL Workbench, TablePlus, linha de comando, etc.), crie o banco:

```sql
CREATE DATABASE edugestor CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 7. Execute as migrations e seeders

```bash
php artisan migrate:fresh --seed
```

Isso criará todas as tabelas e populará com dados iniciais (usuários, escolas, categorias e produtos de exemplo).

### 8. Crie o link simbólico de storage

```bash
php artisan storage:link
```

### 9. Compile os assets

```bash
npm run build
```

---

## ▶️ Iniciando o servidor

```bash
php artisan serve
```

Acesse em: [http://localhost:8000](http://localhost:8000)

---

## 👤 Usuários de acesso (gerados pelo seeder)

| Papel | E-mail | Senha |
|-------|--------|-------|
| Root | root@edugestor.com | password |
| Secretário | secretario@edugestor.com | password |
| Diretor (Escola A) | ana.lima@edugestor.com | password |
| Diretor (Escola B) | carlos.souza@edugestor.com | password |
| Diretor (Escola C) | maria.costa@edugestor.com | password |

> **Atenção:** Altere as senhas após o primeiro acesso em produção.

---

## 🏗️ Estrutura de papéis (Roles)

| Role | Permissões |
|------|-----------|
| **Root** | Acesso total ao sistema — gerencia usuários, escolas, categorias, produtos, pedidos e solicitações |
| **Secretário** | Gerencia escolas, produtos, categorias e aprova/recusa pedidos e solicitações de alteração |
| **Diretor** | Visualiza apenas sua escola, cria pedidos e solicita alterações de dados da escola |

---

## 🛠️ Tecnologias utilizadas

- **Backend:** Laravel 13, PHP 8.4
- **Frontend:** Blade, Tailwind CSS 4 (via Vite), Alpine.js
- **Banco de dados:** MySQL 8
- **Padrões:** Repository Pattern, Service Layer, DTO, Policies, FormRequests

---

## ⚙️ Comandos úteis durante o desenvolvimento

```bash
# Recriar banco com dados frescos
php artisan migrate:fresh --seed

# Limpar caches
php artisan optimize:clear

# Compilar assets em modo watch (desenvolvimento)
npm run dev

# Gerar build de produção
npm run build

# Rodar testes
php artisan test
```

---

## 📁 Organização do projeto

```
app/
├── DTOs/               # Data Transfer Objects
├── Enums/              # Enumerações (roles, status)
├── Http/
│   ├── Controllers/    # Controllers RESTful
│   ├── Middleware/     # Middlewares de autenticação e role
│   └── Requests/       # FormRequests com validação
├── Models/             # Eloquent Models
├── Policies/           # Autorização por recurso
├── Repositories/       # Camada de acesso a dados
├── Services/           # Lógica de negócio
└── Traits/             # HasAudit (rastreio de criação)
resources/
├── css/app.css         # Tailwind CSS 4
├── js/app.js           # Entry point JS
└── views/              # Blade templates
```

---

## 📄 Licença

Este projeto é de uso interno da prefeitura municipal.
