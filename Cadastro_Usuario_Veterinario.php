<?php
session_start();
include('navbar.php');

// Conexão ao banco
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "VaxNet";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Processar formulários
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['acao']) && $_POST['acao'] === 'criar_pre_pronta') {
        $titulo = $_POST['titulo'];
        $conteudo = $_POST['conteudo'];

        $sql = "INSERT INTO mensagens_pre_prontas (titulo, conteudo) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $titulo, $conteudo);
        $stmt->execute();
        $stmt->close();
        $mensagem = "Mensagem pré-pronta criada com sucesso!";
    } elseif (isset($_POST['acao']) && $_POST['acao'] === 'criar_automatica') {
        $usuario_id = $_POST['usuario'];
        $mensagem_pre_pronta_id = $_POST['mensagem_pre_pronta'];
        $data_envio = $_POST['data_envio'];

        $sql_pre_pronta = "SELECT conteudo FROM mensagens_pre_prontas WHERE id = ?";
        $stmt = $conn->prepare($sql_pre_pronta);
        $stmt->bind_param("i", $mensagem_pre_pronta_id);
        $stmt->execute();
        $stmt->bind_result($conteudo);
        $stmt->fetch();
        $stmt->close();

        $sql = "INSERT INTO mensagem (usuario_id, conteudo, data_envio_programado, status) VALUES (?, ?, ?, 0)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iss", $usuario_id, $conteudo, $data_envio);
        $stmt->execute();
        $stmt->close();
        $mensagem = "Mensagem automática agendada com sucesso!";
    }
}

// Consultar usuários cadastrados
$sql_usuarios = "SELECT id, nome FROM cadastro_usuario";
$result_usuarios = $conn->query($sql_usuarios);

// Consultar mensagens pré-prontas
$sql_pre_prontas = "SELECT id, titulo FROM mensagens_pre_prontas";
$result_pre_prontas = $conn->query($sql_pre_prontas);

// Consultar mensagens automáticas
$sql_automaticas = "SELECT mensagem.id_mensagem, mensagem.conteudo, mensagem.data_envio_programado, mensagem.status, cadastro_usuario.nome AS destinatario 
                    FROM mensagem
                    JOIN cadastro_usuario ON mensagem.usuario_id = cadastro_usuario.id
                    ORDER BY mensagem.data_envio_programado ASC";
$result_automaticas = $conn->query($sql_automaticas);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Mensagens</title>
    <link rel="stylesheet" href="Mensagem_Automatica.css">
</head>
<body>
    <div class="container">
        <h1>Gerenciamento de Mensagens</h1>

        <?php if (isset($mensagem)): ?>
            <p class="success-message"><?= htmlspecialchars($mensagem) ?></p>
        <?php endif; ?>

        <div class="layout">
            <div class="formulario">
                <h2>Criar Mensagem Pré-pronta</h2>
                <form method="POST" action="">
                    <input type="hidden" name="acao" value="criar_pre_pronta">
                    <label for="titulo">Título:</label>
                    <input type="text" id="titulo" name="titulo" required>

                    <label for="conteudo">Conteúdo:</label>
                    <textarea id="conteudo" name="conteudo" rows="4" required></textarea>

                    <button type="submit">Salvar Mensagem Pré-pronta</button>
                </form>

                <h2>Agendar Mensagem Automática</h2>
                <form method="POST" action="">
                    <input type="hidden" name="acao" value="criar_automatica">

                    <label for="usuario">Selecione o Usuário:</label>
                    <select id="usuario" name="usuario" required>
                        <option value="">Selecione</option>
                        <?php while ($usuario = $result_usuarios->fetch_assoc()): ?>
                            <option value="<?= $usuario['id'] ?>"><?= htmlspecialchars($usuario['nome']) ?></option>
                        <?php endwhile; ?>
                    </select>

                    <label for="mensagem_pre_pronta">Escolha uma Mensagem Pré-pronta:</label>
                    <select id="mensagem_pre_pronta" name="mensagem_pre_pronta" required>
                        <option value="">Selecione</option>
                        <?php while ($mensagem = $result_pre_prontas->fetch_assoc()): ?>
                            <option value="<?= $mensagem['id'] ?>"><?= htmlspecialchars($mensagem['titulo']) ?></option>
                        <?php endwhile; ?>
                    </select>

                    <label for="data_envio">Data de Envio:</label>
                    <input type="datetime-local" id="data_envio" name="data_envio" required>

                    <button type="submit">Agendar Mensagem</button>
                </form>
            </div>

            <div class="linha-vertical"></div>

            <div class="tabela-mensagens">
                <h2>Mensagens Automáticas</h2>
                <table>
                    <tr>
                        <th>ID</th>
                        <th>Conteúdo</th>
                        <th>Data de Envio</th>
                        <th>Status</th>
                        <th>Destinatário</th>
                        <th>Ações</th>
                    </tr>
                    <?php while ($row = $result_automaticas->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['id_mensagem'] ?></td>
                            <td><?= htmlspecialchars($row['conteudo']) ?></td>
                            <td><?= $row['data_envio_programado'] ?></td>
                            <td><?= $row['status'] == 1 ? 'Enviado' : 'Pendente' ?></td>
                            <td><?= htmlspecialchars($row['destinatario']) ?></td>
                            <td>
                                <a href="editar_mensagem.php?id=<?= $row['id_mensagem'] ?>">Editar</a> | 
                                <a href="excluir_mensagem.php?id=<?= $row['id_mensagem'] ?>" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
<?php
$conn->close();
?>
