<?php include('navbar.php'); ?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home</title>
  <link rel="stylesheet" href="Home.css">
</head>
<body>
  <div class="home-container">
    <h2>Bem-vindo, <span id="user-name">Usuário</span></h2>
    <!-- Substituir 'Usuário' por uma variável PHP que exiba o nome do usuário logado -->
    
    <!-- Painel de Estatísticas -->
    <div class="stats-panel">
      <div class="stat-card">
        <h3>120</h3> <!-- Pegar dado do banco de quantos animais o usuario tem-->
        <p>Animais</p>
      </div>
      <div class="stat-card">
        <h3>15</h3> <!-- Pegar dado do banco de quantas vacinas ele faz uso no seus animais-->
        <p>Vacinas</p>
      </div>
<!--Não sei que informação colocar nesse card, fica a seu criterio. Se tirar ele bagunca a tela home-->
      <div class="stat-card">
        <h3>5</h3> <!-- Pegar dado do banco -->
        <p>Itens Atrasados</p>
      </div>
    </div>

    <!-- Lista de Animais -->
    <!--Essa lista pode ser reduzida a uma função, com uma conexão com banco para deixar mais dinamico,
    trazendo os dados do animal e qual vacina ele tomou-->
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

<!--Essa parte do codigo faz com as vacinas aplicadas nos animais so aparecam ao clicar no botao "ver mais"-->
  <script>
    function toggleDetails(id) {
      const detailsRow = document.getElementById(id);
      detailsRow.style.display = detailsRow.style.display === 'table-row' ? 'none' : 'table-row';
    }
  </script>
</body>
</html>
