<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendamentos Backup</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #343a40; /* Cor de fundo escura */
            color: #ffffff; /* Cor do texto branco */
            font-family: 'Monospace', monospace; /* Fonte monoespaçada */
            padding: 20px;
        }

        h2 {
            color: #17a2b8; /* Cor azul claro para o título */
        }

        label {
            color: #17a2b8; /* Cor azul claro para os rótulos */
        }

        input,
        button {
            margin-top: 5px;
            border: 1px solid #ced4da; /* Borda cinza */
            background-color: #495057; /* Cor de fundo cinza escuro */
            color: #ffffff; /* Cor do texto branco */
            transition: 0.3s; /* Transição suave */
        }

        input:focus,
        button:focus {
            outline: none;
            box-shadow: 0 0 5px #17a2b8; /* Sombra azul claro ao focar */
        }

        button {
            cursor: pointer;
        }

        table {
            margin-top: 20px;
            background-color: #495057; /* Cor de fundo cinza escuro */
            color: #ffffff; /* Cor do texto branco */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Sombra suave */
            transition: 0.3s; /* Transição suave */
        }

        table th,
        table td {
            border: 1px solid #343a40; /* Borda escura */
        }

        table th {
            background-color: #212529; /* Cor de fundo preta */
            color: #ffffff;

        }

        table td {
    background-color: #343a40; /* Cor de fundo escura */
    color: #ffffff; /* Cor do texto branco */
    border: 1px solid #343a40; /* Borda escura */
}

        table tbody tr:hover {
            background-color: #495057; /* Cor de fundo cinza escuro ao passar o mouse */
        }
    </style>
</head>
<body>
<div class="container">
        <h2>Agendamentos Backup</h2>
        <form method="post" action="">
            <label for="start_date">Data Inicial:</label>
            <input type="date" name="start_date" id="start_date" required>

            <label for="end_date">Data Final:</label>
            <input type="date" name="end_date" id="end_date" required>

            <button type="submit" class="btn btn-primary">Filtrar</button>
        </form>

        <div class="table-container">
            <?php
                // Configurações do banco de dados
                $servername = "ws4.altcloud.net.br";
                $username = "ggnet_nocsz";
                $password = "ae7$6bPiLz/gp#iF";
                $dbname = "ggnet_nocsz";

                // Conectar ao banco de dados
                $conn = new mysqli($servername, $username, $password, $dbname);

                // Verificar a conexão
                if ($conn->connect_error) {
                    die("Erro de conexão: " . $conn->connect_error);
                }

                // Verificar se o formulário foi enviado
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    // Obter as datas do formulário
                    $start_date = $_POST["start_date"];
                    $end_date = $_POST["end_date"];

                    // Consulta SQL com filtro de data
                    $sql = "SELECT id, dataHora, protocolo, usuario, observacao, usuario_exclusao FROM agendamentos_backup WHERE dataHora BETWEEN '$start_date 00:00:00' AND '$end_date 23:59:59'";
                } else {
                    // Consulta SQL sem filtro de data
                    $sql = "SELECT id, dataHora, protocolo, usuario, observacao, usuario_exclusao FROM agendamentos_backup";
                }

                // Executar a consulta SQL
                $result = $conn->query($sql);

                // Verificar se existem resultados
                if ($result->num_rows > 0) {
                    echo '<table class="table table-striped">';
                    echo '<thead><tr><th>ID</th><th>Data e Hora</th><th>Protocolo</th><th>Usuario do agendamento</th><th>Observação</th><th>Usuário da Exclusão</th></tr></thead>';
                    echo '<tbody>';
                    // Saída dos dados de cada linha
                    while($row = $result->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td>' . $row["id"] . '</td>';
                        echo '<td>' . $row["dataHora"] . '</td>';
                        echo '<td>' . $row["protocolo"] . '</td>';
                        echo '<td>' . $row["usuario"] . '</td>';
                        echo '<td>' . $row["observacao"] . '</td>';
                        echo '<td>' . $row["usuario_exclusao"] . '</td>';
                        echo '</tr>';
                    }
                    echo '</tbody></table>';
                } else {
                    echo "Sem resultados";
                }

                // Fechar a conexão
                $conn->close();
            ?>
        </div>
    </div>
</body>
</html>
