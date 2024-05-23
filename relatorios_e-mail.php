<!DOCTYPE html>
<html>
<head>
    <title>Relatório de Atualizações de E-mail</title>
    <link rel="icon" href="https://static.vecteezy.com/ti/vetor-gratis/p3/4956037-icone-de-chamada-vetor.jpg" type="image/x-icon">
    <style>
        /* Estilo básico para o corpo da página */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column; /* Colocar os elementos em coluna */
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        /* Estilo para a tabela de relatório */
        table {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
            width: 80%;
            text-align: center;
            margin-top: 20px;
        }

        /* Estilo para o cabeçalho da tabela */
        th {
            background-color: #007bff;
            color: #fff;
            padding: 10px;
        }

        /* Estilo para as células da tabela */
        td {
            padding: 10px;
        }

        /* Estilo para o botão de excluir */
        .btn-excluir {
            background-color: #ff0000;
            color: #fff;
            padding: 6px 10px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }

        .btn-excluir:hover {
            background-color: #cc0000;
        }
    </style>
</head>
<body>
    <h1>Relatório de Atualizações de E-mail</h1>
    <?php
    // Inclui o arquivo de conexão com o banco de dados
    include('conexao.php');

    if (isset($_POST['excluir'])) {
        // Obter o ID da linha a ser excluída
        $id_excluir = $_POST['excluir'];
        
        // Prepara a consulta SQL para excluir a linha
        $sql_excluir = "DELETE FROM atualiza_email WHERE id = $id_excluir";
        
        // Executa a consulta de exclusão
        if (mysqli_query($conexao, $sql_excluir)) {
            echo '<div style="color: green;">Registro excluído com sucesso.</div>';
        } else {
            echo '<div style="color: red;">Erro ao excluir o registro: ' . mysqli_error($conexao) . '</div>';
        }
    }

    // Prepara a consulta SQL para recuperar os dados da tabela
    $sql = "SELECT * FROM atualiza_email";

    // Executa a consulta
    $resultado = mysqli_query($conexao, $sql);

    if (mysqli_num_rows($resultado) > 0) {
        echo '<table>';
        echo '<tr><th>ID</th><th>Código do Cliente</th><th>E-mail</th><th>Contato</th><th>Posição</th><th>Data de Inserção</th><th>Ação</th></tr>';
        while ($linha = mysqli_fetch_assoc($resultado)) {
            echo '<tr>';
            echo '<td>' . $linha['id'] . '</td>';
            echo '<td>' . $linha['codigo_cliente'] . '</td>';
            echo '<td>' . $linha['email'] . '</td>';
            echo '<td>' . $linha['contato'] . '</td>';
            echo '<td>' . $linha['posicao'] . '</td>';
            echo '<td>' . $linha['data_insercao'] . '</td>';
            echo '<td><form method="post"><button class="btn-excluir" type="submit" name="excluir" value="' . $linha['id'] . '">Excluir</button></form></td>';
            echo '</tr>';
        }
        echo '</table>';
    } else {
        echo 'Nenhum dado encontrado.';
    }

    // Fecha a conexão com o banco de dados
    mysqli_close($conexao);
    ?>

    <a class="btn-voltar" href="atualiza_email.php">Voltar</a>
</body>
</html>
