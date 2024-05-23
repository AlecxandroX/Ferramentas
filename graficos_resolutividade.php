
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica se os parâmetros de data foram fornecidos
    if (isset($_POST['start_date']) && isset($_POST['end_date']) && $_POST['start_date'] !== '' && $_POST['end_date'] !== '') {
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
    } else {
        // Se os parâmetros de data não foram fornecidos, use um intervalo amplo para incluir todos os dados
        $start_date = '1970-01-01'; // Data de início adequada ao seu contexto
        $end_date = '9999-12-31';   // Data de término adequada ao seu contexto
    }



    // Consulta SQL para contar o número de ocorrências de "Encaminhamento Técnico" por usuário dentro do intervalo de datas
    $sql_encaminhamento = "SELECT usuario, COUNT(*) as count FROM resolutividade WHERE status = 'Encaminhamento Técnico' AND data BETWEEN :start_date AND :end_date GROUP BY usuario";

    // Consulta SQL para contar o número de ocorrências de "Transferido de Setor" por usuário dentro do intervalo de datas
    $sql_transferido = "SELECT usuario, COUNT(*) as count FROM resolutividade WHERE status = 'Transferido de Setor' AND data BETWEEN :start_date AND :end_date GROUP BY usuario";

    // Consulta SQL para contar o número de ocorrências de "Encerrado, inatividade do cliente" por usuário dentro do intervalo de datas
    $sql_encerrado_inatividade = "SELECT usuario, COUNT(*) as count FROM resolutividade WHERE status = 'Encerrado, inatividade do cliente' AND data BETWEEN :start_date AND :end_date GROUP BY usuario";

    // Consulta SQL para contar o número de ocorrências de "Resolvido Remotamente" por usuário dentro do intervalo de datas
    $sql_resolvido_remotamente = "SELECT usuario, COUNT(*) as count FROM resolutividade WHERE status = 'Resolvido Remotamente' AND data BETWEEN :start_date AND :end_date GROUP BY usuario";

    // Prepara as consultas
    $stmt_encaminhamento = $pdo->prepare($sql_encaminhamento);
    $stmt_encaminhamento->bindParam(':start_date', $start_date, PDO::PARAM_STR);
    $stmt_encaminhamento->bindParam(':end_date', $end_date, PDO::PARAM_STR);

    $stmt_transferido = $pdo->prepare($sql_transferido);
    $stmt_transferido->bindParam(':start_date', $start_date, PDO::PARAM_STR);
    $stmt_transferido->bindParam(':end_date', $end_date, PDO::PARAM_STR);

    $stmt_encerrado_inatividade = $pdo->prepare($sql_encerrado_inatividade);
    $stmt_encerrado_inatividade->bindParam(':start_date', $start_date, PDO::PARAM_STR);
    $stmt_encerrado_inatividade->bindParam(':end_date', $end_date, PDO::PARAM_STR);

    $stmt_resolvido_remotamente = $pdo->prepare($sql_resolvido_remotamente);
    $stmt_resolvido_remotamente->bindParam(':start_date', $start_date, PDO::PARAM_STR);
    $stmt_resolvido_remotamente->bindParam(':end_date', $end_date, PDO::PARAM_STR);

    // Executa as consultas
    $stmt_encaminhamento->execute();
    $stmt_transferido->execute();
    $stmt_encerrado_inatividade->execute();
    $stmt_resolvido_remotamente->execute();

    // Obtém os resultados
    $result_encaminhamento = $stmt_encaminhamento->fetchAll(PDO::FETCH_ASSOC);
    $result_transferido = $stmt_transferido->fetchAll(PDO::FETCH_ASSOC);
    $result_encerrado_inatividade = $stmt_encerrado_inatividade->fetchAll(PDO::FETCH_ASSOC);
    $result_resolvido_remotamente = $stmt_resolvido_remotamente->fetchAll(PDO::FETCH_ASSOC);

    // Transforma os resultados em formato adequado para os gráficos
    $labels_encaminhamento = array_column($result_encaminhamento, 'usuario');
    $data_encaminhamento = array_column($result_encaminhamento, 'count');

    $labels_transferido = array_column($result_transferido, 'usuario');
    $data_transferido = array_column($result_transferido, 'count');

    $labels_encerrado_inatividade = array_column($result_encerrado_inatividade, 'usuario');
    $data_encerrado_inatividade = array_column($result_encerrado_inatividade, 'count');

    $labels_resolvido_remotamente = array_column($result_resolvido_remotamente, 'usuario');
    $data_resolvido_remotamente = array_column($result_resolvido_remotamente, 'count');

    // Retorna os dados como JSON para serem usados pelo JavaScript
    echo json_encode([
        'encaminhamento' => ['labels' => $labels_encaminhamento, 'data' => $data_encaminhamento],
        'transferido' => ['labels' => $labels_transferido, 'data' => $data_transferido],
        'encerrado_inatividade' => ['labels' => $labels_encerrado_inatividade, 'data' => $data_encerrado_inatividade],
        'resolvido_remotamente' => ['labels' => $labels_resolvido_remotamente, 'data' => $data_resolvido_remotamente],
    ]);
    exit;
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Graficos</title>
    <!-- Adicionando o Chart.js para criar os gráficos -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="resolutividade.css">
    <link rel="icon" href="data:image/png;base64,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" type="image/x-icon">
    <style>
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
<div id="user-info">
    <h2>Olá, Seja Bem Vindo</h2>
    <?= $_SESSION['usuario']; ?> 

   

    <a href="logout.php" class="logout-button">Sair</a>
