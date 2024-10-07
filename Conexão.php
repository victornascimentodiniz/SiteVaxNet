<?php
// Configuração de conexão ao banco de dados
$servername = "localhost";
$username = "root";  // Seu usuário MySQL
$password = "";      // Sua senha MySQL
$dbname = "VaxNet";  // Seu banco de dados

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
$proxima_vacina = $_POST['proxima_vacina'];
$responsavel = $_POST['responsavel'];
$contato_responsavel = $_POST['contato_responsavel'];
$observacoes = $_POST['observacoes'];

// Inserir dados no banco de dados
$sql = "INSERT INTO cadastros_animais (nome, raca, idade, data_nascimento, cor, sexo, identificacao, vacinas, data_cadastro, proxima_vacina, responsavel, contato_responsavel, observacoes)
        VALUES ('$nome', '$raca', '$idade', '$data_nascimento', '$cor', '$sexo', '$identificacao', '$vacinas', '$data_cadastro', '$proxima_vacina', '$responsavel', '$contato_responsavel', '$observacoes')";

if ($conn->query($sql) === TRUE) {
    echo "Cadastro realizado com sucesso!";
} else {
    echo "Erro: " . $sql . "<br>" . $conn->error;
}

// Fechar conexão
$conn->close();
?>
