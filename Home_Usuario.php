<?php
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['user'])) {
    header("Location: Login1.php");
    exit();
}

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

// Buscar o nome do usuário com base na função armazenada na sessão
$email = $_SESSION['user'];
$role = $_SESSION['role'];
$name = "";

// Buscar o nome do usuário ou veterinário com base no tipo de conta
if ($role === 'usuario') {
    $sql = "SELECT nome FROM cadastro_usuario WHERE email = ?";
} elseif ($role === 'veterinario') {
    $sql = "SELECT nome FROM cadastro_veterinario WHERE email = ?";
}

if (!empty($sql)) {
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $name = strtoupper($row['nome']); // Caixa alta
    } else {
        $name = "Usuário não encontrado"; // Se não encontrar o nome
    }
    $stmt->close();
}

// Buscar mensagens destinadas ao usuário logado
$messages = [];
$sql_messages = "SELECT remetente_email, mensagem, data_envio 
                 FROM mensagens 
                 WHERE destinatario_email = ? 
                 ORDER BY data_envio DESC";
$stmt_messages = $conn->prepare($sql_messages);
$stmt_messages->bind_param("s", $email);
$stmt_messages->execute();
$result_messages = $stmt_messages->get_result();

if ($result_messages->num_rows > 0) {
    while ($row = $result_messages->fetch_assoc()) {
        $messages[] = $row;
    }
}

$stmt_messages->close();
$conn->close();
?>

<?php include('navbar.php'); ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home - Usuário</title>
  <link rel="stylesheet" href="Home_Usuario.css">
</head>
<body>
  <!-- Container Principal -->
  <div class="home-wrapper">
    <div class="content-container">
      <!-- Informações (Esquerda) -->
      <div class="info-section">
        <h1>Bem-vindo(a), <span id="user-name"><?php echo htmlspecialchars($name); ?></span>!</h1>
        <?php if ($name === "Usuário não encontrado"): ?>
          <p class="error-message">O usuário não foi encontrado no sistema. Por favor, entre em contato com o suporte.</p>
        <?php else: ?>
          <p>Gerencie a saúde dos seus pets de forma prática e eficiente.</p>
          <p>Aqui você pode:</p>
          <ul>
            <li>Registrar e acompanhar os dados dos seus pets.</li>
            <li>Monitorar as vacinas já aplicadas e pendentes.</li>
            <li>Agendar e acompanhar futuras vacinações.</li>
          </ul>
          <button onclick="window.location.href='Cadastro_Animais.php'">Ir para Cadastro</button>
        <?php endif; ?>
      </div>

      <!-- Mensagens -->
      <div class="messages-section">
        <h2>Suas Mensagens</h2>
        <?php if (empty($messages)): ?>
          <p>Você não tem mensagens novas.</p>
        <?php else: ?>
          <ul>
            <?php foreach ($messages as $message): ?>
              <li>
                <strong>De: <?php echo htmlspecialchars($message['remetente_email']); ?></strong><br>
                <em>Recebido em: <?php echo date("d/m/Y H:i:s", strtotime($message['data_envio'])); ?></em>
                <p><?php echo nl2br(htmlspecialchars($message['mensagem'])); ?></p>
              </li>
            <?php endforeach; ?>
          </ul>
        <?php endif; ?>
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
