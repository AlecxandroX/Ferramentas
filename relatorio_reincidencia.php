<?php
    include 'protect.php'; //Include utilizado para não deixar o usuário entrar nas páginas sem utilizar o login

    $servername = "ws4.altcloud.net.br";  // endereço do servidor MySQL
$username = "ggnet_nocsz";  // seu nome de usuário do MySQL
$password = "ae7$6bPiLz/gp#iF";    // sua senha do MySQL
$database = "ggnet_nocsz";  // nome do banco de dados


    // Conexão com o banco de dados
    $conn = new mysqli($servername, $username, $password, $database);

    // Verifica se houve erro na conexão
    if ($conn->connect_error) {
        die("Erro de conexão: " . $conn->connect_error);
    }

    // Query para contar o número de linhas na tabela 'suporte'
    $count_sql = "SELECT COUNT(*) AS total_linhas FROM suporte";
    $count_result = $conn->query($count_sql);
    $total_linhas = $count_result->fetch_assoc()['total_linhas'];

    // Fecha a conexão
    $conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatorio de Reincidentes</title>
    <style>
         body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f2f2f2;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

/* Estilo para o formulário de filtro */
form {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    grid-gap: 10px;
    margin-bottom: 20px;
}

input[type="date"],
input[type="submit"] {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    width: 100%;
    box-sizing: border-box;
}

input[type="submit"] {
    background-color: #4CAF50;
    color: white;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

input[type="submit"]:hover {
    background-color: #45a049;
}

/* Estilo para a tabela */
table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

th, td {
    padding: 10px;
    border-bottom: 1px solid #ddd;
    text-align: left;
}

th {
    background-color: #4CAF50;
    color: white;
}

/* Estilo para o botão de download CSV */
.btn-download {
    padding: 10px 20px;
    background-color: #008CBA;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.btn-download:hover {
    background-color: #006f8b;
}

.btn {
    padding: 10px 20px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    text-decoration: none;
    display: inline-block;
    margin-right: 10px;
    margin-bottom: 10px;
}

.btn:hover {
    background-color: #4C9F55;
}

.card {
    background-color: #ffffff;
    padding: 20px;
    border-radius: 10px;
    margin: 20px;
    color: #333;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

/* Estilo para informações do usuário */
#user-info {
    position: fixed;
    top: 20px;
    right: 20px;
    background-color: #ffffff;
    padding: 10px;
    border-radius: 25px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    z-index: 1000;
    transition: transform 0.3s ease-in-out;
}

#user-info:hover {
    transform: scale(1.05);
}

#user-info h6 {
    margin: 0;
}

#user-info button {
    background: none;
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    transition: transform 0.3s ease-in-out;
}

#user-info button:hover {
    transform: scale(1.1);
}

#user-info button span {
    margin-left: 10px;
}

#user-info button img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    transition: transform 0.3s ease-in-out;
}

.logout-button {
    color: #ffffff;
    text-decoration: none;
    margin-left: 10px;
    padding: 8px 15px;
    border: none;
    border-radius: 25px;
    background-color: #4CAF50;
    transition: background-color 0.3s ease-in-out;
}

.logout-button:hover {
    background-color: #45a049;
}


    </style>
</head>
<body>
<div id="user-info">
    <h6><button onclick="mostrarFormulario()">
        <?= $_SESSION['usuario']; ?>
        <span>
            <?php
            $foto_path = "uploads/" . $_SESSION['id_usuario'] . "_foto.jpg";

            // Verifica se o arquivo da foto existe
            if (file_exists($foto_path)) {
                // Se existir, exibe a foto do usuário com um tamanho pequeno
                echo '<img src="' . $foto_path . '" alt="Foto do Usuário" style="width: 30px; height: 30px; border-radius: 50%;">';
            } else {
                // Se não existir, exibe uma imagem padrão com um tamanho pequeno
                echo '<img src="https://static.vecteezy.com/ti/vetor-gratis/p3/8302514-eps10-branco-usuario-icone-solido-ou-logotipo-em-simples-plano-moderno-estilo-isolado-em-fundo-preto-gratis-vetor.jpg" alt="Imagem Padrão" style="width: 30px; height: 30px; border-radius: 50%;">';
            }
            ?>
        </span>
    </button></h6>
   
    <a href="logout.php" class="logout-button">Sair</a>
</div>
<br>
<br>
<br>
<br>
<br>
<div id="formularioUpload" class="card" style="display: none;">
    <form action="" method="post" enctype="multipart/form-data">
        <label for="foto">Escolha uma foto:</label>
        <input type="file" name="foto" id="foto" accept="image/*" required>
        <br>
        <input type="submit" value="Enviar Foto">
    </form>
