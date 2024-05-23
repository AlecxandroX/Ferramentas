<?php
// Inicie ou retome a sessão
session_start();

// Verifique se o usuário está autenticado antes de permitir o acesso ao formulário
if (!isset($_SESSION['usuario'])) {
    // Redirecione ou tome outra ação, se necessário
    header("Location: index.php"); // Substitua "login.php" pelo caminho da sua página de login
    exit();
}

// Conexão com o banco de dados (substitua as informações do banco de dados conforme necessário)
$servername = "ws4.altcloud.net.br";
$username = "ggnet_nocsz";
$password = "ae7$6bPiLz/gp#iF";
$dbname = "ggnet_nocsz";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verifique a conexão
if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

// Processamento do formulário
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize e validar os dados conforme necessário
    $usuario = $_SESSION['usuario'];
    $nome = mysqli_real_escape_string($conn, $_POST['nome']); // Adicione esta linha para obter o campo nome
    $protocolo = mysqli_real_escape_string($conn, $_POST['protocolo']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $data = mysqli_real_escape_string($conn, $_POST['data']); // Novo campo de data

    // Incluir automaticamente "N1" em uma coluna separada
    $n1 = "Atendimento-Digital";

    // Preparar e executar a consulta SQL usando Prepared Statements
    $stmt = $conn->prepare("INSERT INTO resolutividade (usuario, nome, protocolo, status, coluna_n1, data) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $usuario, $nome, $protocolo, $status, $n1, $data);

    if ($stmt->execute()) {
        echo "Registro inserido com sucesso.";
        
        // Redirecione após a inserção para evitar reenvio do formulário ao recarregar a página
        header("Location: ".$_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "Erro ao inserir registro: " . $stmt->error;
    }

    // Feche a declaração preparada
    $stmt->close();
}

// Feche a conexão com o banco de dados
$conn->close();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resolutividade NOC</title>
    <link rel="icon" href="data:image/png;base64,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" type="image/x-icon">
    <style>
    body {
    font-family: 'Roboto', sans-serif;
    background-color: #282c35;
    color: #fff;
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100vh;
}

.logo {
    margin-top: 20px; /* Adicione um espaço superior à imagem */
}

.logo img {
    width: 100%; /* Garanta que a imagem ocupe 100% da largura do contêiner */
    max-width: 400px; /* Defina uma largura máxima para a imagem */
    height: auto; /* Permita a altura ajustável para manter a proporção da imagem */
    display: block; /* Remova qualquer espaçamento adicional ao redor da imagem */
    margin: 0 auto; /* Centralize a imagem horizontalmente */
}

form {
    width: 100%;
    max-width: 600px;
    padding: 20px;
    background-color: #2c3e50;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
}

h2 {
    color: #3498db;
}

label {
    display: block;
    margin-bottom: 8px;
    color: #3498db;
}

input[type="text"],
input[type="date"],
select {
    width: calc(100% - 20px);
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #34495e;
    border-radius: 4px;
    background-color: #2c3e50;
    color: #ecf0f1;
    box-sizing: border-box;
}

select {
    appearance: none;
    background-color: #2c3e50;
}

button {
    width: 100%;
    background-color: #3498db;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s ease;
}

button:hover {
    background-color: #2980b9;
}
.logout-button {
    background-color: #FF0000; /* Cor de fundo do botão (substitua pela cor desejada) */
    color: #FFFFFF; /* Cor do texto do botão (substitua pela cor desejada) */
    padding: 10px 20px;
    border: 1px solid #FF0000; /* Cor da borda (substitua pela cor desejada) */
    border-radius: 5px;
    font-weight: bold;
    text-align: center;
}

.logout-button:hover {
    background-color: #FF3333; /* Cor de fundo do botão ao passar o mouse (substitua pela cor desejada) */
    border: 1px solid #FF3333; /* Cor da borda ao passar o mouse (substitua pela cor desejada) */
}
#user-info {
    position: absolute;
    top: 10px; /* Distância do topo */
    right: 10px; /* Distância da direita */
    display: flex;
    align-items: center;

}
    </style>
</head>
<body>
<div id="user-info">
    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512">
        <!-- Seu código SVG -->
    </svg>
    <span style="width: 10px;"></span>
    <h6><?= $_SESSION['usuario']; ?></h6>
    <a href="logout.php" class="logout-button">Sair</a>
</div>
<div class="logo">
          <img class="responsive-img" src="https://s3.amazonaws.com/mktzap-media-storage-master/whitelabel/companies/logo_login/7ae26d275da4474d90ad043a6ab4ca046d87af48" alt="Logomarca">
        </div>
        <br>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <h2>Resolutividade Digital</h2>
        <label for="nome">Nome:</label>
        <input type="text" name="nome" required> <!-- Adicione esta linha para o campo nome -->
        <label for="protocolo">Protocolo:</label>
        <input type="text" name="protocolo" required>
        
        <label for="status">Status:</label>
        <select name="status" required>
            <option value="Resolvido Remotamente">Resolvido Remotamente</option>
            <option value="Encaminhamento Tecnico">Encaminhado Técnico</option>
            <option value="Transferido De Setor">Encaminhado Para Outro Setor</option>
            <option value="Encerrado, inatividade do cliente">Cliente Parou Responder/Não Atende Telefone.</option>
        </select>

        <!-- Novo campo de data -->
        <label for="data">Data:</label>
        <input type="date" name="data" required>
        
        <button type="submit">Enviar</button>
    </form>
</body>
</html>

