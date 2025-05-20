<?php
session_start();
include 'conexao.php';

$mensagem = '';
$tipo = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome_cadastro = trim($_POST['nome_cadastrar']);
    $email_cadastro = trim($_POST['email_cadastrar']);
    $senha_cadastro = trim($_POST['senha_cadastrar']);

    // Verifica se já existe o e-mail cadastrado
    $sql_check = "SELECT id_usuario FROM usuarios WHERE email_usuario = ?";
    $stmt_check = $conexao->prepare($sql_check);
    $stmt_check->bind_param('s', $email_cadastro);
    $stmt_check->execute();
    $stmt_check->store_result();

    if ($stmt_check->num_rows > 0) {
        $mensagem = 'E-mail já cadastrado!';
        $tipo = 'erro';
    } elseif (empty($nome_cadastro) || empty($email_cadastro) || empty($senha_cadastro)) {
        $mensagem = 'Preencha todos os campos!';
        $tipo = 'erro';
    } else {
        $senha_criptografada = password_hash($senha_cadastro, PASSWORD_DEFAULT);
        $sql1 = "INSERT INTO usuarios(nome_usuario, email_usuario, senha_usuario) VALUES (?, ?, ?)";
        $stmt1 = $conexao->prepare($sql1);
        $stmt1->bind_param('sss', $nome_cadastro, $email_cadastro, $senha_criptografada);
        if ($stmt1->execute()) {
            $mensagem = 'Usuário cadastrado com sucesso!';
            $tipo = 'sucesso';
        } else {
            $mensagem = 'Erro ao cadastrar usuário!';
            $tipo = 'erro';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/login-cadastro.css">
    <title>Cadastrar</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <main id="main-cadastrar">
        <div class="container">
            <form action="" method="post" id="cadastrar">
                <span><a id="cadastrar-voltar" href="login.php">Voltar</a></span>
                <img src="../img/logo_1.png" alt="" id="logo">
                <h1>Cadastrar-se</h1>
                <div class="input-group">
                    <div>
                        <label for="nome_cadastrar">Nome</label>
                        <input type="text" id="nome_cadastrar" name="nome_cadastrar" required placeholder="Digite seu Nome">
                    </div>
                    <div>
                        <label for="email_cadastrar">Email</label>
                        <input type="email" id="email_cadastrar" name="email_cadastrar" required placeholder="Digite seu email">
                    </div>
                </div>
                <div class="input-group">
                    <div>
                        <label for="senha_cadastrar">Senha</label>
                        <input type="password" id="senha_cadastrar" name="senha_cadastrar" required placeholder="Digite sua Senha">
                    </div>
                </div>
                <button id="entrar-cadastrar" type="submit">Entrar</button>
                <p>Ja tem uma conta?<a id="cadastrar-login" href="login.php">Entrar</a></p>
            </form>
        </div>
    </main>
    <?php if ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
        <script>
            <?php if ($tipo === 'sucesso'): ?>
                Swal.fire({
                    icon: 'success',
                    title: '<?= $mensagem ?>',
                    text: 'Você será redirecionado para a página de login.',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.href = "login.php";
                });
            <?php else: ?>
                Swal.fire({
                    icon: 'error',
                    title: 'Informações inválidas!',
                    text: '<?= $mensagem ?>',
                    confirmButtonText: 'OK'
                });
            <?php endif; ?>
        </script>
    <?php endif; ?>
</body>
</html>