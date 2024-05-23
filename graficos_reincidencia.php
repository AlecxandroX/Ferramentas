<?php
    // Include de conexão com o Banco de dados
    include 'conexao.php';
    // Include utilizado para não deixar o usuário entrar nas páginas sem utilizar o login
    include 'protect.php';

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

    // Inicialização das variáveis
    $resolvedCount = 0;
    $technicalCount = 0;
    $resolvedRemotelyCount = 0;
    $total_linhas = 0;

    // Se as datas de início e fim forem definidas, executar a consulta SQL
    if(isset($_GET['start_date']) && isset($_GET['end_date'])) {
        $start_date = $_GET['start_date'];
        $end_date = $_GET['end_date'];

        $conn = new mysqli($servername, $username, $password, $database);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Modificar a consulta SQL para contar o número de linhas dentro do intervalo de datas
        $count_sql = "SELECT COUNT(*) AS total_linhas FROM suporte WHERE data BETWEEN '$start_date' AND '$end_date'";
        $count_result = $conn->query($count_sql);

        // Se a consulta retornar um resultado, obter o valor de total_linhas
        if ($count_result->num_rows > 0) {
            $row = $count_result->fetch_assoc();
            $total_linhas = $row["total_linhas"];
        }

        // Executar a consulta SQL
        $sql = "SELECT dificuldade_resolvida, encaminhado_tecnico FROM suporte WHERE data BETWEEN '$start_date' AND '$end_date'";
        $result = $conn->query($sql);

        while($row = $result->fetch_assoc()) {
            if ($row["dificuldade_resolvida"] == 'Sim') {
                $resolvedCount++;
            }
            if ($row["encaminhado_tecnico"] == 'Sim') {
                $technicalCount++;
            }
            if ($row["encaminhado_tecnico"] == 'Resolvido remotamente') {
                $resolvedRemotelyCount++;
            }
        }

        // Fechar a conexão
        $conn->close();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    width: 80px;
    height: 80px;
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
v
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
        <a href="relatorio_reincidencia.php" class="btn">Relatório</a>
    </form>
   
    <?php
        // Se as datas de início e fim forem definidas, exibir o número total de linhas dentro do intervalo de datas
        if(isset($_GET['start_date']) && isset($_GET['end_date'])) {
            echo "<p>Total de Casos: $total_linhas</p>";
        }
    ?>

    <canvas id="myChart"></canvas>

    <script>
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Resolvido', 'Encaminhado para Técnico', 'Resolvido remotamente'],
                datasets: [{
                    label: 'Número de Casos',
                    data: [<?php echo $resolvedCount; ?>, <?php echo $technicalCount; ?>, <?php echo $resolvedRemotelyCount; ?>],
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 205, 86, 0.2)'
                    ],
                    borderColor: [
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(255, 205, 86, 1)'
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
