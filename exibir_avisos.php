<?php
// Conexão com o banco de dados
$host = 'localhost';
$username = 'root'; // Substitua pelo seu usuário
$password = 'root'; // Substitua pela sua senha
$dbname = 'Vaxnet'; // Substitua pelo nome do seu banco de dados

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}


// Selecionando os avisos ativos
$sql = "SELECT * FROM avisos WHERE ativo = 1 AND data_evento >= NOW() ORDER BY data_evento ASC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<div>";
        echo "<h3>" . $row['titulo'] . "</h3>";
        echo "<p><strong>Responsável:</strong> " . $row['responsavel'] . "</p>";
        echo "<p><strong>Data e Hora:</strong> " . $row['data_evento'] . "</p>";
        echo "<p>" . $row['descricao'] . "</p>";
        echo "</div>";
    }
} else {
    echo "Não há avisos ativos no momento.";
}

$conn->close();
?>
