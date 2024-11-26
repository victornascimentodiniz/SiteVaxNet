<?php
session_start();
include('navbar.php');

// Conexão ao banco
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "VaxNet";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Buscar mensagens
$sql = "SELECT id_mensagem, conteudo, data_envio_programado, status FROM mensagem ORDER BY data_envio_programado ASC";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mensagens Automáticas</title>
</head>
<body>
    <h2>Mensagens Automáticas</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Conteúdo</th>
            <th>Data de Envio</th>
            <th>Status</th>
            <th>Ações</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id_mensagem'] ?></td>
                <td><?= htmlspecialchars($row['conteudo']) ?></td>
                <td><?= $row['data_envio_programado'] ?></td>
                <td><?= $row['status'] == 1 ? 'Enviado' : 'Pendente' ?></td>
                <td>
                    <a href="editar_mensagem.php?id=<?= $row['id_mensagem'] ?>">Editar</a>
                    <a href="excluir_mensagem.php?id=<?= $row['id_mensagem'] ?>" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
<?php
$conn->close();
?>
