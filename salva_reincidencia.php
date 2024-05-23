<?php
// Configurações do banco de dados
$servername = "ws4.altcloud.net.br";
$username = "ggnet_nocsz";
$password = "ae7$6bPiLz/gp#iF";
$dbname = "ggnet_nocsz";

// Conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

// Valores recebidos do formulário
$nome = $_POST['nome'];
$protocolo = $_POST['protocolo'];
$data = $_POST['data'];
$dificuldade_resolvida = $_POST['dificuldade'];
$encaminhado_tecnico = $_POST['encaminhado'];

// Verificar se já existe um registro com o mesmo nome
$check_sql = "SELECT * FROM suporte WHERE nome = '$nome'";
$result = $conn->query($check_sql);
if ($result->num_rows > 0) {
    echo "Já existe um registro com o mesmo nome.";
} else {
    // Prepara e executa a inserção dos dados no banco
    $sql = "INSERT INTO suporte (nome, protocolo, data, dificuldade_resolvida, encaminhado_tecnico)
    VALUES ('$nome', '$protocolo', '$data', '$dificuldade_resolvida', '$encaminhado_tecnico')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Dados inseridos com sucesso!";
        // Redirecionar para o formulário após 3 segundos
        header("refresh:3;url=reincidencia.php");
    } else {
        echo "Erro ao inserir dados: " . $sql . "<br>" . $conn->error;
    }
}

// Fecha a conexão com o banco de dados
$conn->close();
?>
