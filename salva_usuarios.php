<?php
// Conecte-se ao banco de dados MySQL
$servername = "ws4.altcloud.net.br";
$username = "ggnet_nocsz";
$password = "ae7$6bPiLz/gp#iF";
$dbname = "ggnet_nocsz";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verifique a conexão
if ($conn->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}

// Receba os dados do formulário
$username = $_POST['username'];
$password = $_POST['password'];

// Execute a consulta SQL para inserir os dados na tabela de usuários
$sql = "INSERT INTO usuarios (username, password) VALUES ('$username', '$password')";

if ($conn->query($sql) === TRUE) {
    echo "Cadastro bem-sucedido!";
} else {
    echo "Erro ao cadastrar o usuário: " . $conn->error;
}

// Feche a conexão com o banco de dados
$conn->close();
?>