<?php

//Script utilizado somente para faser conexao com o banco

$server = 'ws4.altcloud.net.br';
$usuario = 'ggnet_nocsz';
$senha = 'ae7$6bPiLz/gp#iF';
$base = 'ggnet_nocsz';

$conexao = mysqli_connect($server,$usuario,$senha,$base);

if($conexao -> error) {
    die("Falha ao conectar ao banco de dados: " . $conexao -> error);
}

?>