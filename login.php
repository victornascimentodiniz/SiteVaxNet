<?php
session_start();

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

// Verificar se o login foi solicitado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $tipo = $_POST['tipo']; // tipo pode ser 'usuario' ou 'veterinario'

    // Sanitizar os dados para prevenir SQL Injection
    $email = $conn->real_escape_string($email);
    $senha = $conn->real_escape_string($senha);

    // Verificar se o tipo é 'usuario' ou 'veterinario' e consultar o banco
    if ($tipo == 'usuario') {
        $stmt = $conn->prepare("SELECT * FROM cadastro_usuario WHERE email = ? AND senha = ?");
    } else {
        $stmt = $conn->prepare("SELECT * FROM cadastro_veterinario WHERE email = ? AND senha = ?");
    }
    
    $stmt->bind_param("ss", $email, $senha);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificar se a consulta retornou resultados
    if ($result->num_rows > 0) {
        // Login bem-sucedido
        $user = $result->fetch_assoc();
        $_SESSION['email'] = $email;
        $_SESSION['tipo'] = $tipo; // Armazenar o tipo de login (usuario ou veterinario)
        $_SESSION['id'] = $user['id']; // Armazenar o ID do usuário ou veterinário
        header("Location: Home.php"); // Redirecionar para a página inicial
        exit(); // Importante para parar a execução do código PHP após o redirecionamento
    } else {
        // Login falhou
        $_SESSION['error_message'] = "Email ou senha incorretos";
    }

    // Fechar conexão
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tela de Login</title>
  <link rel="stylesheet" href="Login_novo.css">
</head>
<body>

  <div class="container">
    <div class="imagem-container" style="text-align: center;">
      <img src="IMG/3d9578cd-3221-47c1-bbe2-22c4a8e0662a.jpg" alt="Logo" style="height: 100px; width: 100px; margin-top: 150px;">
    </div>
    <div class="area-login">
      <div class="first-column">
        <h2 class="title" style="color: lavender;">Bem vindo ao VaxNet!</h2>
        <p style="text-align: center;">
          Facilitamos o controle das vacinas dos seus <br>
          animais. Registre todas as doses, acompanhe <br>
          datas importantes e receba notificações <br>
          diretamente para você. Tudo de forma rápida <br>
          e prática, para que você tenha controle <br>
          completo da saúde dos seus animais, onde <br>
          quer que esteja.
        </p>
      </div>
      <div class="second-column">
        <h1 class="title" style="color:dodgerblue;">Login</h1>
        <form class="form" method="POST" action="login.php">
          <input type="email" name="email" placeholder="Email" required style="width: 150px; align-self: center;">
          <input type="password" name="senha" placeholder="Senha" required style="width: 150px; align-self: center;">
          
          <!-- Exibir a mensagem de erro se houver -->
          <?php
          if (isset($_SESSION['error_message'])) {
              echo '<div class="error-message" style="display: block;">' . $_SESSION['error_message'] . '</div>';
              unset($_SESSION['error_message']);
          }
          ?>

          <!-- Botões para selecionar o tipo de login -->
          <div style="text-align: center; margin-top: 10px;">
            <button type="submit" name="tipo" value="usuario" style="width: 120px;">Login de Usuário</button>
            <button type="submit" name="tipo" value="veterinario" style="width: 120px;">Login de Veterinário</button>
          </div>
          
          <!-- Botão de Criar Conta -->
          <div style="text-align: center; margin-top: 15px;">
            <button type="button" onclick="window.location.href='Cadastro_Usuario_Veterinario.php'" class="create-account-btn">Criar conta</button>
          </div>
        </form>    
      </div>
    </div>
  </div>

</body>
</html>
