<?php
include 'conexao.php';

session_start();

// ATUALIZAÇÃO DE TAREFA
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit-id'])) {
    $id = (int)$_POST['edit-id'];
    $titulo = mysqli_real_escape_string($conexao, $_POST['titulo']);
    $descricao = mysqli_real_escape_string($conexao, $_POST['descricao']);
    $setor = mysqli_real_escape_string($conexao, $_POST['setor']);
    $prioridade = mysqli_real_escape_string($conexao, $_POST['prioridade']);
    $status = mysqli_real_escape_string($conexao, $_POST['status']);

    $sql = "UPDATE tarefas SET 
        titulo_tarefa = '$titulo',
        descricao_tarefa = '$descricao',
        setor = '$setor',
        prioridade = '$prioridade',
        status_tarefa = '$status'
        WHERE id_tarefa = $id";
    mysqli_query($conexao, $sql);

    $_SESSION['editado'] = true;
    header('Location: index.php');
    exit;
}


if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $sql = "DELETE FROM tarefas WHERE id_tarefa = $id";
    mysqli_query($conexao, $sql);
    header('Location: index.php');
    exit;
}

if (isset($_GET['status']) && isset($_GET['id_tarefa'])) {
    $id = (int)$_GET['id_tarefa'];
    $status = $_GET['status'];
    $status_validos = ['fazer', 'fazendo', 'concluido'];
    if (in_array($status, $status_validos)) {
        $sql = "UPDATE tarefas SET status_tarefa = '$status' WHERE id_tarefa = $id";
        mysqli_query($conexao, $sql);
    }
    header('Location: index.php');
    exit;
}

if (isset($_GET['prioridade']) && isset($_GET['id_tarefa'])) {
    $id = (int)$_GET['id_tarefa'];
    $prioridade = $_GET['priority'];
    $prioridades = ['baixa', 'media', 'alta'];
    if (in_array($prioridade, $prioridades)) {
        $sql = "UPDATE tarefas SET prioridade = '$prioridade' WHERE id_tarefa = $id";
        mysqli_query($conexao, $sql);
    }
    header('Location: index.php');
    exit;
}

$sql = "SELECT * FROM tarefas ORDER BY id_tarefa DESC";
$result = mysqli_query($conexao, $sql);
$tasks = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Gerenciador de Tarefas</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/gerenciamento.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />

    <style>
        .done {
            text-decoration: line-through;
            color: gray;
        }

        .prioridade-baixa {
            color: green;
        }

        .prioridade-media {
            color: orange;
        }

        .prioridade-alta {
            color: red;
        }
    </style>
</head>
<nav>
    <img class="logo" src="../img/logo.png" alt="">
    <div class="nav-links">
        <a href="add.php">Adicionar nova tarefa</a>
        <?php
        if (isset($_SESSION['id_sessao'])) {
            echo '<a href="logout.php">Sair</a>';
        } else {
            echo '<a href="login.php">Entrar</a>';
        }
        ?>
        <img src="../img/user.webp" alt="Usuário" class="user-avatar">
    </div>
</nav>

