<?php
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'veterinario') {
    header("Location: Login1.php");
    exit();
}

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
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obter dados do formulário
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $responsavel = $_POST['responsavel'];  // Responsável (se necessário)
    $data_evento = $_POST['data_evento'];

    // Inserir aviso no banco de dados
    $sql = "INSERT INTO avisos (titulo, descricao, responsavel, data_aviso, data_evento, ativo) 
            VALUES (?, ?, ?, NOW(), ?, 1)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $titulo, $descricao, $responsavel, $data_evento);

    if ($stmt->execute()) {
        $msg = "Aviso salvo com sucesso!";
    } else {
        $msg = "Erro ao salvar o aviso: " . $stmt->error;
    }

    $stmt->close();
}

// Fechar conexão
$conn->close();
?>

<?php include('navbar.php'); ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Adicionar Aviso</title>
  <link rel="stylesheet" href="Home_Usuario.css">
</head>
<body>
  <!-- Container Principal -->
  <div class="home-wrapper">
    <div class="content-container">
      <!-- Formulário para Adicionar Aviso -->
      <div class="info-section">
        <h1>Adicionar Aviso</h1>

        <?php if (isset($msg)) { echo "<p>$msg</p>"; } ?>

        <form action="" method="POST">
            <label for="titulo">Título:</label>
            <input type="text" id="titulo" name="titulo" required><br>

            <label for="descricao">Descrição:</label>
            <textarea id="descricao" name="descricao" required></textarea><br>

            <label for="responsavel">Responsável:</label>
            <input type="text" id="responsavel" name="responsavel" required><br>

            <label for="data_evento">Data e Hora do Evento:</label>
            <input type="datetime-local" id="data_evento" name="data_evento" required><br>

            <input type="submit" value="Adicionar Aviso">
        </form>
      </div>

      <!-- Imagem (Direita) -->
      <div class="image-section">
        <img src="IMG/pessoas-de-ilustracao-plana-com-animais-de-estimacao_52683-65392.avif" alt="Ilustração de pets" />
      </div>
    </div>
  </div>

  <!-- Rodapé -->
  <?php include('footer.php'); ?>
</body>
</html>
