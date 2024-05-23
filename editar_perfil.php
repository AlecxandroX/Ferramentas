<?php
// Inicie a sessão
session_start();

// Configuração do banco de dados
$server = 'ws4.altcloud.net.br';
$usuario = 'ggnet_nocsz';
$senha = 'ae7$6bPiLz/gp#iF';
$base = 'ggnet_nocsz';

// Conexão com o banco de dados
$conn = new mysqli($server, $usuario, $senha, $base);

// Verifica a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Verifica se o usuário está logado
if (!isset($_SESSION['id_usuario'])) {
    die("Usuário não está logado. Redirecionando para a página de login...");
    // Pode redirecionar para a página de login ou realizar outras ações apropriadas.
}

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['foto'])) {
    // Diretório para salvar as fotos (certifique-se de que o diretório tem permissões de escrita)
    $diretorio_destino = 'uploads/';

    // Id do usuário logado
    $id_usuario = $_SESSION['id_usuario'];

    // Gera um nome único para a foto usando o nome do usuário logado
    $nome_foto = $id_usuario . '_foto.' . pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);

    // Move a foto para o diretório de destino
    move_uploaded_file($_FILES['foto']['tmp_name'], $diretorio_destino . $nome_foto);

    // Insere no banco de dados associando a foto ao usuário logado
    $sql = "UPDATE usuarios SET foto = '$nome_foto' WHERE id = $id_usuario";
    if ($conn->query($sql) === TRUE) {
        echo "Foto salva com sucesso para o usuário logado.";
    } else {
        echo "Erro ao salvar a foto no banco de dados: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário de Upload de Foto</title>
    <style>
        body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

form {
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    width: 300px;
}

h2 {
    text-align: center;
    color: #333;
}

label {
    display: block;
    margin-bottom: 8px;
    color: #555;
}

input[type="file"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 16px;
    border: 1px solid #ddd;
    border-radius: 4px;
}

input[type="submit"] {
    background-color: #4caf50;
    color: #fff;
    padding: 10px 15px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

input[type="submit"]:hover {
    background-color: #45a049;
}

    </style>
</head>
<body>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="foto">Escolha uma foto:</label>
        <input type="file" name="foto" id="foto" accept="image/*" required>
        <br>
        <input type="submit" value="Enviar Foto">
    </form>

</body>
</html>
