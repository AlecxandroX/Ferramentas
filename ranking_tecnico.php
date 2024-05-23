<?php
$server = 'ws4.altcloud.net.br';
$usuario = 'ggnet_nocsz';
$senha = 'ae7$6bPiLz/gp#iF';
$base = 'ggnet_nocsz';

$conn = new mysqli($server, $usuario, $senha, $base);

if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// Verificar se as datas foram enviadas pelo formulário
if (isset($_POST['data_inicial']) && isset($_POST['data_final'])) {
    $data_inicial = $_POST['data_inicial'];
    $data_final = $_POST['data_final'];

    // Adicionar condição de filtro por data nas consultas SQL
    $filtro_data = "AND data BETWEEN '$data_inicial' AND '$data_final'";
} else {
    // Se as datas não foram fornecidas, não aplicar filtro por data
    $filtro_data = "";
}

// Consulta para contar as ocorrências de cada técnico com status "não" com ou sem filtro por data
$query1 = "SELECT tecnico, COUNT(*) as total FROM atendimento_tecnico WHERE atendimento_concluido = 'nao' $filtro_data GROUP BY tecnico";
$result1 = $conn->query($query1);

if (!$result1) {
    die("Erro na consulta: " . $conn->error);
}

// Preparar dados para o primeiro gráfico
$labels1 = [];
$data1 = [];

while ($row = $result1->fetch_assoc()) {
    $labels1[] = $row['tecnico'];
    $data1[] = $row['total'];
}

// Consulta para o segundo gráfico
$query2 = "SELECT cidade, COUNT(*) as quantidade FROM atendimento_tecnico WHERE atendimento_concluido = 'nao' $filtro_data GROUP BY cidade";
$result2 = $conn->query($query2);

if (!$result2) {
    die("Erro na consulta: " . $conn->error);
}

// Preparar dados para o segundo gráfico
$labels2 = [];
$data2 = [];

while ($row = $result2->fetch_assoc()) {
    $labels2[] = $row['cidade'];
    $data2[] = $row['quantidade'];
}

// Consulta para o terceiro gráfico com filtro adicional
$sql = "SELECT observacao FROM atendimento_tecnico WHERE atendimento_concluido = 'nao' $filtro_data AND data >= '2023-11-10'";
$result = $conn->query($sql);

if (!$result) {
    die("Erro na consulta: " . $conn->error);
}

// Restante do código permanece o mesmo...


// Inicializar um array para armazenar a contagem de cada nome na coluna "observacao"
$contagemNomes = array();

// Iterar sobre os resultados da consulta
while ($row = $result->fetch_assoc()) {
    $observacao = $row['observacao'];

    // Incrementar a contagem para o nome na coluna "observacao"
    if (isset($contagemNomes[$observacao])) {
        $contagemNomes[$observacao]++;
    } else {
        $contagemNomes[$observacao] = 1;
    }
}

