<?php
session_start();

// Configuração de conexão com o banco de dados
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

$cadastroSucesso = false; // Variável para verificar se o cadastro foi bem-sucedido

// Verificar se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT); // Criptografar a senha

    // Verificar se é um cadastro de usuário ou veterinário
    if ($_POST['tipo'] == 'usuario') {
        // Inserir dados do usuário no banco de dados
        $sql = "INSERT INTO cadastro_usuario (email, senha) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $email, $senha);

        if ($stmt->execute()) {
            $cadastroSucesso = true;
        }
    } elseif ($_POST['tipo'] == 'veterinario') {
        // Inserir dados do veterinário no banco de dados
        $sql = "INSERT INTO cadastro_veterinario (email, senha) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $email, $senha);

        if ($stmt->execute()) {
            $cadastroSucesso = true;
        }
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <style>
        /* Estilos básicos para o modal */
        .modal {
            display: none; /* Inicialmente escondido */
            position: fixed;
            z-index: 9999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Fundo escuro */
            justify-content: center;
            align-items: center;
        }
        .modal-content {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }
        .modal-content h2 {
            color: #28a745; /* Verde */
        }
        .modal-content p {
            margin: 10px 0;
        }
        .modal-content button {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
        .modal-content button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

<?php
// Verificar se o cadastro foi bem-sucedido e exibir o modal
if ($cadastroSucesso) {
    echo '<div id="modal" class="modal">
            <div class="modal-content">
                <h2>✔ Tudo certo!</h2>
                <p>Cadastro realizado com sucesso</p>
                <button id="closeModal">OK</button>
            </div>
          </div>';
}
?>

<script>
    // Exibir o modal ao carregar a página
    window.onload = function() {
        var modal = document.getElementById("modal");
        var closeModalButton = document.getElementById("closeModal");

        if (modal) {
            // Exibir o modal
            modal.style.display = "flex";

            // Botão "OK" fecha o modal e redireciona
            closeModalButton.onclick = function() {
                modal.style.display = "none";
                window.location.href = "Login1.php"; // Redireciona para a página de login
            };
        }
    };
</script>

</body>
</html>
