<?php
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['user'])) {
    header("Location: Login1.php");
    exit();
}

// Configuração de conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "VaxNet";

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Obter o ID do usuário logado com base no email armazenado na sessão
$email = $_SESSION['user'];
$stmt = $conn->prepare("SELECT id_usuario FROM cadastro_usuario WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $id_usuario = $row['id_usuario']; // Captura o ID do usuário logado
} else {
    die("Usuário não encontrado.");
}
$stmt->close();

// Buscar mensagens do usuário logado
$stmt = $conn->prepare("SELECT titulo, mensagem, data_envio FROM mensagens WHERE id_usuario = ?");
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$result = $stmt->get_result();

// HTML e exibição das mensagens
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas Mensagens</title>
    <link rel="stylesheet" href="Mensagens_Usuario.css"> <!-- Opcional, estilo para a página -->
</head>
<body>
    <?php include('navbar.php'); ?> <!-- Inclui o menu de navegação -->
    
    <div class="mensagens-container">
        <h1>Minhas Mensagens</h1>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='mensagem'>";
                echo "<h3>" . htmlspecialchars($row['titulo']) . "</h3>";
                echo "<p>" . htmlspecialchars($row['mensagem']) . "</p>";
                echo "<small>Enviado em: " . htmlspecialchars($row['data_envio']) . "</small>";
                echo "</div><hr>";
            }
        } else {
            echo "<p>Você não possui mensagens no momento.</p>";
        }
        ?>
    </div>

    <?php include('footer.php'); ?> <!-- Inclui o rodapé -->
</body>
</html>
<?php
$stmt->close();
$conn->close();
?>
