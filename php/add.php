<?php
include 'conexao.php';
session_start();
if (!isset($_SESSION['id_sessao'])) {
    header('location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $setor = $_POST['setor'];
    $prioridade = $_POST['prioridade'];
    $status = 'fazer';
    $data = date('Y-m-d H:i:s');

    $sql = "INSERT INTO tarefas(titulo_tarefa, descricao_tarefa, status_tarefa, prioridade, data_tarefa, setor, fk_id_usuario) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param('sssssss', $titulo, $descricao, $status, $prioridade, $data, $setor, $_SESSION['id_sessao']);
    $stmt->execute();
}

$sql = "SELECT * FROM tarefas";
$result = $conexao->query($sql);


?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Nova Tarefa</title>
    <link rel="stylesheet" href="../styles/add.css">
</head>

<body>
    <form method="post">
        <h1>Adicionar Nova Tarefa</h1>
        <label for="task">Titulo</label>
        <input type="text" name="titulo" placeholder="Titulo da tarefa" required>

        <label for="descricao">Descrição</label>
        <input type="text" name="descricao" placeholder="Descrição da tarefa" required>

        <label for="setor">Setor da Empresa</label>
        <input type="text" name="setor" placeholder="Setor da tarefa" required>

        <label for="setor">Prioridade</label>
        <select name="prioridade">
            <?php foreach (['baixa', 'media', 'alta'] as $p): ?>
                <option value="<?= $p ?>" <?= ['prioridade'] === $p ? 'selected' : '' ?>>
                    <?= ucfirst($p) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button type="submit">Adicionar</button>
    </form>
    <a href="index.php">Voltar para Gerenciamento</a>
</body>
<?php if ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Sucesso!',
            text: 'Tarefa adicionada com sucesso.',
            confirmButtonText: 'OK'
        });
        <?php endif; ?>
    </script>

</html>