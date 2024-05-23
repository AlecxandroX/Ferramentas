<!DOCTYPE html>
<html>
<head>
    <title>Gráficos de Suporte</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }
        form {
            margin-bottom: 20px;
        }
        label {
            font-weight: bold;
            margin-right: 10px;
        }
        input[type="date"] {
            padding: 5px;
            margin-right: 10px;
        }
        button {
            padding: 8px 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
            border-radius: 5px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        #myChart {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            margin-top: 20px;
        }
        .btn {
        padding: 12px 24px;
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        text-decoration: none;
        display: inline-block;
    }

    .btn:hover {
        background-color: #45a049;
    }

    /* Animations */
    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    .fadeIn {
        animation-name: fadeIn;
        animation-duration: 1s;
    }
    </style>
</head>
<body>

<div class="container">
    <h1>Gráficos de Suporte</h1>
    <form method="GET">
        <label for="start_date">Data Inicial:</label>
        <input type="date" id="start_date" name="start_date" required>

        <label for="end_date">Data Final:</label>
        <input type="date" id="end_date" name="end_date" required>

        <button type="submit">Filtrar</button>
    </form>
    <a href="relatorio_reincidencia.php" class="btn">Relatório</a>
   

    <?php
    $servername = "ws4.altcloud.net.br";
    $username = "ggnet_nocsz";
    $password = "ae7$6bPiLz/gp#iF";
    $dbname = "ggnet_nocsz";

    // Verificar se as datas foram fornecidas
    if(isset($_GET['start_date']) && isset($_GET['end_date'])) {
        $start_date = $_GET['start_date'];
        $end_date = $_GET['end_date'];

        // Criar conexão
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Verificar conexão
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Consulta SQL para obter dados filtrados por datas
        $sql = "SELECT dificuldade_resolvida, encaminhado_tecnico FROM suporte WHERE data BETWEEN '$start_date' AND '$end_date'";
        $result = $conn->query($sql);

        $resolvedCount = 0;
        $technicalCount = 0;
        $totalCount = $result->num_rows;

        // Contagem de casos resolvidos e encaminhados para técnico
        while($row = $result->fetch_assoc()) {
            if ($row["dificuldade_resolvida"] == 'Sim' || $row["dificuldade_resolvida"] == 'Sem Reincidencia') {
                $resolvedCount++;
            }
            if ($row["encaminhado_tecnico"] == 'Sim' || $row["encaminhado_tecnico"] == 'Sem Reincidencia') {
                $technicalCount++;
            }
        }

        // Fechar conexão
        $conn->close();
    }
    ?>

    <div>
        <p>Total de Linhas: <?php echo $totalCount; ?></p>
    </div>

    <canvas id="myChart"></canvas>

    <script>
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Resolvido', 'Encaminhado para Técnico'],
                datasets: [{
                    label: 'Número de Casos',
                    data: [<?php echo $resolvedCount; ?>, <?php echo $technicalCount; ?>],
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(255, 99, 132, 0.2)'
                    ],
                    borderColor: [
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 99, 132, 1)'
                    ],
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
</div>

</body>
</html>
