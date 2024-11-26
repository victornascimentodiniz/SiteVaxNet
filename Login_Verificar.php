<?php
session_start();

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

// Verificar se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Verificar se o email e senha pertencem a um usuário
    $sql_usuario = "SELECT * FROM cadastro_usuario WHERE email = ? AND senha = ?";
    $stmt_usuario = $conn->prepare($sql_usuario);
    $stmt_usuario->bind_param("ss", $email, $senha);
    $stmt_usuario->execute();
    $result_usuario = $stmt_usuario->get_result();

    if ($result_usuario->num_rows > 0) {
        // Usuário encontrado
        $_SESSION['user'] = $email;  // Salva o email na sessão
        $_SESSION['role'] = 'usuario'; // Define o tipo de conta
        header("Location: Home_Usuario.php"); // Redireciona para a página home
        exit();
    }

    // Verificar se o email e senha pertencem a um veterinário
    $sql_vet = "SELECT * FROM cadastro_veterinario WHERE email = ? AND senha = ?";
    $stmt_vet = $conn->prepare($sql_vet);
    $stmt_vet->bind_param("ss", $email, $senha);
    $stmt_vet->execute();
    $result_vet = $stmt_vet->get_result();

    if ($result_vet->num_rows > 0) {
        // Veterinário encontrado
        $_SESSION['user'] = $email;  // Salva o email na sessão
        $_SESSION['role'] = 'veterinario'; // Define o tipo de conta
        header("Location: Home.php"); // Redireciona para a página home
        exit();
    }

    // Caso nenhum usuário seja encontrado
    $_SESSION['error_message'] = "Erro: Email ou senha inválidos!";
    header("Location: Login1.php"); // Redireciona de volta para o login
    exit();
}

$conn->close();
?>
