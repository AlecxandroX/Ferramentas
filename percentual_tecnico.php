<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Percentual Tecnico</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 20px;
            background-color: #f4f4f4;
        }

        #container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        h1, h2 {
            color: #333;
            text-align: center;
        }

        form {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input[type="date"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            box-sizing: border-box;
        }

        button {
            padding: 12px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            display: block;
        }

        button:hover {
            background-color: #45a049;
        }

        #resultadoConsulta {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
        }

        .cidade-container {
            margin-bottom: 20px;
        }

        .resultado-label {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .percent-bar {
            height: 15px;
            background-color: #ddd;
            border-radius: 4px;
            overflow: hidden;
            margin-bottom: 10px;
        }

        .percent {
            height: 100%;
            border-radius: 4px;
        }

        .percent-sim {
            background-color: #4CAF50;
        }

        .percent-nao {
            background-color: #f44336;
        }
    </style>
</head>
<body>

<div id="container">
    <h1>Percentual Tecnico</h1>

    <form id="consultaForm" method="get">
        <label for="dataInicial">Data Inicial:</label>
        <input type="date" id="dataInicial" name="dataInicial" required>

        <label for="dataFinal">Data Final:</label>
        <input type="date" id="dataFinal" name="dataFinal" required>

        <button type="submit">Consultar</button>
    </form>

    <div id="resultadoConsulta">
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            // Processar consulta quando o formulário for enviado
            consultarAtendimentos();
        }

        function consultarAtendimentos() {
            // Configurações do banco de dados
            $servername = "ws4.altcloud.net.br";
            $username = "ggnet_nocsz";
            $password = "ae7$6bPiLz/gp#iF";
            $dbname = "ggnet_nocsz";

            // Obtendo datas do formulário
            $dataInicial = $_GET['dataInicial'];
            $dataFinal = $_GET['dataFinal'];

            // Criando a conexão
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Verificando a conexão
            if ($conn->connect_error) {
                die("Falha na conexão com o banco de dados: " . $conn->connect_error);
            }

            // Consulta SQL para obter os dados no intervalo de datas
            $sql = "SELECT cidade, atendimento_concluido FROM atendimento_tecnico WHERE data BETWEEN '$dataInicial' AND '$dataFinal'";
            $result = $conn->query($sql);

            // Inicializando arrays para armazenar contagens por cidade
            $cidades = [];

            // Loop pelos resultados da consulta
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $cidade = $row['cidade'];
                    $concluido = $row['atendimento_concluido'];

                    // Adicionando contagens ao array correspondente
                    if (!isset($cidades[$cidade])) {
                        $cidades[$cidade] = ['total' => 0, 'sim' => 0, 'nao' => 0];
                    }

                    $cidades[$cidade]['total']++;
                    $cidades[$cidade][$concluido]++;
                }

                foreach ($cidades as $cidade => $contagens) {
                    $total = $contagens['total'];
                    $percentSim = number_format(($contagens['sim'] / $total) * 100, 1);
                    $percentNao = number_format(($contagens['nao'] / $total) * 100, 1);

                    echo "<div class='cidade-container'>";
                    echo "<h2>Regional: $cidade</h2>";
                    echo "<div class='resultado-label'>Total de consultas: $total</div>";
                    echo "<div class='resultado-label'>Porcentagem 'Conformidades': $percentSim%</div>";
                    echo "<div class='percent-bar'><div class='percent percent-sim' style='width: $percentSim%;'></div></div>";
                    echo "<div class='resultado-label'>Porcentagem 'Não conformidades': $percentNao%</div>";
                    echo "<div class='percent-bar'><div class='percent percent-nao' style='width: $percentNao%;'></div></div>";
                    echo "</div>";
                }
            } else {
                echo "<p>Nenhum resultado encontrado para o intervalo de datas selecionado.</p>";
            }

            // Fechando a conexão
            $conn->close();
        }
        ?>
    </div>

</div>

</body>
</html>
