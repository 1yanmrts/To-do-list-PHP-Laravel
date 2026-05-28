# Sistema de Gerenciamento de Tarefas
Um sistema prático e eficiente para o gerenciamento de tarefas do dia a dia. Desenvolvido como projeto de estudo, este sistema aplica conceitos modernos e boas práticas de arquitetura MVC, requisições assíncronas e estruturação de front-end.

---

##  Objetivo do Projeto
O objetivo principal deste projeto é consolidar conhecimentos no ecossistema Laravel, focando na separação de responsabilidades (Controllers, Services, FormRequests), validação inteligente de dados, e na integração de bibliotecas front-end modernas (TailwindCSS, DataTables, SweetAlert2) de forma nativa e otimizada usando o Vite, sem dependência de CDNs externas.

---

##  Funcionalidades
* **CRUD Completo:** Criação, leitura, edição e exclusão de tarefas.
* **Validação Inteligente:** O sistema de back-end valida datas e regras de negócio de forma dinâmica, dependendo se é uma criação ou atualização.
* **Status Dinâmico:** Marcação de tarefas como concluídas ou pendentes via requisições assíncronas (Fetch API/AJAX) sem recarregar a tela.
* **Relatórios Avançados:** Tabela interativa construída com Yajra DataTables 2.0, com suporte nativo a:
  * Paginação e ordenação de colunas.
  * Pesquisa em tempo real.
  * Exportação de dados para Excel, CSV, PDF e Impressão.

* **Feedback Visual:** Alertas customizados e modais de confirmação de exclusão utilizando SweetAlert2.

---

## Tecnologias Utilizadas
* **Back-end:** PHP 8, Laravel, MySQL.
* **Front-end:** Blade Templates, TailwindCSS, JavaScript (Vanilla).
* **Pacotes & Ferramentas:** Vite, Yajra DataTables, SweetAlert2, FontAwesome.
  
---

##  Como Instalar e Rodar o Projeto

### Pré-requisitos

Certifique-se de ter instalado em sua máquina:
* PHP (v8.1 ou superior)
* Composer
* Node.js e NPM
* Um servidor de banco de dados (MySQL/MariaDB)

### Passo a Passo

**1. Clone o repositório:**
```bash
git clone [https://github.com/seu-usuario/seu-repositorio.git](https://github.com/seu-usuario/seu-repositorio.git)
cd seu-repositorio
```

**2. Instale as dependências do PHP:**
```bash
composer install
```

**3. Instale as dependências do Node:**
```bash
npm install
```

**4. Configure o arquivo de ambiente (.env):**
```bash
cp .env.example .env
php artisan key:generate
```

**5. Configure o Banco de Dados:**
Abra o arquivo `.env` criado e preencha as credencias do seu banco de dados local. Por exemplo:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nome_do_seu_banco
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
```

**6. Rode as Migrations:**
Crie as tabelas no banco de dados com o comando:
```bash
php artisan migrate
```

**7. Compile os arquivos do Front-end:**
Gere os arquivos minificados de CSS e JS através do Vite:
```bash
npm run build
```

**8. Inicie o Servidor Local:**
```bash
php artisan serve
```

A aplicação estará disponível no seu navegador no endereço: `http://localhost:8000`.

---
## Melhorias Pretendidas

- Implementar sistema de Autenticação (Login/Registro) para que cada usuário tenha suas próprias tarefas.
- Criar categorias e etiquetas (tags) para as tarefas.
- Adicionar filtros avançados no relatório (ex: filtrar por período de data limite).
