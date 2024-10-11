<?php
session_start();
include('navbar.php');

// Conexão ao banco de dados
$servername = "localhost";
$username = "root";  
$password = "";      
$dbname = "VaxNet";  

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Obter dados do formulário
$id_animal = $_POST['id_animal'];
$nome = $_POST['nome'];
$raca = $_POST['raca'];
$idade = $_POST['idade'];
$cor = $_POST['cor'];
$sexo = $_POST['sexo'];
$identificacao = $_POST['identificacao'];
$vacinas = $_POST['vacinas'];
$data_nascimento = $_POST['data_nascimento'];
$observacoes = $_POST['observacoes'];
$responsavel = $_POST['responsavel'];
$contato_responsavel = $_POST['contato_responsavel'];

// Atualizar dados no banco de dados
$sql = "UPDATE cadastros_animais SET nome=?, raca=?, idade=?, cor=?, sexo=?, identificacao=?, vacinas=?, data_nascimento=?, observacoes=?, responsavel=?, contato_responsavel=? WHERE id_animal=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssisssssssii", $nome, $raca, $idade, $cor, $sexo, $identificacao, $vacinas, $data_nascimento, $observacoes, $responsavel, $contato_responsavel, $id_animal);

if ($stmt->execute()) {
    $_SESSION['success_message'] = "Cadastro atualizado com sucesso!";
} else {
    $_SESSION['error_message'] = "Erro ao atualizar cadastro: " . $stmt->error;
}

// Redirecionar de volta para a lista de animais
header("Location: Animais_Cadastrados.php");
exit();
?>
