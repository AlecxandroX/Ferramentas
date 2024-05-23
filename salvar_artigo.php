<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Conexão com o banco de dados
    $server = 'ws4.altcloud.net.br';
    $usuario = 'ggnet_nocsz';
    $senha = 'ae7$6bPiLz/gp#iF';
    $base = 'ggnet_nocsz';

    $conn = new mysqli($server, $usuario, $senha, $base);

    // Verificar conexão
    if ($conn->connect_error) {
        die("Falha na conexão: " . $conn->connect_error);
    }

    // Receber dados do formulário
    $titulo = $_POST["titulo"];
    $conteudo = $_POST["conteudo"];

    // Preparar e executar a inserção no banco de dados
    $stmt = $conn->prepare("INSERT INTO artigos (titulo, conteudo, data_publicacao) VALUES (?, ?, NOW())");
    $stmt->bind_param("ss", $titulo, $conteudo);

    if ($stmt->execute()) {
        echo "Artigo salvo com sucesso!";
    } else {
        echo "Erro ao salvar o artigo: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
