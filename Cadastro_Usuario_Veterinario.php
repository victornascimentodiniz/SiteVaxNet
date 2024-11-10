<?php
// Iniciar sessão para exibir mensagens de sucesso ou erro
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

// Verificar se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tipo = $_POST['tipo'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $telefone = $_POST['telefone'];
    $endereco = $_POST['endereco'];

    // Checar o tipo de cadastro e preparar a consulta
    if ($tipo == 'usuario') {
        // Campos adicionais de usuário
        $data_nascimento = $_POST['data_nascimento'];
        $data_criacao = date("Y-m-d");

        $stmt = $conn->prepare("INSERT INTO cadastro_usuario (nome, email, senha, telefone, data_nascimento, endereco, data_criacao) 
                                VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $nome, $email, $senha, $telefone, $data_nascimento, $endereco, $data_criacao);

    } else if ($tipo == 'veterinario') {
        // Campos adicionais de veterinário
        $crmv = $_POST['crmv'];
        $especializacao = $_POST['especializacao'];
        $status = $_POST['status'];
        $data_cadastro = date("Y-m-d");

        $stmt = $conn->prepare("INSERT INTO cadastro_veterinario (nome, email, senha, telefone, endereco, crmv, especialidade, status, data_cadastro) 
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssss", $nome, $email, $senha, $telefone, $endereco, $crmv, $especialidade, $status, $data_cadastro);
    }

    // Executar a consulta e verificar sucesso
    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Cadastro realizado com sucesso!";
    } else {
        $_SESSION['error_message'] = "Erro: " . $stmt->error;
    }

    // Fechar a declaração e a conexão
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cadastro de Usuário e Veterinário</title>
  <link rel="stylesheet" href="Cadastro.css"> <!-- Adicione seu arquivo CSS aqui -->
</head>
<body>

  <h2>Cadastro de Usuário e Veterinário</h2>

  <?php
  // Exibir mensagens de sucesso ou erro
  if (isset($_SESSION['success_message'])) {
      echo "<p style='color: green;'>{$_SESSION['success_message']}</p>";
      unset($_SESSION['success_message']);
  } elseif (isset($_SESSION['error_message'])) {
      echo "<p style='color: red;'>{$_SESSION['error_message']}</p>";
      unset($_SESSION['error_message']);
  }
  ?>

  <form action="" method="POST">
    <!-- Seleção de Tipo de Cadastro -->
    <label for="tipo">Tipo de Cadastro:</label>
    <select name="tipo" id="tipo" onchange="mostrarCampos()">
      <option value="usuario">Usuário</option>
      <option value="veterinario">Veterinário</option>
    </select>

    <!-- Campos Comuns -->
    <label for="nome">Nome:</label>
    <input type="text" name="nome" required>

    <label for="email">Email:</label>
    <input type="email" name="email" required>

    <label for="senha">Senha:</label>
    <input type="password" name="senha" required>

    <label for="telefone">Telefone:</label>
    <input type="text" name="telefone" required>

    <label for="endereco">Endereço:</label>
    <input type="text" name="endereco" required>

    <!-- Campos Específicos de Usuário -->
    <div id="campos_usuario">
      <label for="data_nascimento">Data de Nascimento:</label>
      <input type="date" name="data_nascimento">
    </div>

    <!-- Campos Específicos de Veterinário -->
    <div id="campos_veterinario" style="display: none;">
      <label for="crmv">CRMV:</label>
      <input type="text" name="crmv">

      <label for="especializacao">Especialização:</label>
      <input type="text" name="especializacao">

      <label for="status">Status:</label>
      <select name="status">
        <option value="ativo">Ativo</option>
        <option value="inativo">Inativo</option>
      </select>
    </div>

    <button type="submit">Cadastrar</button>
  </form>

  <script>
    function mostrarCampos() {
      const tipo = document.getElementById("tipo").value;
      document.getElementById("campos_usuario").style.display = tipo === "usuario" ? "block" : "none";
      document.getElementById("campos_veterinario").style.display = tipo === "veterinario" ? "block" : "none";
    }
  </script>
</body>
</html>
