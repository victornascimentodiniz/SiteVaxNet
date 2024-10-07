<?php include('navbar.php'); ?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cadastro de Vacinas</title>
  <link rel="stylesheet" href="Cadastro_Animais.css">
</head>
<body>

  <div class="cadastro-container">
    <h2>Cadastro de Vacinas</h2>
    <form action="cadastros_animais" method="POST">
    <input type="text" name="nome" placeholder="Nome do Animal" required>
    <input type="text" name="raca" placeholder="Raça" required>
    <input type="number" name="idade" placeholder="Idade" required>
    <input type="date" name="data_nascimento" required>
    <input type="text" name="cor" placeholder="Cor" required>
    <input type="text" name="sexo" placeholder="Sexo" required>
    <input type="text" name="vacinas" placeholder="Vacinas" required>
    <input type="date" name="data_cadastro" required>
    <input type="text" name="responsavel" placeholder="Responsável" required>
    <input type="text" name="contato_responsavel" placeholder="Contato do Responsável" required>
    <button type="submit">Cadastrar</button>
</form>

  </div>

</body>
</html>
