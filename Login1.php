<?php
session_start(); // Inicia a sessão para poder usar as variáveis de sessão

// Exibir mensagens de sucesso ou erro
if (isset($_SESSION['success_message'])) {
    echo '
    <div class="success-message-container">
        <div class="success-message">
            <i class="fas fa-check-circle"></i>
            <p>' . $_SESSION['success_message'] . '</p>
            <button id="ok-button">OK</button>
        </div>
    </div>';
    unset($_SESSION['success_message']);
}
if (isset($_SESSION['error_message'])) {
    echo '<div class="error-message">' . $_SESSION['error_message'] . '</div>';
    unset($_SESSION['error_message']);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cadastro</title>
  <link rel="stylesheet" href="login.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>
  <div class="container">
    <!-- Seção da esquerda -->
    <div class="left-section">
      <div class="logo">VAX<span>NET</span></div>
      <p>Rede de Vacina</p>
      <h2>Bem-vindo de volta!</h2>
      <p>Acesse sua conta agora mesmo.</p>
      <form method="POST" action="Login_Verificar.php">
      <div class="input-group">
        <i class="fas fa-envelope"></i>
        <input type="email" name="email" placeholder="Email" required>
      </div>
      <div class="input-group">
        <i class="fas fa-lock"></i>
        <input type="password" name="senha" placeholder="Senha" required>
      </div>
      <button type="submit" class="login-button">ENTRAR</button>
    </form>
      <a href="#" class="forgot-password">Esqueceu a senha?</a>
    </div>

    <!-- Seção da direita -->
    <div class="right-section">
      <div class="tabs">
        <button class="tab active" onclick="showForm('user')">Cadastro Usuário</button>
        <button class="tab" onclick="showForm('vet')">Cadastro Veterinário</button>
      </div>

      <!-- Formulário de Cadastro de Usuário -->
      <form id="user-form" class="form active" method="POST" action="Cadastro_Usuario_Veterinario.php">
        <input type="hidden" name="tipo" value="usuario"> <!-- Campo oculto para o tipo de cadastro -->
        <h2>Cadastro de Usuário</h2>
        <p>Preencha seus dados</p>
        <div class="input-group">
          <i class="fas fa-user"></i>
          <input type="text" name="nome" placeholder="     Nome" required>
        </div>
        <div class="input-group">
          <i class="fas fa-envelope"></i>
          <input type="email" name="email" placeholder="      Email" required>
        </div>
        <div class="input-group">
          <i class="fas fa-lock"></i>
          <input type="password" name="senha" placeholder="      Senha" required>
        </div>
        <div class="input-group">
          <i class="fas fa-phone"></i>
          <input type="text" name="telefone" placeholder="      Telefone" required>
        </div>
        <div class="input-group">
          <i class="fas fa-map-marker-alt"></i>
          <input type="text" name="endereco" placeholder="      Endereço" required>
        </div>
        <button type="submit" class="register-button">Cadastrar Usuário</button>
      </form>

      <!-- Formulário de Cadastro de Veterinário -->
      <form id="vet-form" class="form" method="POST" action="Cadastro_Usuario_Veterinario.php">
        <input type="hidden" name="tipo" value="veterinario"> <!-- Campo oculto para o tipo de cadastro -->
        <h2>Cadastro de Veterinário</h2>
        <p>Preencha seus dados</p>
        <div class="input-group">
          <i class="fas fa-user-md"></i>
          <input type="text" name="nome" placeholder="      Nome" required>
        </div>
        <div class="input-group">
          <i class="fas fa-envelope"></i>
          <input type="email" name="email" placeholder="      Email" required>
        </div>
        <div class="input-group">
          <i class="fas fa-lock"></i>
          <input type="password" name="senha" placeholder="      Senha" required>
        </div>
        <div class="input-group">
          <i class="fas fa-phone"></i>
          <input type="text" name="telefone" placeholder="      Telefone" required>
        </div>
        <div class="input-group">
          <i class="fas fa-map-marker-alt"></i>
          <input type="text" name="endereco" placeholder="      Endereço" required>
        </div>
        <div class="input-group">
          <i class="fas fa-id-badge"></i>
          <input type="text" name="crmv" placeholder="      CRMV" required>
        </div>
        <div class="input-group">
          <i class="fas fa-briefcase-medical"></i>
          <input type="text" name="especializacao" placeholder="      Especialização" required>
        </div>
        <div class="input-group status-group">
          <label for="status">Status:</label>
          <div class="status-toggle">
            <input type="radio" id="ativo" name="status" value="ativo" required>
            <label for="ativo" class="status-label ativo">Ativo</label>
            <input type="radio" id="inativo" name="status" value="inativo" required>
            <label for="inativo" class="status-label inativo">Inativo</label>
          </div>
        </div>
        <button type="submit" class="register-button">Cadastrar Veterinário</button>
      </form>
    </div>
  </div>

  <script>
    // Função para mostrar o formulário de cadastro correto
    function showForm(formId) {
      const forms = document.querySelectorAll('.form');
      const tabs = document.querySelectorAll('.tab');
      forms.forEach(form => form.classList.remove('active'));
      tabs.forEach(tab => tab.classList.remove('active'));
      document.getElementById(`${formId}-form`).classList.add('active');
      document.querySelector(`.tab[onclick="showForm('${formId}')"]`).classList.add('active');
    }

    // Exibir a mensagem de sucesso com animação
    window.addEventListener('load', function() {
      const successMessageContainer = document.querySelector('.success-message-container');
      if (successMessageContainer) {
        setTimeout(function() {
          successMessageContainer.style.visibility = 'visible';
          successMessageContainer.style.opacity = 1;
        }, 100);
      }

      // Esconder a mensagem de sucesso quando clicar no botão "OK"
      const okButton = document.getElementById('ok-button');
      if (okButton) {
        okButton.addEventListener('click', function() {
          successMessageContainer.style.visibility = 'hidden';
          successMessageContainer.style.opacity = 0;
        });
      }
    });
  </script>
</body>
</html>
