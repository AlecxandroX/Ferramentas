
<?php
      include 'protect.php'; //Include utilizado para não deixar o usuário entrar nas páginas sem utilizar o login

?>
<?php
// Configurações do banco de dados
$host = 'ws4.altcloud.net.br';
$dbname = 'ggnet_nocsz';
$user = 'ggnet_nocsz';
$pass = 'ae7$6bPiLz/gp#iF';

// Conectar ao banco de dados usando PDO
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão com o banco de dados: " . $e->getMessage());
}

// Consulta SQL para obter todos os dados da tabela resolutividade
$sql = "SELECT * FROM resolutividade";

// Adicionar filtros de data se o formulário for enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    // Verificar se as datas foram fornecidas
    if (!empty($start_date) && !empty($end_date)) {
        // Adicionar condição WHERE para filtrar por datas
        $sql .= " WHERE data BETWEEN :start_date AND :end_date";
    }
}

// Preparar e executar a consulta SQL
$stmt = $pdo->prepare($sql);

// Se as datas foram fornecidas, vincular os parâmetros
if (!empty($start_date) && !empty($end_date)) {
    $stmt->bindParam(':start_date', $start_date, PDO::PARAM_STR);
    $stmt->bindParam(':end_date', $end_date, PDO::PARAM_STR);
}

$stmt->execute();

// Obter os resultados
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exibição de Dados - Resolutividade</title>
    <style>
       body {
    font-family: Arial, sans-serif;
    background-color: #f9f9f9;
    margin: 0;
    padding: 0;
}

.container {
    max-width: 800px;
    margin: 50px auto;
    background-color: #ffffff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

form {
    margin-bottom: 20px;
}

label {
    display: block;
    margin-bottom: 5px;
}

input {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    box-sizing: border-box;
    border: 1px solid #ccc;
    border-radius: 4px;
}

button {
    background-color: #007bff;
    color: #fff;
    padding: 12px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

button:hover {
    background-color: #0056b3;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

th, td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
}

th {
    background-color: #007bff;
    color: #fff;
}

.meu-botao {
    background-color: #007BFF;
    color: #ffffff;
    border-radius: 5px;
    padding: 8px 15px; /* Reduzindo o tamanho do botão */
    text-decoration: none;
    display: inline-block;
    font-size: 14px; /* Reduzindo o tamanho da fonte */
    border: none;
}

.meu-botao:hover {
    background-color: #0056b3;
}
#user-info {
    background-color: #f8f9fa;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    text-align: center;
}

#user-info h2 {
    color: #495057;
    margin-bottom: 10px;
}

#user-info span.username {
    display: block;
    color: #007bff;
    font-weight: bold;
    font-size: 18px;
    margin-bottom: 20px;
}

#user-info a.logout-button {
    display: inline-block;
    padding: 12px 24px;
    background-color: #dc3545;
    color: #fff;
    text-decoration: none;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

#user-info a.logout-button:hover {
    background-color: #c82333;
}


    </style>
</head>
<body>
<?php
// Inicie ou retome a sessão
session_start();

// Verifique se o usuário está logado
if (isset($_SESSION['usuario_id'])) {
    $usuario_id = $_SESSION['usuario_id'];

    // Consulta SQL para buscar o nome do usuário pelo ID
    $sql = "SELECT nome FROM usuarios WHERE id = $usuario_id";

    // Execute a consulta
    $result = $conn->query($sql);

    // Verifique se a consulta foi bem-sucedida
    if ($result->num_rows > 0) {
        // Extrai os dados do resultado
        $row = $result->fetch_assoc();
        $nomeUsuario = $row['nome'];

        // Exibe o nome do usuário no topo da página
        echo '<div id="user">Usuário logado: ' . $nomeUsuario . '</div>';
    }
}
?>
<div id="user-info">
    <h2>Olá, Seja Bem Vindo</h2>
    <?= $_SESSION['usuario']; ?> 

   

    <a href="logout.php" class="logout-button">Sair</a>
</div>
    <div class="container">
        <H1>Relatorio Resolutividade</H1>
        <form method="post">
            <label for="start_date">Data Inicial:</label>
            <input type="date" id="start_date" name="start_date" value="<?= isset($start_date) ? $start_date : '' ?>" required>
            
            <label for="end_date">Data Final:</label>
            <input type="date" id="end_date" name="end_date" value="<?= isset($end_date) ? $end_date : '' ?>" required>
            
            <button type="submit">Filtrar</button>
            <a href="graficos_resolutividade.php" class="btn meu-botao">Graficos Resolutividade</a>
            <button onclick="exportToExcel()">Exportar para Excel</button>

        </form>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuário</th>
                    <th>Nome</th>
                    <th>Protocolo</th>
                    <th>Status</th>
                    <th>Setor</th>
                    <th>Data</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $row) : ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['usuario'] ?></td>
                        <td><?= $row['nome'] ?></td>
                        <td><?= $row['protocolo'] ?></td>
                        <td><?= $row['status'] ?></td>
                        <td><?= $row['coluna_n1'] ?></td>
                        <td><?= $row['data'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <script>
function exportToExcel() {
    // Obtenha a tabela e seus dados
    var table = document.querySelector('table');
    var rows = table.querySelectorAll('tbody tr');

    // Crie uma string para armazenar os dados do Excel
    var csvContent = "data:text/csv;charset=utf-8,";

    // Adicione os cabeçalhos da tabela ao CSV
    var headers = Array.from(rows[0].querySelectorAll('td, th')).map(cell => cell.innerText);
    csvContent += headers.join(',') + "\n";

    // Adicione as linhas da tabela ao CSV
    rows.forEach(row => {
        var rowData = Array.from(row.querySelectorAll('td, th')).map(cell => cell.innerText);
        csvContent += rowData.join(',') + "\n";
    });

    // Crie um objeto de dados para o arquivo Excel
    var blob = new Blob([csvContent], { type: 'data:text/csv;charset=utf-8;' });

    // Crie um link para download do arquivo Excel
    var link = document.createElement("a");
    link.href = window.URL.createObjectURL(blob);
    link.download = "dados_resolutividade.csv";
    link.click();
}
</script>

</body>
</html>
