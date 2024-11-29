<?php include('navbar.php'); ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Avisos</title>
  <link rel="stylesheet" href="Aviso.css">
</head>
<body>
    <?php include('navbar.php'); ?>
  <div class="aviso-container">
    <h2>Adicionar Aviso</h2>
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
  </div>

  <?php include('footer.php'); ?>
</body>
</html>
