<?php
session_start(); // Inicia a sessão
// Configuração de conexão ao banco de dados
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

// Receber dados do formulário
$nome = $_POST['nome'];
$raca = $_POST['raca'];
$idade = $_POST['idade'];
$data_nascimento = $_POST['data_nascimento'];
$cor = $_POST['cor'];
$sexo = $_POST['sexo'];
$identificacao = $_POST['identificacao'];
$vacinas = $_POST['vacinas'];
$data_cadastro = $_POST['data_cadastro'];
$responsavel = $_POST['responsavel'];
$contato_responsavel = $_POST['contato_responsavel'];
$observacoes = $_POST['observacoes'];

// Preparar e vincular
$stmt = $conn->prepare("INSERT INTO cadastros_animais (nome, raca, idade, data_nascimento, cor, sexo, identificacao, vacinas, data_cadastro, responsavel, contato_responsavel, observacoes)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssiissssssss", $nome, $raca, $idade, $data_nascimento, $cor, $sexo, $identificacao, $vacinas, $data_cadastro, $responsavel, $contato_responsavel, $observacoes);

// Executar a consulta
if ($stmt->execute()) {
    $_SESSION['success_message'] = "Cadastro realizado com sucesso!";
    header('Location: Cadastro_Animais.php'); // Redireciona de volta para a página de cadastro
    exit(); // Para garantir que o script pare aqui
} else {
    $_SESSION['error_message'] = "Erro: " . $stmt->error;
    header('Location: Cadastro_Animais.php'); // Redireciona de volta em caso de erro
    exit(); // Para garantir que o script pare aqui
}

// Fechar a declaração e a conexão
$stmt->close();
$conn->close();
?>
