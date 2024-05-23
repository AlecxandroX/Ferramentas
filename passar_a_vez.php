<?php
// Conecte-se ao banco de dados
$server = 'ws4.altcloud.net.br';
$usuario = 'ggnet_nocsz';
$senha = 'ae7$6bPiLz/gp#iF';
$base = 'ggnet_nocsz';

$conexao = mysqli_connect($server, $usuario, $senha, $base);

if (!$conexao) {
    die("Erro na conexão com o banco de dados: " . mysqli_connect_error());
}

// Função para passar a vez para o próximo cliente na fila
function passarAVez($conexao) {
    $sql = "SELECT nome_cliente FROM fila ORDER BY data_hora_entrada LIMIT 1";
    $resultado = mysqli_query($conexao, $sql);

    if ($row = mysqli_fetch_assoc($resultado)) {
        $nome_cliente = $row['nome_cliente'];
        $sql = "DELETE FROM fila WHERE nome_cliente = '$nome_cliente'";
        if (mysqli_query($conexao, $sql)) {
            $sql = "INSERT INTO fila (nome_cliente) VALUES ('$nome_cliente')";
            if (mysqli_query($conexao, $sql)) {
                return 'success';
            }
        }
    }
    return 'error';
}

// Chame a função para passar a vez
$resultado = passarAVez($conexao);

// Fecha a conexão com o banco de dados
mysqli_close($conexao);

echo $resultado;
?>