</div>

<script>
    function mostrarFormulario() {
        var formulario = document.getElementById('formularioUpload');
        formulario.style.display = 'block';
    }
</script>
<div class="num">
<p>Número total de casos: <?= $total_linhas ?></p>
</div>
<div class="container">
    
<?php

// Configurações de conexão com o banco de dados
$servername = "ws4.altcloud.net.br";  // endereço do servidor MySQL
$username = "ggnet_nocsz";  // seu nome de usuário do MySQL
$password = "ae7$6bPiLz/gp#iF";    // sua senha do MySQL
$database = "ggnet_nocsz";  // nome do banco de dados

// Conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $database);

// Verifica se houve erro na conexão
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

// Verifica se o formulário foi submetido e se o campo Obs foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"]) && isset($_POST["obs"])) {
    $id = $conn->real_escape_string($_POST["id"]);
    $obs = $conn->real_escape_string($_POST["obs"]);
    $sql = "UPDATE suporte SET Obs='$obs' WHERE id='$id'";
    if ($conn->query($sql) !== TRUE) {
        echo "Erro ao atualizar registro: " . $conn->error;
    }
}

// Inicialização das variáveis de filtro de datas
$data_inicio = '';
$data_fim = '';

// Verifica se os campos de filtro de datas foram submetidos
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data_inicio = $_POST["data_inicio"];
    $data_fim = $_POST["data_fim"];
}

// Query padrão para selecionar todos os registros da tabela 'suporte'
$sql = "SELECT * FROM suporte";

// Adiciona filtro de datas se os campos de filtro forem preenchidos
if (!empty($data_inicio) && !empty($data_fim)) {
    $sql .= " WHERE data BETWEEN '$data_inicio' AND '$data_fim'";
}

// Executa a query
$result = $conn->query($sql);

// Formulário para filtro de datas e botão para submeter o formulário
echo "<form method='post' action='" . $_SERVER["PHP_SELF"] . "'>
        Data Início: <input type='date' name='data_inicio' value='$data_inicio'>
        Data Fim: <input type='date' name='data_fim' value='$data_fim'>
        <input type='submit' value='Filtrar'>
      </form>";

// Verifica se há resultados
if ($result->num_rows > 0) {
    // Cabeçalho da tabela HTML
    echo "<table>
            <tr>
                <th>Nome</th>
                <th>Protocolo</th>
                <th>Data</th>
                <th>Dificuldade Resolvida</th>
                <th>Encaminhado para Técnico</th>
                <th>Obs</th>
            </tr>";

    // Loop através dos resultados e formatar para a tabela HTML
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["nome"] . "</td>";
        echo "<td>" . $row["protocolo"] . "</td>";
        echo "<td>" . $row["data"] . "</td>";
        echo "<td>" . $row["dificuldade_resolvida"] . "</td>";
        echo "<td>" . $row["encaminhado_tecnico"] . "</td>";
        // Campo de entrada de texto para o campo "Obs"
        echo "<td><form method='post'>";
        echo "<input type='hidden' name='id' value='" . $row["id"] . "'>";
        echo "<input type='text' name='obs' value='" . $row["Obs"] . "'>";
        echo "<input type='submit' value='Salvar Alterações'>";
        echo "</form></td>";
        echo "</tr>";
    }

    echo "</table>";

    // Botão para baixar os dados em formato CSV
    echo "<button style='padding: 10px 20px;
                      background-color: #4CAF50;
                      color: white;
                      border: none;
                      border-radius: 4px;
                      cursor: pointer;
                      transition: background-color 0.3s ease;'
              onclick='downloadCSV()'>Baixar CSV</button>";

    // Script JavaScript para realizar o download do CSV
    echo "<script>
            function downloadCSV() {
                let csv = '';
                const rows = document.querySelectorAll('table tr');
                rows.forEach((row) => {
                    row.querySelectorAll('td').forEach((cell, index) => {
                        csv += cell.textContent;
                        if (index < row.cells.length - 1) {
                            csv += ',';
                        }
                    });
                    csv += '\\n';
                });
                const blob = new Blob([csv], { type: 'text/csv' });
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.setAttribute('hidden', '');
                a.setAttribute('href', url);
                a.setAttribute('download', 'dados.csv');
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
            }
          </script>";
} else {
    echo "Nenhum resultado encontrado.";
}

// Fecha a conexão com o banco de dados
$conn->close();
?>


  <a href="reincidencia.php" class="btn">Formulario</a>
    <a href="graficos_reincidencia.php" class="btn">Graficos</a>
    <a href="home.php" class="btn">Home</a>

</body>
</html>