// Preparar dados para o terceiro gráfico
$labels3 = json_encode(array_keys($contagemNomes));
$data3 = json_encode(array_values($contagemNomes));

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gráficos de Atendimentos</title>
    <style>
        /* Estilo para a div com a classe "filtro" */
        .filtro {
            width: 300px;
            margin: 20px auto; /* Adicionando "auto" para centralizar horizontalmente */
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        /* Estilo para o título h2 dentro da div */
        .filtro h2 {
            font-size: 18px;
            color: #333;
        }

        /* Estilo para o formulário dentro da div */
        .filtro form {
            margin-top: 15px;
        }

        /* Estilo para as entradas de data dentro do formulário */
        .filtro input[type="date"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }

        /* Estilo para o botão de submit dentro do formulário */
        .filtro input[type="submit"] {
            background-color: #4caf50;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="filtro">
        <h2>Filtrar por Data</h2>
        <form method="post" action="">
            Data Inicial: <input type="date" name="data_inicial">
            Data Final: <input type="date" name="data_final">
            <input type="submit" value="Filtrar">
        </form>
    </div>

    <h2>Gráfico de Atendimentos por Técnico</h2>
    <canvas id="myChart1" width="400" height="200"></canvas>
    <script>
        var ctx1 = document.getElementById('myChart1').getContext('2d');
        var myChart1 = new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($labels1); ?>,
                datasets: [{
                    label: 'Quantidade erros por tecnico',
                    data: <?php echo json_encode($data1); ?>,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

    <h2>Gráfico de Atendimentos por Cidade</h2>
    <canvas id="myChart2" width="400" height="200"></canvas>
    <script>
        var ctx2 = document.getElementById('myChart2').getContext('2d');
        var myChart2 = new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($labels2); ?>,
                datasets: [{
                    label: 'Quantidade de erros por regional',
                    data: <?php echo json_encode($data2); ?>,
                    backgroundColor: 'rgba(75, 192, 75, 0.2)',
                    borderColor: 'rgba(75, 192, 75, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

    <h2>Grafico por erros</h2>
    <canvas id="myChart" width="400" height="200"></canvas>
    <script>
        var ctx3 = document.getElementById('myChart').getContext('2d');
        var labels3 = <?php echo $labels3; ?>;
        var data3 = <?php echo $data3; ?>;

        var myChart3 = new Chart(ctx3, {
            type: 'bar',
            data: {
                labels: labels3,
                datasets: [{
                    label: 'Contagem por erros',
                    data: data3,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

<?php
// Substitua essas informações pelas credenciais do seu banco de dados
$servername = "ws4.altcloud.net.br";
$username = "ggnet_nocsz";
$password = "ae7$6bPiLz/gp#iF";
$dbname = "ggnet_nocsz";

// Cria a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Consulta SQL para obter a contagem de atendimentos não concluídos por mês
$sql = "SELECT DATE_FORMAT(data, '%Y-%m') as mes, COUNT(*) as total FROM atendimento_tecnico WHERE atendimento_concluido = 'nao' GROUP BY mes";
$result = $conn->query($sql);

// Array que irá armazenar os dados para o gráfico
$dataArray = array();

// Adiciona cabeçalhos ao array
$dataArray[] = ['Mês', 'Atendimentos não concluídos'];

// Preenche o array com os dados do banco de dados
while ($row = $result->fetch_assoc()) {
    $dataArray[] = [$row['mes'], (int)$row['total']];
}

// Converte o array PHP em um formato JSON
$dataJson = json_encode($dataArray);

// Fecha a conexão com o banco de dados
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable(<?php echo $dataJson; ?>);

            var options = {
                title: 'Atendimentos Incorretos Por Mês',
                curveType: 'function',
                legend: { position: 'bottom' },
                hAxis: {title: 'Mês', titleTextStyle: {color: '#333'}},
                vAxis: {minValue: 0}
            };

            var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
            chart.draw(data, options);
        }
    </script>
    
</head>
<body>
    <div id="chart_div" style="width: 1000px; height: 500px;"></div>
</body>
</html>
<?php
// Conectar ao banco de dados (substitua com suas próprias configurações)
$servername = "ws4.altcloud.net.br";
$username = "ggnet_nocsz";
$password = "ae7$6bPiLz/gp#iF";
$dbname = "ggnet_nocsz";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Consulta SQL
$query = "SELECT * FROM atendimento_tecnico";
$result = $conn->query($query);

// Array para armazenar os dados
$data = array();

while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

// Fechar a conexão com o banco de dados
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gráficos Profissionais com PHP e Chart.js</title>
    <!-- Inclua a biblioteca Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div style="width: 45%; float: left;">
        <!-- Gráfico de pizza para a distribuição das cidades -->
        <canvas id="cidadeChart"></canvas>
    </div>

    <div style="width: 45%; float: left;">
        <!-- Gráfico de pizza para o status do atendimento concluído -->
        <canvas id="atendimentoConcluidoChart"></canvas>
    </div>

    <script>
        // Dados obtidos do PHP
        var data = <?php echo json_encode($data); ?>;

        // Preparar dados para o gráfico de pizza das cidades
        var cidadeData = {};
        data.forEach(function(item) {
            var cidade = item.cidade;
            if (['RSL', 'PUN', 'CDR', 'IRI', 'VDA', 'CNI'].includes(cidade)) {
                if (cidade in cidadeData) {
                    cidadeData[cidade]++;
                } else {
                    cidadeData[cidade] = 1;
                }
            }
        });

        var cidadeLabels = Object.keys(cidadeData);
        var cidadeValues = Object.values(cidadeData);

        // Gráfico de pizza para a distribuição das cidades
        var cidadeChart = new Chart(document.getElementById('cidadeChart').getContext('2d'), {
            type: 'pie',
            data: {
                labels: cidadeLabels,
                datasets: [{
                    data: cidadeValues,
                    backgroundColor: ['rgba(255, 99, 132, 0.7)', 'rgba(54, 162, 235, 0.7)', 'rgba(255, 206, 86, 0.7)', 'rgba(75, 192, 192, 0.7)', 'rgba(153, 102, 255, 0.7)', 'rgba(255, 159, 64, 0.7)'],
                }]
            },
            options: {
                title: {
                    display: true,
                    text: 'Distribuição das Cidades'
                }
            }
        });

        // Preparar dados para o gráfico de pizza do status do atendimento concluído
        var atendimentoConcluidoData = {};
        data.forEach(function(item) {
            var status = item.atendimento_concluido;
            if (status in atendimentoConcluidoData) {
                atendimentoConcluidoData[status]++;
            } else {
                atendimentoConcluidoData[status] = 1;
            }
        });

        var atendimentoConcluidoLabels = Object.keys(atendimentoConcluidoData);
        var atendimentoConcluidoValues = Object.values(atendimentoConcluidoData);

        // Gráfico de pizza para o status do atendimento concluído
        var atendimentoConcluidoChart = new Chart(document.getElementById('atendimentoConcluidoChart').getContext('2d'), {
            type: 'pie',
            data: {
                labels: atendimentoConcluidoLabels,
                datasets: [{
                    data: atendimentoConcluidoValues,
                    backgroundColor: ['rgba(255, 99, 132, 0.7)', 'rgba(54, 162, 235, 0.7)', 'rgba(255, 206, 86, 0.7)'],
                }]
            },
            options: {
                title: {
                    display: true,
                    text: 'Status do Atendimento Concluído'
                }
            }
        });
    </script>
</body>
</html>
