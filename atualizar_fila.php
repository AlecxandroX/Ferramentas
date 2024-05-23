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

// Função para obter a lista de clientes na fila
function obterFila($conexao) {
    $sql = "SELECT nome_cliente FROM fila ORDER BY data_hora_entrada";
    $resultado = mysqli_query($conexao, $sql);

    $fila = array();

    while ($row = mysqli_fetch_assoc($resultado)) {
        $fila[] = $row['nome_cliente'];
    }

    return $fila;
}

// Obtém a lista de clientes na fila
$listaFila = obterFila($conexao);

// Gere a lista HTML
echo '<ul class="list-group mt-2">';
$clienteDaVez = current($listaFila);
foreach ($listaFila as $cliente) {
    $classeCSS = ($cliente == $clienteDaVez) ? 'list-group-item list-group-item-warning' : 'list-group-item';
    echo "<li class='$classeCSS'>$cliente</li>";
}
echo '</ul>';

// Fecha a conexão com o banco de dados
mysqli_close($conexao);
?>
