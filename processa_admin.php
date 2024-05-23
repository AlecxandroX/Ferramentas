<?php


// Conexão com o banco de dados
$server = 'ws4.altcloud.net.br';
$usuario = 'ggnet_nocsz';
$senha = 'ae7$6bPiLz/gp#iF';
$base = 'ggnet_nocsz';

$conn = new mysqli($server, $usuario, $senha, $base);

if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

// Verifica se o parâmetro 'id' foi passado na URL para remoção
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Executa a consulta SQL para remover o registro com base no ID
    $sql = "DELETE FROM fila WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "Registro removido com sucesso.";
    } else {
        echo "Erro ao remover registro: " . $conn->error;
    }
}

// Consulta SQL para selecionar os dados da tabela
$sql = "SELECT id, nome_cliente, data_hora_entrada FROM fila";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Exibição da Tabela de Fila</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        h1 {
            background-color: #0074d9;
            color: white;
            padding: 10px;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #0074d9;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        a {
            text-decoration: none;
            color: #0074d9;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>Lista de Fila</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nome do Cliente</th>
            <th>Data e Hora de Entrada</th>
            <th>Ações</th>
        </tr>

        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["nome_cliente"] . "</td>";
                echo "<td>" . $row["data_hora_entrada"] . "</td>";
                echo '<td><a href="?id=' . $row["id"] . '">Remover</a></td>';
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>Nenhum registro encontrado.</td></tr>";
        }

        $conn->close();
        ?>

    </table>
</body>
</html>
