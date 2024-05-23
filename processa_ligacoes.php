<?php
// Dados de conexão com o banco de dados
$server = 'ws4.altcloud.net.br';
$usuario = 'ggnet_nocsz';
$senha = 'ae7$6bPiLz/gp#iF';
$base = 'ggnet_nocsz';

try {
    // Cria uma conexão com o banco de dados MySQL usando PDO
    $pdo = new PDO("mysql:host=$server;dbname=$base", $usuario, $senha);
    
    // Configura o PDO para lançar exceções em caso de erros
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Verifica se o formulário foi enviado
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Recupera os valores dos campos do formulário
        $campo1 = $_POST["campo1"];
        $campo2 = $_POST["campo2"];
        $campo3 = $_POST["campo3"];
        $campo4 = $_POST["campo4"];
        $campo5 = $_POST["campo5"];
        $data_hora = $_POST["data_hora"];

        // Prepara uma instrução SQL para inserir os dados na tabela do banco de dados
        $sql = "INSERT INTO formulario (campo1, campo2, campo3, campo4, campo5, data_hora) VALUES (:campo1, :campo2, :campo3, :campo4, :campo5, :data_hora)";
        $stmt = $pdo->prepare($sql);

        // Executa a instrução SQL com os valores dos campos do formulário
        $stmt->execute([
            ':campo1' => $campo1,
            ':campo2' => $campo2,
            ':campo3' => $campo3,
            ':campo4' => $campo4,
            ':campo5' => $campo5,
            ':data_hora' => $data_hora
        ]);

        // Redireciona para uma página de sucesso ou faz alguma outra ação
        echo "Formulário enviado com sucesso!";
    } else {
        echo "O formulário não foi enviado corretamente.";
    }
} catch (PDOException $e) {
    // Em caso de erro na conexão ou execução da consulta SQL, exibe uma mensagem de erro
    echo "Erro de conexão com o banco de dados: " . $e->getMessage();
}
?>
