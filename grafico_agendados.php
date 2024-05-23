<?php
    include 'conexao.php';
    include 'protect.php';

    define('HOST', 'ws4.altcloud.net.br');
    define('USUARIO', 'ggnet_nocsz');
    define('SENHA', 'ae7$6bPiLz/gp#iF');
    define('BANCO', 'ggnet_nocsz');

    $conexao = mysqli_connect(HOST, USUARIO, SENHA, BANCO);

    if (!$conexao) {
        die('Erro na conexão: ' . mysqli_connect_error());
    }

    $query = "SELECT usuario_exclusao, COUNT(usuario_exclusao) as total FROM agendamentos_backup GROUP BY usuario_exclusao";
    $resultado = mysqli_query($conexao, $query);

    if (!$resultado) {
        die('Erro na consulta: ' . mysqli_error($conexao));
    }

    $dados = array();
    while ($row = mysqli_fetch_assoc($resultado)) {
        $dados[$row['usuario_exclusao']] = $row['total'];
    }

    if (empty($dados)) {
        die('Nenhum dado encontrado.');
    }
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Usuários que mais chamam clientes agendados</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 10px;
            text-align: center;
        }

        h1 {
            color: #333;
        }

        #grafico {
            width: 80%;
            margin: 20px auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <header>
        <h1>Usuários que mais chamam clientes agendados</h1>
        <p>Olá, <?= $_SESSION['usuario']; ?></p>
    </header>

    <canvas id="grafico"></canvas>

    <script>
        var dados = <?php echo json_encode($dados); ?>;
        var labels = Object.keys(dados);
        var valores = Object.values(dados);

        var ctx = document.getElementById('grafico').getContext('2d');

        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Número de clientes atendidos',
                    data: valores,
                    backgroundColor: 'rgba(75, 192, 192, 0.6)',
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
</body>
</html>
