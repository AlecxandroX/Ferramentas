<?php
// Informações de conexão ao banco de dados
$server = 'ws4.altcloud.net.br';
$usuario = 'ggnet_nocsz';
$senha = 'ae7$6bPiLz/gp#iF';
$base = 'ggnet_nocsz';

// Conecte ao banco de dados
$mysqli = new mysqli($server, $usuario, $senha, $base);

// Verifique a conexão
if ($mysqli->connect_error) {
    die('Erro na conexão com o banco de dados: ' . $mysqli->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $topic = $_POST["topic"];

    // Verifique se o diretório de upload existe, crie-o se não existir
    $upload_dir = "uploads/";
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $target_file = $upload_dir . basename($_FILES["pdf"]["name"]);

    if (move_uploaded_file($_FILES["pdf"]["tmp_name"], $target_file)) {
        // O arquivo foi carregado com sucesso
        $pdf_name = basename($_FILES["pdf"]["name"]);

        // Use mysqli_real_escape_string para evitar SQL injection
        $filename = $mysqli->real_escape_string($_POST["filename"]);

        // Insira os dados na tabela do banco de dados
        $sql = "INSERT INTO pdf_files (topic, filename, pdf_name) VALUES ('$topic', '$filename', '$pdf_name')";

        if ($mysqli->query($sql) === true) {
            echo "Upload do PDF e inserção no banco de dados bem-sucedidos!<br>";
        } else {
            echo "Erro na inserção no banco de dados: " . $mysqli->error;
        }
    } else {
        echo "Ocorreu um erro ao enviar o arquivo.";
    }

    // Feche a conexão com o banco de dados
    $mysqli->close();
}
?>
