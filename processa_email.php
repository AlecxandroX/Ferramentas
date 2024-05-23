<?php
// Inclui o arquivo de conexão com o banco de dados
include('conexao.php');

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtém os valores dos campos do formulário
    $codigo_cliente = mysqli_real_escape_string($conexao, $_POST['campo1']);
    $email = mysqli_real_escape_string($conexao, $_POST['campo2']);
    $contato = mysqli_real_escape_string($conexao, $_POST['campo3']);
    $posicao = mysqli_real_escape_string($conexao, $_POST['campo4']);

    // Prepara a consulta SQL para inserir os dados na tabela do banco de dados
    $sql = "INSERT INTO atualiza_email (codigo_cliente, email, contato, posicao) VALUES ('$codigo_cliente', '$email', '$contato', '$posicao')";

    // Executa a consulta
    if (mysqli_query($conexao, $sql)) {
        echo 'Dados inseridos com sucesso.';
    } else {
        echo 'Erro ao inserir os dados: ' . mysqli_error($conexao);
    }
}

// Fecha a conexão com o banco de dados
mysqli_close($conexao);
?>
