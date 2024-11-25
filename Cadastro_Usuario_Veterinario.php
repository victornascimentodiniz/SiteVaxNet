<?php
session_start(); // Inicia a sessão para mensagens de sucesso ou erro

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

// Verificar se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tipo = isset($_POST['tipo']) ? $_POST['tipo'] : ''; // Tipo de cadastro
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $telefone = $_POST['telefone'];
    $endereco = $_POST['endereco'];

    // Verificar se o email já está cadastrado
    $sql = "SELECT * FROM cadastro_usuario WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Se o email já estiver no banco de dados
        $_SESSION['error_message'] = "Erro: O email já está cadastrado!";
        header("Location: Login1.php"); // Redireciona de volta ao formulário
        exit();
    }

    // Se for cadastro de veterinário
    if ($tipo == 'veterinario') {
        $crmv = $_POST['crmv'];
        $especializacao = $_POST['especializacao'];
        $status = $_POST['status'];
        $data_cadastro = date("Y-m-d");

        // Inserir dados no banco de dados
        $stmt = $conn->prepare("INSERT INTO cadastro_veterinario (nome, email, senha, telefone, endereco, crmv, especialidade, status, data_cadastro) 
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssss", $nome, $email, $senha, $telefone, $endereco, $crmv, $especialidade, $status, $data_cadastro);

        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Cadastro de Veterinário realizado com sucesso!";
        } else {
            $_SESSION['error_message'] = "Erro ao cadastrar: " . $stmt->error;
        }
        $stmt->close();
    } else {
        // Cadastro de usuário
        $stmt = $conn->prepare("INSERT INTO cadastro_usuario (nome, email, senha, telefone, endereco) 
                                VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $nome, $email, $senha, $telefone, $endereco);

        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Cadastro de Usuário realizado com sucesso!";
        } else {
            $_SESSION['error_message'] = "Erro ao cadastrar: " . $stmt->error;
        }
        $stmt->close();
    }
}

$conn->close(); // Fecha a conexão
header("Location: Login1.php"); // Redireciona para a página inicial ou outra de sua escolha
exit();
?>
