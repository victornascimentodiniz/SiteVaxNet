<?php
session_start();
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

// Receber o ID do animal a ser excluído
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Certifique-se de que o ID seja um inteiro

    // Preparar a consulta
    $stmt = $conn->prepare("DELETE FROM cadastros_animais WHERE id = ?");
    if ($stmt) {
        // Vincular o parâmetro
        $stmt->bind_param("i", $id);
        
        // Executar a consulta
        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                $_SESSION['success_message'] = "Animal excluído com sucesso!";
            } else {
                $_SESSION['error_message'] = "Nenhum animal encontrado com o ID especificado.";
            }
        } else {
            $_SESSION['error_message'] = "Erro ao excluir o animal: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $_SESSION['error_message'] = "Erro ao preparar a consulta: " . $conn->error;
    }
} else {
    $_SESSION['error_message'] = "ID do animal não fornecido.";
}

// Fechar a conexão
$conn->close();

// Redirecionar de volta para a lista de animais
header('Location: Animais_Cadastrados.php');
exit();
?>
