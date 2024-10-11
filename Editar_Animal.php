<?php
session_start();
include('navbar.php');

// Conexão ao banco de dados
$servername = "localhost";
$username = "root";  
$password = "";      
$dbname = "VaxNet";  

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

$id_animal = $_GET['id'];
$sql = "SELECT * FROM cadastros_animais WHERE id_animal = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_animal);
$stmt->execute();
$result = $stmt->get_result();
$animal = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Animal</title>
    <link rel="stylesheet" href="Editar_Animal.css"> <!-- Inclua o CSS -->
</head>
<body>
    <div class="container"> <!-- Adicione esta div -->
        <h2>Editar Cadastro do Animal</h2>
        <form action="Atualizar_Animal.php" method="POST">
            <input type="hidden" name="id_animal" value="<?php echo $animal['id_animal']; ?>">

            <label>Nome:</label>
            <input type="text" name="nome" value="<?php echo $animal['nome']; ?>" required>

            <label>Raça:</label>
            <input type="text" name="raca" value="<?php echo $animal['raca']; ?>" required>

            <label>Idade:</label>
            <input type="number" name="idade" value="<?php echo $animal['idade']; ?>" required>

            <label>Cor:</label>
            <input type="text" name="cor" value="<?php echo $animal['cor']; ?>" required>

            <label>Sexo:</label>
            <select name="sexo" required>
                <option value="M" <?php echo $animal['sexo'] == 'M' ? 'selected' : ''; ?>>Macho</option>
                <option value="F" <?php echo $animal['sexo'] == 'F' ? 'selected' : ''; ?>>Fêmea</option>
            </select>

            <label>Identificação:</label>
            <input type="text" name="identificacao" value="<?php echo $animal['identificacao']; ?>" required>

            <label>Vacinas:</label>
            <input type="text" name="vacinas" value="<?php echo $animal['vacinas']; ?>" required>

            <label>Data de Nascimento:</label>
            <input type="date" name="data_nascimento" value="<?php echo $animal['data_nascimento']; ?>" required>

            <label>Observações:</label>
            <textarea name="observacoes"><?php echo $animal['observacoes']; ?></textarea>

            <label>Responsável:</label>
            <input type="text" name="responsavel" value="<?php echo $animal['responsavel']; ?>" required>

            <label>Contato do Responsável:</label>
            <input type="text" name="contato_responsavel" value="<?php echo $animal['contato_responsavel']; ?>" required>

            <button type="submit">Salvar Alterações</button>
        </form>
    </div>
</body>
</html>
