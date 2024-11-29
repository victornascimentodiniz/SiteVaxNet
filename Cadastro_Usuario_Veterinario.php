<?php
session_start();

// Configuração de conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "VaxNet";

// Criar conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Inicializar variáveis de controle
$cadastroSucesso = false;

// Verificar se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capturar os dados enviados pelo formulário
    $tipo = $_POST['tipo']; // Define se é usuário ou veterinário
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT); // Criptografar a senha
    $telefone = $_POST['telefone'];
    $endereco = $_POST['endereco'];

    if ($tipo === 'usuario') {
        // Dados adicionais para usuários
        $dataNascimento = $_POST['data_nascimento'] ?? null; // Campo opcional
        $dataCriacao = date("Y-m-d H:i:s");
        $dataAtualizacao = $dataCriacao;

        // SQL para inserir o cadastro de usuário
        $sql = "INSERT INTO cadastro_usuario (nome, email, senha, telefone, data_nascimento, endereco, data_criacao, data_atualizacao) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssss", $nome, $email, $senha, $telefone, $dataNascimento, $endereco, $dataCriacao, $dataAtualizacao);
    } elseif ($tipo === 'veterinario') {
        // Dados adicionais para veterinários
        $crmv = $_POST['crmv'];
        $especializacao = $_POST['especializacao'];
        $status = $_POST['status'];

        // SQL para inserir o cadastro de veterinário
        $sql = "INSERT INTO cadastro_veterinario (nome, email, senha, telefone, endereco, crmv, especialidade, status) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssss", $nome, $email, $senha, $telefone, $endereco, $crmv, $especializacao, $status);
    }

    // Executar a consulta preparada
    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Cadastro realizado com sucesso!";
        $cadastroSucesso = true;
    } else {
        $_SESSION['error_message'] = "Erro ao cadastrar: " . $stmt->error;
    }

    // Fechar a declaração
    $stmt->close();
}

// Fechar a conexão
$conn->close();

// Redirecionar para a tela de login após o cadastro bem-sucedido
if ($cadastroSucesso) {
    header("Location: Login1.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 9999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
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
            color: #28a745;
        }
        .modal-content button {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<?php
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
    window.onload = function() {
        const modal = document.getElementById("modal");
        const closeModalButton = document.getElementById("closeModal");

        if (modal) {
            modal.style.display = "flex";
            closeModalButton.onclick = function() {
                modal.style.display = "none";
                window.location.href = "Login1.php";
            };
        }
    };
</script>
<?php include('footer.php'); ?>
</body>
</html>
