    <?php
    session_start(); // Inicia a sessão
    include('navbar.php'); 

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
        <form action="Conexão.php" method="POST">
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
          <input type="text" name="observacoes" placeholder="observacoes" required>
          <button type="submit" class="submit-btn">Cadastrar</button>
        </form>
      </div>

      <script>
        // Função para ocultar a mensagem após 3 segundos
        setTimeout(function() {
          const successMessage = document.getElementById('success-message');
          const errorMessage = document.getElementById('error-message');
          if (successMessage) {
            successMessage.style.display = 'none';
          }
          if (errorMessage) {
            errorMessage.style.display = 'none';
          }
        }, 3000); // 3000 milissegundos = 3 segundos
      </script>
    </body>
    </html>
