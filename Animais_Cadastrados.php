<?php
session_start();
include('navbar.php');

// Configuração de conexão ao banco de dados
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

// Consultar os animais cadastrados
$sql = "SELECT * FROM cadastros_animais";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lista de Animais</title>
  <link rel="stylesheet" href="Animais_Cadastrados.css">
  <script>
    let animalSelecionado = null;

    function mostrarDetalhes(animal) {
      animalSelecionado = animal;
      document.getElementById('lista-container').style.display = 'none';
      document.getElementById('detalhes-container').style.display = 'block';

      document.getElementById('detalhes-nome').innerText = animal.nome;
      document.getElementById('detalhes-raca').innerText = animal.raca;
      document.getElementById('detalhes-idade').innerText = animal.idade;
      document.getElementById('detalhes-cor').innerText = animal.cor;
      document.getElementById('detalhes-sexo').innerText = animal.sexo;
      document.getElementById('detalhes-identificacao').innerText = animal.identificacao;
      document.getElementById('detalhes-vacinas').innerText = animal.vacinas;
      document.getElementById('detalhes-data_nascimento').innerText = animal.data_nascimento;
      document.getElementById('detalhes-data_cadastro').innerText = animal.data_cadastro;
      document.getElementById('detalhes-responsavel').innerText = animal.responsavel;
      document.getElementById('detalhes-contato').innerText = animal.contato_responsavel;
      document.getElementById('detalhes-observacoes').innerText = animal.observacoes;
    }

    function voltarLista() {
      document.getElementById('lista-container').style.display = 'block';
      document.getElementById('detalhes-container').style.display = 'none';
      animalSelecionado = null;
    }

    function excluirAnimal() {
        if (animalSelecionado) {
            if (confirm("Tem certeza que deseja excluir este animal?")) {
                window.location.href = "Excluir_Animal.php?id=" + animalSelecionado.id;
            }
        } else {
            alert("Nenhum animal selecionado para exclusão.");
        }
    }
  </script>
</head>
<body>
  <div class="lista-container" id="lista-container">
    <h2>Lista de Animais Cadastrados</h2>
    
    <?php
    if ($result->num_rows > 0) {
        echo "<ul class='animal-list'>";

        while ($row = $result->fetch_assoc()) {
            echo "<li onclick='mostrarDetalhes(" . json_encode($row) . ")'>";
            echo $row["responsavel"] . " - " . $row["nome"];
            echo "</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>Nenhum animal cadastrado.</p>";
    }

    // Fechar a conexão
    $conn->close();
    ?>
  </div>

  <div class="detalhes-container" id="detalhes-container" style="display: none;">
    <h2>Detalhes do Animal</h2>
    <p><strong>Nome:</strong> <span id="detalhes-nome"></span></p>
    <p><strong>Raça:</strong> <span id="detalhes-raca"></span></p>
    <p><strong>Idade:</strong> <span id="detalhes-idade"></span></p>
    <p><strong>Cor:</strong> <span id="detalhes-cor"></span></p>
    <p><strong>Sexo:</strong> <span id="detalhes-sexo"></span></p>
    <p><strong>Identificação:</strong> <span id="detalhes-identificacao"></span></p>
    <p><strong>Vacinas:</strong> <span id="detalhes-vacinas"></span></p>
    <p><strong>Data de Nascimento:</strong> <span id="detalhes-data_nascimento"></span></p>
    <p><strong>Data de Cadastro:</strong> <span id="detalhes-data_cadastro"></span></p>
    <p><strong>Responsável:</strong> <span id="detalhes-responsavel"></span></p>
    <p><strong>Contato:</strong> <span id="detalhes-contato"></span></p>
    <p><strong>Observações:</strong> <span id="detalhes-observacoes"></span></p>
    
    <button onclick="voltarLista()">Voltar à Lista</button>
    <button onclick="excluirAnimal()">Excluir Animal</button>
  </div>
</body>
</html>
