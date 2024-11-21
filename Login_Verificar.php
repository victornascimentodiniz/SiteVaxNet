<?php
session_start();

// Configuração de conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "VaxNet";

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Verificar se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Verificar se o usuário existe no banco de dados
    $sql = "SELECT * FROM cadastro_usuario WHERE email = ? AND senha = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $senha);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Usuário encontrado, logado com sucesso
        $_SESSION['user'] = $email;  // Salva a informação do usuário na sessão
        header("Location: Home.php"); // Redireciona para a página home
        exit();
    } else {
        // Senha ou email incorretos
        $_SESSION['error_message'] = "Erro: Email ou senha inválidos!";
        header("Location: Login1.php"); // Redireciona de volta para o login
        exit();
    }
}

$conn->close();
?>
