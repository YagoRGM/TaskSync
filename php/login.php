<?php
session_start();
include 'conexao.php';

$login_status = ''; // nova variável

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email_digitado = $_POST['email_login'];
    $senha_digitado = $_POST['senha_login'];

    $sql = "SELECT * FROM usuarios WHERE email_usuario = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("s", $email_digitado);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $usuario_logado = $result->fetch_assoc();
        if (password_verify($senha_digitado, $usuario_logado['senha_usuario'])) {
            $_SESSION['id_sessao'] = $usuario_logado['id_usuario'];
            $_SESSION['nome_sessao'] = $usuario_logado['nome_usuario'];
            $_SESSION['email_sessao'] = $usuario_logado['email_usuario'];
            $login_status = 'sucesso';
        } else {
            $login_status = 'erro';
        }
    } else {
        $login_status = 'erro';
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/login-cadastro.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Login</title>
</head>

<body>
    <main>
        <div class="container">
            <form action="" method="POST" id="login">
                <img src="../img/logo_1.png" alt="" id="logo">
                <h1>Entrar</h1>

                <label for="email">Email</label>
                <input type="email" id="email_login" name="email_login" required placeholder="Digite seu email">

                <label for="senha">Senha</label>
                <input type="password" id="senha_login" name="senha_login" required placeholder="Digite sua Senha">

                <p>Nao tem uma conta?<a id="cadastrar-login" href="cadastroUsuario.php">Cadastrar-se</a></p>

                <button id="entrar-login" type="submit">Entrar</button>
            </form>
        </div>
    </main>
    <?php if ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
        <script>
            <?php if ($login_status === 'sucesso'): ?>
                Swal.fire({
                    icon: 'success',
                    title: 'Sucesso!',
                    text: 'Login realizado com sucesso.',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.href = "index.php";
                });
            <?php elseif ($login_status === 'erro'): ?>
                Swal.fire({
                    icon: 'error',
                    title: 'Informações inválidas!',
                    text: 'Email ou senha incorretos.',
                    confirmButtonText: 'OK'
                });
            <?php endif; ?>
        </script>
    <?php endif; ?>
</body>
</html>