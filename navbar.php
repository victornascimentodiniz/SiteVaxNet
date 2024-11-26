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

// Buscar o nome do usuário ou veterinário com base na função armazenada na sessão
$email = $_SESSION['user'];
$role = $_SESSION['role'];
$name = "";

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
    }
    $stmt->close();
}

$conn->close();

// Determinar a página atual
$current_page = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="navbar.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <title>Navbar</title>
</head>
<body>
  <!-- Navbar Horizontal -->
  <div class="navbar-horizontal">
    <div class="logo">
      <h1>VAXNET</h1>
    </div>
    <div class="actions">
      <button class="btn">Novidades</button>
      <button class="btn">Suporte</button>
    </div>
    <div class="user-info">
  <img src="IMG/3d9578cd-3221-47c1-bbe2-22c4a8e0.png" alt="Foto do Usuário" class="user-photo">
  <div class="dropdown" id="userDropdown">
    <button class="dropdown-toggle" onclick="toggleDropdown()">
      <?= htmlspecialchars($name) ?>
      <i class="fas fa-chevron-down"></i>
    </button>
    <div class="dropdown-menu">
      <a href="Configuracoes.php">Configurações</a>
      <a href="#" onclick="confirmLogout()">Sair</a>
    </div>
  </div>
</div>

</div>

  </div>

  <!-- Navbar Vertical -->
  <nav class="navbar-vertical">
    <img src="IMG/3d9578cd-3221-47c1-bbe2-22c4a8e0662a.png" alt="Logo" class="navbar-logo">
    <ul>
      <li><a href="Home.php" class="<?= $current_page == 'Home.php' ? 'active' : '' ?>"><i class="fas fa-home"></i> Home</a></li>
      <li><a href="Cadastro_Animais.php" class="<?= $current_page == 'Cadastro_Animais.php' ? 'active' : '' ?>"><i class="fas fa-plus-circle"></i> Cadastro de Animais</a></li>
      <li><a href="Cadastro_Vacina.php" class="<?= $current_page == 'Cadastro_Vacina.php' ? 'active' : '' ?>"><i class="fas fa-syringe"></i> Vacinas</a></li>
      <li><a href="Animais_Cadastrados.php" class="<?= $current_page == 'Animais_Cadastrados.php' ? 'active' : '' ?>"><i class="fas fa-paw"></i> Animais</a></li>
      <li><a href="Veterinario.php" class="<?= $current_page == 'Veterinario.php' ? 'active' : '' ?>"><i class="fa-solid fa-user-doctor"></i> Veterinário</a></li>
      <li><a href="Mensagem_Automatica.php" class="<?= $current_page == 'Mensagem_Automatica.php' ? 'active' : '' ?>"><i class="fas fa-comments"></i> Mensagens Automáticas</a></li>
      <li><a href="Monitoramento.php" class="<?= $current_page == 'Monitoramento.php' ? 'active' : '' ?>"><i class="fas fa-chart-line"></i> Monitoramento</a></li>
      <li><a href="Sobre.php" class="<?= $current_page == 'Sobre.php' ? 'active' : '' ?>"><i class="fas fa-info-circle"></i> Sobre</a></li>
      <li><a href="Contato.php" class="<?= $current_page == 'Contato.php' ? 'active' : '' ?>"><i class="fas fa-envelope"></i> Contato</a></li>
    </ul>
  </nav>
  <script>
  // Alterna o menu dropdown
  function toggleDropdown() {
    const dropdown = document.getElementById('userDropdown');
    dropdown.classList.toggle('active');
  }

  // Fecha o menu dropdown se clicar fora dele
  document.addEventListener('click', function (event) {
    const dropdown = document.getElementById('userDropdown');
    if (!dropdown.contains(event.target)) {
      dropdown.classList.remove('active');
    }
  });

  // Confirmação ao clicar em "Sair"
  function confirmLogout() {
    const confirmed = confirm("Tem certeza que deseja sair?");
    if (confirmed) {
      window.location.href = "Logout.php"; // Substitua com o caminho correto
    }
  }
</script>


</body>
</html>
