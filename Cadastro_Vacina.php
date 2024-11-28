<?php
session_start();
include('navbar.php'); // Inclui a navbar

// Conexão ao banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "VaxNet";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Verificar se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Capturar dados do formulário
    $nome_vacina = $_POST['nome_vacina'];
    $fabricante = $_POST['fabricante'];
    $data_lancamento = $_POST['data_lancamento'];
    $data_vencimento = $_POST['data_vencimento'];
    $tipo_vacina = $_POST['tipo_vacina'];
    $doses_requeridas = $_POST['doses_requeridas'];
    $intervalo_doses = $_POST['intervalo_doses'];
    $eficacia = $_POST['eficacia'];
    $grupo_etario = $_POST['grupo_etario'];
    $contraindicacoes = $_POST['contraindicacoes'];
    $reacoes_adversas = $_POST['reacoes_adversas'];
    $lote = $_POST['lote'];

    // Query de inserção
    $sql = "INSERT INTO cadastro_vacinas (nome_vacina, fabricante, data_lancamento, data_vencimento, tipo_vacina, doses_requeridas, intervalo_doses, eficacia, grupo_etario, contraindicacoes, reacoes_adversas, lote) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssiidssss", $nome_vacina, $fabricante, $data_lancamento, $data_vencimento, $tipo_vacina, $doses_requeridas, $intervalo_doses, $eficacia, $grupo_etario, $contraindicacoes, $reacoes_adversas, $lote);

    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Vacina cadastrada com sucesso!";
    } else {
        $_SESSION['error_message'] = "Erro ao cadastrar vacina: " . $stmt->error;
    }

    // Fechar a declaração e a conexão
    $stmt->close();
    $conn->close();

    // Redirecionar para evitar reenvio do formulário
    header("Location: Cadastro_Vacina.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Vacinas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        form {
            max-width: 600px;
            margin: auto;
        }
        label {
            display: block;
            margin-top: 10px;
        }
        input, textarea {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        .message {
            text-align: center;
            font-weight: bold;
            color: green;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <h2>Cadastro de Vacinas</h2>
    <?php
    if (isset($_SESSION['success_message'])) {
        echo "<p class='message'>" . $_SESSION['success_message'] . "</p>";
        unset($_SESSION['success_message']);
    }
    if (isset($_SESSION['error_message'])) {
        echo "<p class='message error'>" . $_SESSION['error_message'] . "</p>";
        unset($_SESSION['error_message']);
    }
    ?>
    <form method="POST" action="">
        <label for="nome_vacina">Nome da Vacina:</label>
        <input type="text" id="nome_vacina" name="nome_vacina" required>

        <label for="fabricante">Fabricante:</label>
        <input type="text" id="fabricante" name="fabricante" required>

        <label for="data_lancamento">Data de Lançamento:</label>
        <input type="date" id="data_lancamento" name="data_lancamento" required>

        <label for="data_vencimento">Data de Vencimento:</label>
        <input type="date" id="data_vencimento" name="data_vencimento" required>

        <label for="tipo_vacina">Tipo de Vacina:</label>
        <input type="text" id="tipo_vacina" name="tipo_vacina" required>

        <label for="doses_requeridas">Doses Requeridas:</label>
        <input type="number" id="doses_requeridas" name="doses_requeridas" required>

        <label for="intervalo_doses">Intervalo entre Doses (em dias):</label>
        <input type="number" id="intervalo_doses" name="intervalo_doses" required>

        <label for="eficacia">Eficácia (%):</label>
        <input type="number" step="0.01" id="eficacia" name="eficacia" required>

        <label for="grupo_etario">Grupo Etário:</label>
        <input type="text" id="grupo_etario" name="grupo_etario" required>

        <label for="contraindicacoes">Contraindicações:</label>
        <textarea id="contraindicacoes" name="contraindicacoes" rows="4" required></textarea>

        <label for="reacoes_adversas">Reações Adversas:</label>
        <textarea id="reacoes_adversas" name="reacoes_adversas" rows="4" required></textarea>

        <label for="lote">Lote:</label>
        <input type="text" id="lote" name="lote" required>

        <button type="submit">Cadastrar Vacina</button>
    </form>
<?php include('footer.php');?>
</body>
</html>
