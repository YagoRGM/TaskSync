# 📝 To-Do List: Sistema de Cadastro e Login

Este projeto é uma aplicação web simples de lista de tarefas com sistema de **login e cadastro de usuários**, desenvolvida em **PHP**, **MySQL**, **HTML**, **CSS** e **JavaScript (SweetAlert2)**.

---

### 🎨 Estilo e Design

- **Cores predominantes**:
  - `#007bff` (azul principal)
  - `#0056b3` (azul escuro para hover)
  - `#ffffff` (fundo dos cards e formulários)
  - `#333` e `#555` (tons neutros para texto)

- **Tipografia**:
  - Utiliza a fonte **Poppins**, moderna e legível
  - Aplicada a títulos, formulários e botões

- **Layout**:
  - Visual limpo e responsivo
  - Campos bem espaçados
  - Feedback visual com **SweetAlert2**

---

### ✅ Funcionalidades

- 🧾 **Cadastro de usuário**:
  - Nome, e-mail e senha obrigatórios
  - Verificação de e-mail já existente
  - Senha segura com `password_hash()`

- 🔐 **Login de usuário**:
  - Verifica credenciais com segurança
  - Inicia sessão em caso de sucesso

- 🧠 **Validações inteligentes**:
  - Exibe mensagens amigáveis com SweetAlert2 em caso de erros ou sucesso

- 🗂️ **Base para sistema de tarefas**:
  - Estrutura pronta para associar tarefas aos usuários cadastrados

---

### 🧪 Credenciais de Teste

Você pode usar as credenciais abaixo para testar o login:

- **Email**: `prof@gmail.com`  
- **Senha**: `123456`

> Você também pode criar sua própria conta usando a tela de cadastro.

---

### 🛠️ Tecnologias utilizadas

- **Frontend**: HTML5, CSS3, JavaScript
- **Backend**: PHP 7+
- **Banco de Dados**: MySQL
- **Bibliotecas**: [SweetAlert2](https://sweetalert2.github.io/)

---

### 📁 Estrutura de Pastas

```
📁 projeto/
├── 📂 styles/
│   └── login-cadastro.css
├── 📂 img/
│   └── logo_1.png
├── 📄 conexao.php
├── 📄 login.php
├── 📄 cadastro.php
├── 📄 home.php (em desenvolvimento)
```

---

### 🚀 Como usar

1. Clone o repositório ou extraia o .zip.
2. Crie um banco de dados MySQL e a tabela `usuarios` com os seguintes campos:
   - `id_usuario` (int, auto_increment, primary key)
   - `nome_usuario` (varchar)
   - `email_usuario` (varchar)
   - `senha_usuario` (varchar)
3. Atualize o arquivo `conexao.php` com suas credenciais do banco.
4. Execute o projeto em um servidor local como XAMPP ou WAMP.
5. Acesse `cadastro.php` para registrar um novo usuário ou use as credenciais de teste para logar via `login.php`.

---

### 📌 Futuras Funcionalidades

- [ ] Criar tarefas
- [ ] Marcar como concluída
- [ ] Editar e remover tarefas
- [ ] Filtrar tarefas por status ou data

---

### 🧑‍💻 Autor

Desenvolvido com 💙 por Yago Moraes  
Contato: [yago.roberto2008@gmail.com]