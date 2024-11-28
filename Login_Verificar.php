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

    // Função genérica para autenticação
    function autenticarUsuario($conn, $email, $senha, $tabela, $redirect, $role) {
        $sql = "SELECT * FROM $tabela WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $dados = $result->fetch_assoc();
            // Verificar a senha criptografada
            if (password_verify($senha, $dados['senha'])) {
                $_SESSION['user'] = $email;  // Salva o email na sessão
                $_SESSION['role'] = $role;  // Define o tipo de conta
                header("Location: $redirect"); // Redireciona para a página home
                exit();
            }
        }
        return false; // Retorna falso se não autenticar
    }

    // Tentar autenticar como usuário
    if (autenticarUsuario($conn, $email, $senha, "cadastro_usuario", "Home_Usuario.php", "usuario")) {
        exit();
    }

    // Tentar autenticar como veterinário
    if (autenticarUsuario($conn, $email, $senha, "cadastro_veterinario", "Home.php", "veterinario")) {
        exit();
    }

    // Caso nenhum usuário seja encontrado
    $_SESSION['error_message'] = "Erro: Email ou senha inválidos!";
    header("Location: Login1.php"); // Redireciona de volta para o login
    exit();
}

$conn->close();
?>
