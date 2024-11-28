<?php
session_start(); // Inicia a sessão
include('navbar_usuario.php');

// Verifica se existe uma mensagem de sucesso
if (isset($_SESSION['success_message'])) {
    echo "<p id='success-message'>" . $_SESSION['success_message'] . "</p>";
    unset($_SESSION['success_message']); // Remove a mensagem da sessão
}

// Verifica se existe uma mensagem de erro
if (isset($_SESSION['error_message'])) {
    echo "<p id='error-message'>" . $_SESSION['error_message'] . "</p>";
    unset($_SESSION['error_message']); // Remove a mensagem da sessão
}

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtém os dados do formulário
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

    // Configuração de conexão com o banco de dados
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "VaxNet";
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar a conexão
    if ($conn->connect_error) {
        die("Falha na conexão: " . $conn->connect_error);
    }

    // Inserir os dados do animal no banco de dados
    $sql_animal = "INSERT INTO cadastros_animais (nome, raca, idade, data_nascimento, cor, sexo, identificacao, vacinas, data_cadastro, responsavel, contato_responsavel, observacoes)
                   VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt_animal = $conn->prepare($sql_animal);

    // Verifica se a preparação da consulta falhou
    if (!$stmt_animal) {
        die("Erro ao preparar a consulta: " . $conn->error); // Exibe o erro se falhar
    }

    $stmt_animal->bind_param("ssssssssssss", $nome, $raca, $idade, $data_nascimento, $cor, $sexo, $identificacao, $vacinas, $data_cadastro, $responsavel, $contato_responsavel, $observacoes);

    if ($stmt_animal->execute()) {
        // Criar um aviso automático baseado na idade do animal
        $data_nascimento_obj = new DateTime($data_nascimento);
        $data_atual = new DateTime();
        $intervalo = $data_nascimento_obj->diff($data_atual);
        $idade_em_anos = $intervalo->y;

        // Definir o aviso conforme a idade do animal
        if ($idade_em_anos < 1) {
            // Aviso a cada 45 dias para animais com menos de 1 ano
            $sql_aviso = "INSERT INTO avisos (titulo, descricao, responsavel, data_aviso, data_evento, ativo) 
                          VALUES (?, ?, ?, NOW(), ?, 1)";
            $stmt_aviso = $conn->prepare($sql_aviso);

            // Verifica se a preparação da consulta falhou
            if (!$stmt_aviso) {
                die("Erro ao preparar a consulta de aviso: " . $conn->error); // Exibe o erro se falhar
            }

            $titulo = "Vacinas de 45 dias para animais com menos de 1 ano";
            $descricao = "Necessário aplicar vacinas de 45 dias em animais com menos de um ano.";
            $responsavel = "Veterinário";
            $data_evento = $data_atual->modify('+45 days')->format('Y-m-d H:i:s');
            $stmt_aviso->bind_param("ssss", $titulo, $descricao, $responsavel, $data_evento);
            $stmt_aviso->execute();
        } else {
            // Aviso anual para animais com mais de 1 ano
            $sql_aviso = "INSERT INTO avisos (titulo, descricao, responsavel, data_aviso, data_evento, ativo) 
                          VALUES (?, ?, ?, NOW(), ?, 1)";
            $stmt_aviso = $conn->prepare($sql_aviso);

            // Verifica se a preparação da consulta falhou
            if (!$stmt_aviso) {
                die("Erro ao preparar a consulta de aviso: " . $conn->error); // Exibe o erro se falhar
            }

            $titulo = "Vacina anual do animal";
            $descricao = "Chegou a hora de tomar a vacina.";
            $responsavel = "Veterinário";
            $data_evento = $data_atual->modify('+1 year')->format('Y-m-d H:i:s');
            $stmt_aviso->bind_param("ssss", $titulo, $descricao, $responsavel, $data_evento);
            $stmt_aviso->execute();
        }

        $_SESSION['success_message'] = "Animal cadastrado com sucesso!";
    } else {
        $_SESSION['error_message'] = "Erro ao cadastrar o animal: " . $stmt_animal->error;
    }

    $stmt_animal->close();
    $conn->close();

    // Redirecionar após o cadastro
    header("Location: cadastro_animais.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cadastro de Animais</title>
  <link rel="stylesheet" href="cadastro_animais.css">
</head>
<body>
  <div class="cadastro-container">
    <h2>Cadastro de Animais</h2>
    <form action="Cadastro_Animais.php" method="POST">
      <input type="text" name="nome" placeholder="Nome do Animal" required>
      <input type="text" name="raca" placeholder="Raça" required>
      <input type="number" name="idade" placeholder="Idade" required>
      <input type="date" name="data_nascimento" placeholder="Data de Nascimento" required>
      <input type="text" name="cor" placeholder="Cor" required>
      <input type="text" name="sexo" placeholder="Sexo" required>
      <input type="text" name="identificacao" placeholder="Identificação" required>
      <input type="text" name="vacinas" placeholder="Vacinas" required>
      <input type="date" name="data_cadastro" required>
      <input type="text" name="responsavel" placeholder="Responsável" required>
      <input type="text" name="contato_responsavel" placeholder="Contato do Responsável" required>
      <input type="text" name="observacoes" placeholder="Observações" required>
      <button type="submit" class="submit-btn">Cadastrar</button>
    </form>
  </div>
</body>
</html>