</div>
    <div class="container mt-5">
        <h1>Graficos Resolutividade</h1>
        <h3>Selecione Um Intervalo De Horario Para O Consulta</h3>
        <form id="dateForm">
            <label for="start_date">Data Inicial:</label>
            <input type="date" id="start_date" name="start_date" required>
            
            <label for="end_date">Data Final:</label>
            <input type="date" id="end_date" name="end_date" required>
            
            <button type="button" onclick="updateCharts()">Filtrar</button>
            <a href="relatorio_resolutividade.php" class="btn meu-botao">Voltar ao Relatorio</a>
        </form>

        <canvas id="encaminhamentoChart" width="400" height="200"></canvas>
        <canvas id="transferidoChart" width="400" height="200"></canvas>
        <canvas id="encerradoInatividadeChart" width="400" height="200"></canvas>
        <canvas id="resolvidoRemotamenteChart" width="400" height="200"></canvas>
    </div>

    <script>
        // Função para atualizar os gráficos com base nas datas selecionadas
        function updateCharts() {
            var startDate = document.getElementById('start_date').value;
            var endDate = document.getElementById('end_date').value;

            // Faz uma solicitação AJAX para o script PHP
            var xhr = new XMLHttpRequest();
            xhr.open('POST', window.location.href, true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Parseia os dados JSON retornados pelo PHP
                    var data = JSON.parse(xhr.responseText);
                    // Chama a função drawCharts com os dados obtidos
                    drawCharts(data.encaminhamento.labels, data.encaminhamento.data, data.transferido.labels, data.transferido.data, data.encerrado_inatividade.labels, data.encerrado_inatividade.data, data.resolvido_remotamente.labels, data.resolvido_remotamente.data);
                }
            };
            // Envia as datas para o script PHP
            xhr.send('start_date=' + startDate + '&end_date=' + endDate);
        }

        // Criação dos gráficos de barras com Chart.js
        function drawCharts(labelsEncaminhamento, dataEncaminhamento, labelsTransferido, dataTransferido, labelsEncerradoInatividade, dataEncerradoInatividade, labelsResolvidoRemotamente, dataResolvidoRemotamente) {
            // Encaminhamento Técnico
            var ctxEncaminhamento = document.getElementById('encaminhamentoChart').getContext('2d');
            var myChartEncaminhamento = new Chart(ctxEncaminhamento, {
                type: 'bar',
                data: {
                    labels: labelsEncaminhamento,
                    datasets: [{
                        label: 'Quantidade de Encaminhamento Técnico',
                        data: dataEncaminhamento,
                        backgroundColor: 'skyblue'
                    }]
                },
                options: {
                    title: {
                        display: true,
                        text: 'Encaminhamento Técnico por Usuário'
                    },
                    scales: {
                        xAxes: [{
                            ticks: {
                                autoSkip: false,
                                maxRotation: 45,
                                minRotation: 45
                            }
                        }],
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });

            // Transferido de Setor
            var ctxTransferido = document.getElementById('transferidoChart').getContext('2d');
            var myChartTransferido = new Chart(ctxTransferido, {
                type: 'bar',
                data: {
                    labels: labelsTransferido,
                    datasets: [{
                        label: 'Quantidade de Transferido de Setor',
                        data: dataTransferido,
                        backgroundColor: 'lightcoral'
                    }]
                },
                options: {
                    title: {
                        display: true,
                        text: 'Transferido de Setor por Usuário'
                    },
                    scales: {
                        xAxes: [{
                            ticks: {
                                autoSkip: false,
                                maxRotation: 45,
                                minRotation: 45
                            }
                        }],
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });

            // Encerrado, inatividade do cliente
            var ctxEncerradoInatividade = document.getElementById('encerradoInatividadeChart').getContext('2d');
            var myChartEncerradoInatividade = new Chart(ctxEncerradoInatividade, {
                type: 'bar',
                data: {
                    labels: labelsEncerradoInatividade,
                    datasets: [{
                        label: 'Quantidade de Encerrado, inatividade do cliente',
                        data: dataEncerradoInatividade,
                        backgroundColor: 'lightgreen'
                    }]
                },
                options: {
                    title: {
                        display: true,
                        text: 'Encerrado, inatividade do cliente por Usuário'
                    },
                    scales: {
                        xAxes: [{
                            ticks: {
                                autoSkip: false,
                                maxRotation: 45,
                                minRotation: 45
                            }
                        }],
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });

            // Resolvido Remotamente
            var ctxResolvidoRemotamente = document.getElementById('resolvidoRemotamenteChart').getContext('2d');
            var myChartResolvidoRemotamente = new Chart(ctxResolvidoRemotamente, {
                type: 'bar',
                data: {
                    labels: labelsResolvidoRemotamente,
                    datasets: [{
                        label: 'Quantidade de Resolvido Remotamente',
                        data: dataResolvidoRemotamente,
                        backgroundColor: 'orange'
                    }]
                },
                options: {
                    title: {
                        display: true,
                        text: 'Resolvido Remotamente por Usuário'
                    },
                    scales: {
                        xAxes: [{
                            ticks: {
                                autoSkip: false,
                                maxRotation: 45,
                                minRotation: 45
                            }
                        }],
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
        }
    </script>
</body>
</html>