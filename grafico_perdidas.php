<?php
// Conexão com o banco de dados
$servername = "ws4.altcloud.net.br";
$username = "ggnet_nocsz";
$password = "ae7$6bPiLz/gp#iF";
$dbname = "ggnet_nocsz";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Array associativo para mapear os meses em inglês para português
$meses_em_portugues = array(
    "January" => "Janeiro",
    "February" => "Fevereiro",
    "March" => "Março",
    "April" => "Abril",
    "May" => "Maio",
    "June" => "Junho",
    "July" => "Julho",
    "August" => "Agosto",
    "September" => "Setembro",
    "October" => "Outubro",
    "November" => "Novembro",
    "December" => "Dezembro"
);

// Consulta para obter o número de registros por mês com ano completo
$sql = "SELECT COUNT(id) as total, DATE_FORMAT(data_hora, '%Y-%m') as mes FROM formulario GROUP BY DATE_FORMAT(data_hora, '%Y-%m')";
$result = $conn->query($sql);

// Array para armazenar os dados
$data = array();
while($row = $result->fetch_assoc()) {
    // Obtém o mês e ano no formato 'F Y' (por exemplo, 'January 2022')
    $mes_ano = date('F Y', strtotime($row['mes'] . '-01'));
    // Traduz o nome do mês para português usando o array associativo
    $mes_completo = $meses_em_portugues[date('F', strtotime($row['mes'] . '-01'))] . ' ' . date('Y', strtotime($row['mes'] . '-01'));
    // Adiciona os dados ao array
    $data[$mes_completo] = $row['total'];
}

// Fecha a conexão com o banco de dados
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gráfico de ligações perdidas</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Google Charts -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
</head>
<body>

<div class="container">
    <h1 class="mt-5 text-center">Gráfico de ligações perdidas</h1>
    <div id="curve_chart" class="chart-container"></div>
</div>

<!-- Bootstrap JS and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    // Função para carregar o gráfico
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Mês');
        data.addColumn('number', 'Total');
        data.addRows([
            <?php foreach($data as $mes => $total) {
                echo "['$mes', $total],";
            } ?>
        ]);

        var options = {
            title: 'Registros por Mês',
            curveType: 'function',
            legend: { position: 'bottom' },
            backgroundColor: '#f8f9fa', // Cor de fundo
            colors: ['#007bff'], // Cor da linha do gráfico
            animation: {
                duration: 1000,
                startup: true,
                easing: 'out',
            },
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

        chart.draw(data, options);

        // Animação ao rolar a página
        $(window).scroll(function() {
            $('.chart-container').each(function() {
                var bottom_of_object = $(this).offset().top + $(this).outerHeight();
                var bottom_of_window = $(window).scrollTop() + $(window).height();

                if (bottom_of_window > bottom_of_object) {
                    $(this).animate({'opacity':'1'}, 500);
                }
            });
        });
    }
</script>
<style>
    /* Estilo personalizado */
    body {
        background-color: #f8f9fa;
        font-family: Arial, sans-serif;
    }
    .container {
        padding-top: 50px;
    }
    .chart-container {
        width: 100%;
        height: 500px;
    }
</style>
</body>
</html>
