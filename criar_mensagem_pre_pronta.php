<?php
session_start();
include('navbar.php');

// Conexão ao banco
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "VaxNet";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $conteudo = $_POST['conteudo'];

    $sql = "INSERT INTO mensagens_pre_prontas (titulo, conteudo) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $titulo, $conteudo);

    if ($stmt->execute()) {
        echo "Mensagem pré-pronta criada com sucesso!";
    } else {
        echo "Erro ao criar mensagem: " . $conn->error;
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Mensagem Pré-pronta</title>
</head>
<body>
    <h2>Criar Mensagem Pré-pronta</h2>
    <form method="POST" action="">
        <label for="titulo">Título:</label><br>
        <input type="text" id="titulo" name="titulo" required><br><br>

        <label for="conteudo">Conteúdo:</label><br>
        <textarea id="conteudo" name="conteudo" rows="4" cols="50" required></textarea><br><br>

        <button type="submit">Salvar Mensagem</button>
    </form>
</body>
</html>
<?php $conn->close(); ?>
