<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Permissões</title>
</head>
<body>

<?php
// Simulando a conexão com o banco de dados (substitua isso pela sua lógica real de conexão)
$host = "ws4.altcloud.net.br";
$usuario = "ggnet_nocsz";
$senha = "ae7$6bPiLz/gp#iF";
$banco = "ggnet_nocsz";

$conn = new mysqli($host, $usuario, $senha, $banco);

// Verifica a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Simulando a obtenção da permissão do usuário a partir do banco de dados (substitua isso pela lógica real)
$usuarioID = 1; // ID do usuário logado
$query = "SELECT permissao FROM usuarios WHERE id = $usuarioID";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $permissaoUsuario = $row['permissao'];
} else {
    // Caso o usuário não seja encontrado, você pode lidar com isso de acordo com sua lógica
    $permissaoUsuario = 'convidado';
}

// Defina os links com diferentes níveis de permissão
$links = array(
    'link1' => array('href' => 'link1.php', 'permissao' => 'admin'),
    'link2' => array('href' => 'link2.php', 'permissao' => 'editor'),
    'link3' => array('href' => 'link3.php', 'permissao' => 'leitor'),
);

// Exibir os links com base nas permissões do usuário
foreach ($links as $nomeLink => $link) {
    if ($permissaoUsuario === $link['permissao'] || $permissaoUsuario === 'admin') {
        echo '<a href="' . $link['href'] . '">' . $nomeLink . '</a><br>';
    }
}

// Fechar a conexão com o banco de dados
$conn->close();
?>

</body>
</html>