<body>
    <?php if (isset($_SESSION['editado'])): ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Editado com sucesso!',
                confirmButtonText: 'OK'

            });
        </script>
    <?php unset($_SESSION['editado']);
    endif; ?>


    <h1 style="font-size: 40px">Lista de Tarefas</h1>

    <h1>Tarefas divididas por status</h1>
    <table border="1" cellpadding="8" cellspacing="0">
        <tr>
            <th>A fazer</th>
            <th>Fazendo</th>
            <th>Concluído</th>
        </tr>
        <?php ?>
        <tr>
            <td>
                <?php
                $sql = "SELECT * FROM tarefas WHERE status_tarefa = 'fazer' ";
                $result = mysqli_query($conexao, $sql);
                $tasks = mysqli_fetch_all($result, MYSQLI_ASSOC);
                foreach ($tasks as $t): ?>
                    <?= htmlspecialchars($t['titulo_tarefa']) ?>
                <?php endforeach;
                ?>

            </td>

            <td>
                <?php
                $sql = "SELECT * FROM tarefas WHERE status_tarefa = 'fazendo' ";
                $result = mysqli_query($conexao, $sql);
                $tasks = mysqli_fetch_all($result, MYSQLI_ASSOC);
                foreach ($tasks as $t): ?>
                    <?= htmlspecialchars($t['titulo_tarefa']) ?>
                <?php endforeach;
                ?>

            </td>

            <td>
                <?php
                $sql = "SELECT * FROM tarefas WHERE status_tarefa = 'concluido' ";
                $result = mysqli_query($conexao, $sql);
                $tasks = mysqli_fetch_all($result, MYSQLI_ASSOC);
                foreach ($tasks as $t): ?>
                    <?= htmlspecialchars($t['titulo_tarefa']) ?>
                <?php endforeach;
                ?>
            </td>
        </tr>
    </table>

    <h1>Todas as Tarefas</h1>
    <?php
    $sql = "SELECT t.*, u.nome_usuario FROM tarefas t LEFT JOIN usuarios u ON t.fk_id_usuario = u.id_usuario";
    $result = mysqli_query($conexao, $sql);
    $tasks = mysqli_fetch_all($result, MYSQLI_ASSOC);
    ?>
    <table border="1" cellpadding="8" cellspacing="0">
        <tr>
            <th>Título</th>
            <th>Descrição</th>
            <th>Prioridade</th>
            <th>Status</th>
            <th>Dono</th>
            <th>Setor</th>
            <th>Ações</th>
        </tr>
        <?php foreach ($tasks as $t): ?>
            <tr>
                <td><?= htmlspecialchars($t['titulo_tarefa']) ?></td>
                <td><?= htmlspecialchars($t['descricao_tarefa']) ?></td>
                <td>
                    <span class="prioridade-<?= htmlspecialchars($t['prioridade']) ?>">
                        <?= ucfirst(htmlspecialchars($t['prioridade'])) ?>
                    </span>
                    <form method="get" style="display:inline;">
                        <input type="hidden" name="id" value="<?= $t['id_tarefa'] ?>">

                    </form>
                </td>
                <td>
                    <span class="status-<?= htmlspecialchars($t['status_tarefa']) ?>">
                        <?= ucfirst(htmlspecialchars($t['status_tarefa'])) ?>
                    </span>
                    <form method="get" style="display:inline;">
                        <input type="hidden" name="id" value="<?= $t['id_tarefa'] ?>">

                    </form>
                </td>
                <td><?= htmlspecialchars($t['nome_usuario'] ?? 'Não informado') ?></td> <!-- NOVA COLUNA -->
                <td><?= htmlspecialchars($t['setor']) ?></td>

                <td>
                    <div class="card-actions">

                        <button class="btn-edit" type="button"
                            onclick="openEditModal(
                                '<?= addslashes($t['id_tarefa']) ?>',
                                '<?= addslashes(htmlspecialchars($t['titulo_tarefa'])) ?>',
                                '<?= addslashes(htmlspecialchars($t['descricao_tarefa'])) ?>',
                                '<?= addslashes(htmlspecialchars($t['setor'])) ?>',
                                '<?= addslashes($t['prioridade']) ?>',
                                '<?= addslashes($t['status_tarefa']) ?>'
                            )">
                            <i class="bx bxs-pencil"></i>
                        </button>

                        <a href="?delete=<?= $t['id_tarefa'] ?>" onclick="return confirm('Excluir tarefa?')">
                            <button class="btn-delete" onclick="confirmDelete(<?= $row['id'] ?>)">
                                <i class="bx bxs-trash"></i>
                            </button>
                        </a>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <script>
        // Modal de Inserir Apoiador
        document.addEventListener('DOMContentLoaded', () => {
            const openModalBtn = document.getElementById('openModal');
            const modal = document.getElementsById('editModal');
            const close = document.getElementById('closeEditModal');

            if (close) {
                close.addEventListener('click', () => {
                    modal.style.display = 'none';
                });
            }
            window.addEventListener('click', (event) => {
                if (event.target === modal) {
                    modal.style.display = 'none';
                }
            });
        });

        // Função para abrir o modal de edição
        function openEditModal(id, titulo, descricao, setor, prioridade, status) {
            const modal = document.getElementById('editModal');
            modal.style.display = 'flex';

            document.getElementById('edit-id').value = id;
            document.getElementById('edit-titulo').value = titulo;
            document.getElementById('edit-prioridade').value = prioridade;
            document.getElementById('edit-status').value = status;
            document.getElementById('edit-descricao').value = descricao;
            document.getElementById('edit-setor').value = setor;

        }

        function fecharModal() {
            const modal = document.getElementById('editModal');
            modal.style.display = 'none';
        }
    </script>
    <!-- MODAL -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span id="closeEditModal" class="close" onclick="fecharModal()">&times;</span>
            <h2>Editar Tarefa</h2>
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="edit-id" id="edit-id">

                <label for="edit-titulo">Titulo</label>
                <input type="text" name="titulo" id="edit-titulo" placeholder="Titulo" required><br>

                <label for="edit-descricao">Descrição</label>
                <textarea name="descricao" id="edit-descricao" placeholder="Descrição (máx 255 caracteres)" maxlength="255" required></textarea><br>

                <label for="edit-setor">Setor</label>
                <input type="text" name="setor" id="edit-setor" placeholder="Setor" maxlength="255" required><br>

                <label for="edit-prioridade">Prioridade</label>
                <select name="prioridade" id="edit-prioridade" required>
                    <option value="baixa">Baixa</option>
                    <option value="media">Média</option>
                    <option value="alta">Alta</option>
                </select><br>

                <label for="edit-status">Status</label>
                <select name="status" id="edit-status" required>
                    <option value="fazer">Fazer</option>
                    <option value="fazendo">Fazendo</option>
                    <option value="concluido">Concluído</option>
                </select><br>

                <button type="submit">Salvar Alterações</button>
            </form>
        </div>
    </div>

    </section>
</body>

</html>