<?php include('navbar.php'); ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home</title>
  <link rel="stylesheet" href="Home.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
  <h1>.</h1>
  <h1>.</h1>
  <h1></h1>
  <!-- Container Principal da Página -->
  <div class="home-container">
    <h2>Bem-vindo, <span id="user-name">
      <?php echo strtoupper($_SESSION['name'] ?? 'David Yehud'); ?>
    </span></h2>
    <!-- Painel de Estatísticas -->
    <div class="stats-panel">
      <div class="stat-card">
        <h3>120</h3>
        <p>Animais</p>
      </div>
      <div class="stat-card">
        <h3>15</h3>
        <p>Vacinas</p>
      </div>
      <div class="stat-card">
        <h3>5</h3>
        <p>Itens Atrasados</p>
      </div>
    </div>

    <!-- Lista de Animais -->
    <div class="animal-list">
      <h3>Lista de Animais</h3>
      <table>
        <thead>
          <tr>
            <th>Nome</th>
            <th>ID</th>
            <th>Situação</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Max</td>
            <td>#001</td>
            <td class="vaccinated">Vacinado</td>
            <td><button class="details-btn" onclick="toggleDetails('details-001')">Ver Mais</button></td>
          </tr>
          <tr class="details-row" id="details-001">
            <td colspan="4">
              <div class="details-content">
                <p><strong>Vacinas:</strong> Raiva, V10, Giárdia</p>
              </div>
            </td>
          </tr>
          <tr>
            <td>Luna</td>
            <td>#002</td>
            <td class="not-vaccinated">Não Vacinado</td>
            <td><button class="details-btn" onclick="toggleDetails('details-002')">Ver Mais</button></td>
          </tr>
          <tr class="details-row" id="details-002">
            <td colspan="4">
              <div class="details-content">
                <p><strong>Vacinas:</strong> Nenhuma</p>
              </div>
            </td>
          </tr>
          <tr>
            <td>Thor</td>
            <td>#003</td>
            <td class="vaccinated">Vacinado</td>
            <td><button class="details-btn" onclick="toggleDetails('details-003')">Ver Mais</button></td>
          </tr>
          <tr class="details-row" id="details-003">
            <td colspan="4">
              <div class="details-content">
                <p><strong>Vacinas:</strong> Raiva, V10</p>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  
  <form action="adicionar_aviso.php" method="POST">
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


  <!-- Rodapé -->
  <?php include('footer.php'); ?>

  <!-- Script para detalhes das vacinas -->
  <script>
    function toggleDetails(id) {
      const detailsRow = document.getElementById(id);
      detailsRow.style.display = detailsRow.style.display === 'table-row' ? 'none' : 'table-row';
    }
  </script>
</body>
</html>
