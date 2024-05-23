<!DOCTYPE html>
<html>
<head>
    <title>Relatório de Formulários Preenchidos</title>
    <link rel="stylesheet" href="relatorio_perdidas.css">
</head>
<body>
    <h1>Relatório de ligações perdidas</h1>
    <form method="POST">
        <label for="data_inicio">Data Início:</label>
        <input type="date" name="data_inicio" id="data_inicio" required>

        <label for="data_fim">Data Fim:</label>
        <input type="date" name="data_fim" id="data_fim" required>

        <input type="submit" value="Filtrar">
    </form>

    <?php
    // Dados de conexão com o banco de dados
    $server = 'ws4.altcloud.net.br';
    $usuario = 'ggnet_nocsz';
    $senha = 'ae7$6bPiLz/gp#iF';
    $base = 'ggnet_nocsz';

    try {
        // Cria uma conexão com o banco de dados MySQL usando PDO
        $pdo = new PDO("mysql:host=$server;dbname=$base;charset=utf8", $usuario, $senha);

        // Configura o PDO para lançar exceções em caso de erros
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Tratamento da exclusão
        if (isset($_POST['excluir'])) {
            $idExcluir = filter_input(INPUT_POST, 'excluir', FILTER_SANITIZE_NUMBER_INT);

            // Prepara a consulta SQL para excluir o registro com base no ID
            $sqlExcluir = "DELETE FROM formulario WHERE id = :id";
            $stmtExcluir = $pdo->prepare($sqlExcluir);
            $stmtExcluir->bindParam(':id', $idExcluir, PDO::PARAM_INT);
            $stmtExcluir->execute();

            // Redireciona para evitar reenviar o formulário ao atualizar a página
            header("Location: {$_SERVER['PHP_SELF']}");
            exit();
        }

        // Consulta de dados
        if (!empty($_POST['data_inicio']) && !empty($_POST['data_fim'])) {
            $data_inicio = filter_input(INPUT_POST, 'data_inicio', FILTER_SANITIZE_STRING);
            $data_fim = filter_input(INPUT_POST, 'data_fim', FILTER_SANITIZE_STRING);

            if ($data_inicio > $data_fim) {
                echo "A data de início não pode ser posterior à data de fim.";
            } else {
                // Ajusta a data fim para incluir todo o dia
                $data_fim_inclusiva = date('Y-m-d', strtotime($data_fim . ' +1 day'));

                // Prepara e executa a consulta SQL com o filtro de data
                $sql = "SELECT * FROM formulario WHERE data_hora >= :data_inicio AND data_hora < :data_fim_inclusiva";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':data_inicio', $data_inicio, PDO::PARAM_STR);
                $stmt->bindParam(':data_fim_inclusiva', $data_fim_inclusiva, PDO::PARAM_STR);
                $stmt->execute();
            }
        } else {
            // Consulta sem filtro de data
            $sql = "SELECT * FROM formulario";
            $stmt = $pdo->query($sql);
        }

        // Exibição dos resultados
        if (isset($stmt) && $stmt->rowCount() > 0) {
            echo "<table border='1'>";
            echo "<tr><th>DATA</th><th>Motivo da perda?</th><th>DNIS</th><th>ESPERA</th><th>Posição</th><th>Originador</th><th>Ação</th></tr>";

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // Formata a data para exibição
                $data_formatada = date('d/m/Y H:i:s', strtotime($row['data_hora']));
                echo "<tr>";
                echo "<td>{$data_formatada}</td>";
                echo "<td>" . htmlspecialchars($row['campo1'], ENT_QUOTES, 'UTF-8') . "</td>";
                echo "<td>" . htmlspecialchars($row['campo2'], ENT_QUOTES, 'UTF-8') . "</td>";
                echo "<td>" . htmlspecialchars($row['campo3'], ENT_QUOTES, 'UTF-8') . "</td>";
                echo "<td>" . htmlspecialchars($row['campo4'], ENT_QUOTES, 'UTF-8') . "</td>";
                echo "<td>" . htmlspecialchars($row['campo5'], ENT_QUOTES, 'UTF-8') . "</td>";
                echo "<td>";
                echo "<form method='POST'>";
                echo "<input type='hidden' name='excluir' value='{$row['id']}'>";
                echo "<button type='submit' class='btn-excluir'>Excluir</button>";
                echo "</form>";
                echo "</td>";
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "Nenhum registro encontrado.";
        }
    } catch (PDOException $e) {
        // Em caso de erro na conexão ou execução da consulta SQL, exibe uma mensagem de erro
        echo "Erro de conexão com o banco de dados: " . $e->getMessage();
    }
    ?>

    <a class="btn-voltar" href="home.php">Home</a>
</body>
</html>
