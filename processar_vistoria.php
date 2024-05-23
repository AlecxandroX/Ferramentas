<?php
// Dados de conexão com o banco de dados
$server = 'ws4.altcloud.net.br';
$usuario = 'ggnet_nocsz';
$senha = 'ae7$6bPiLz/gp#iF';
$base = 'ggnet_nocsz';

// Conexão com o banco de dados
$conn = new mysqli($server, $usuario, $senha, $base);

// Verifique a conexão
if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

// Dados do formulário
$data = $_POST["data"];
$protocolo = $_POST["protocolo"];
$os = $_POST["os"];
$tecnico = $_POST["tecnico"];
$cidade = $_POST["cidade"];
$qualidade = $_POST["qualidade"];
$fotos_anexadas = $_POST["fotos_anexadas"];
$dificuldade_resolvida = $_POST["dificuldade_resolvida"];
$assinatura_os = $_POST["assinatura_os"];
$configuracoes_ok = $_POST["configuracoes_ok"];
$observacao = $_POST["observacao"];
$atendimento_concluido = $_POST["atendimento_concluido"];

// Inserir os dados no banco de dados
$sql = "INSERT INTO atendimento_tecnico (data, protocolo, os, tecnico, cidade, qualidade, fotos_anexadas, dificuldade_resolvida, assinatura_os, configuracoes_ok, observacao, atendimento_concluido)
VALUES ('$data', '$protocolo', '$os', '$tecnico', '$cidade', '$qualidade', '$fotos_anexadas', '$dificuldade_resolvida', '$assinatura_os', '$configuracoes_ok', '$observacao', '$atendimento_concluido')";

if ($conn->query($sql) === TRUE) {
    header("Location: vistorias.php");
} else {
    echo "Erro ao inserir dados: " . $conn->error;
}

// Feche a conexão com o banco de dados
$conn->close();
?>
