<?php
// Inicie ou retome a sessão
session_start();

// Verifique se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Conecte-se ao banco de dados (substitua com suas credenciais)
    $servername = "ws4.altcloud.net.br";
    $username = "ggnet_nocsz";
    $password = "ae7$6bPiLz/gp#iF";
    $dbname = "ggnet_nocsz";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verifique a conexão com o banco de dados
    if ($conn->connect_error) {
        die("Falha na conexão com o banco de dados: " . $conn->connect_error);
    }

    // Obtenha os valores dos campos do formulário
    $protocolo_noc = $_POST["protocolo_noc"];
    $dataHora_noc = $_POST["dataHora_noc"];
    $nome_usuario = $_SESSION['usuario']; // Use o valor da variável de sessão

    // Insira os dados na tabela "agendamentos_noc" incluindo o nome do usuário
    $sql = "INSERT INTO agendamentos_noc (dataHora_noc, protocolo_noc, nome_usuario) VALUES ('$dataHora_noc', '$protocolo_noc', '$nome_usuario')";

    if ($conn->query($sql) === TRUE) {
        header('Location: agendado_noc_suporte.php');
    } else {
        echo '<div style="background-color: black; color: #f44336; text-align: center; padding: 10px;">Erro ao agendar: ' . $conn->error . '</div>';
    }

    // Restante do seu código...

    // Feche a conexão com o banco de dados
    $conn->close();
}
?>
