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
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      background: url('IMG/3d9578cd-3221-47c1-bbe2-22c4a8e0.png') no-repeat center center fixed;
      background-size: cover;
      backdrop-filter: blur(8px);
    }

    .container {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background: rgba(255, 255, 255, 0.8);
      border-radius: 15px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      width: 80%;
      max-width: 1000px;
      padding: 20px;
      overflow: hidden;
    }

    .imagem-container {
      flex: 1;
      text-align: center;
      padding: 20px;
    }

    .imagem-container img {
      width: 100%;
      max-width: 400px;
      border-radius: 10px;
    }

    .area-login {
      flex: 1;
      display: flex;
      flex-direction: column;
      justify-content: center;
      padding: 20px;
    }

    .first-column {
      margin-bottom: 20px;
      text-align: center;
    }

    .first-column h2 {
      font-size: 24px;
      margin-bottom: 10px;
    }

    .first-column p {
      font-size: 14px;
      line-height: 1.6;
      color: #333;
    }

    .second-column {
      text-align: center;
    }

    .second-column h1 {
      margin-bottom: 20px;
      font-size: 28px;
      color: dodgerblue;
    }

    .form input {
      width: 80%;
      max-width: 300px;
      padding: 10px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 5px;
      font-size: 14px;
    }

    .form button {
      width: 80%;
      max-width: 300px;
      padding: 10px;
      margin: 10px 0;
      background: dodgerblue;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-size: 16px;
      transition: background 0.3s;
    }

    .form button:hover {
      background: #005bb5;
    }

    .create-account-btn {
      background: lightgreen;
    }

    .error-message {
      color: red;
      font-size: 14px;
      margin-top: 10px;
    }
  </style>
</head>
<body>

  <div class="container">
    <div class="imagem-container">
      <img src="IMG/3d9578cd-3221-47c1-bbe2-22c4a8e0662a.jpg" alt="Logo">
    </div>
    <div class="area-login">
      <div class="first-column">
        <h2 class="title">Bem vindo ao VaxNet!</h2>
        <p>
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
        <h1 class="title">Login</h1>
        <form class="form" method="POST" action="login.php">
          <input type="email" name="email" placeholder="Email" required>
          <input type="password" name="senha" placeholder="Senha" required>
          
          <?php
          if (isset($_SESSION['error_message'])) {
              echo '<div class="error-message">' . $_SESSION['error_message'] . '</div>';
              unset($_SESSION['error_message']);
          }
          ?>

          <div>
            <button type="submit" name="tipo" value="usuario">Login de Usuário</button>
            <button type="submit" name="tipo" value="veterinario">Login de Veterinário</button>
          </div>
          
          <div>
            <button type="button" onclick="window.location.href='Cadastro_Usuario_Veterinario.php'" class="create-account-btn">Criar conta</button>
          </div>
        </form>    
      </div>
    </div>
  </div>

</body>
</html>
