<!DOCTYPE html>
<html>
<head>
    <title>Vistorias</title>
    <style>
        body {
            font-family: "Courier New", monospace;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        h1 {
            background-color: #a238ff;
            color: #fff;
            padding: 20px;
            text-align: center;
            margin-bottom: 0;
        }

        form {
            background-color: #fff;
            max-width: 400px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        label {
            display: block;
            margin: 10px 0;
            font-weight: bold;
        }

        input[type="date"],
        select {
            width: calc(100% - 22px);
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 3px;
            font-size: 16px;
            display: inline-block;
        }

        input[type="submit"] {
            background-color: #a238ff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 3px;
            cursor: pointer;
            display: block;
            margin-top: 10px;
        }

        .botoes {
            text-align: center;
            margin-top: 20px;
        }

        .button {
            background-color: #a238ff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin-right: 10px;
        }

        .button:hover {
            background-color: #a238ff;
        }

        table {
            border-collapse: collapse;
            width: 90%;
            margin: 20px auto;
            border: 1px solid #ccc;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        th, td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ccc;
        }

        th {
            background-color: #a238ff;
            color: #fff;
        }

        th.date-column {
            width: 150px;
        }

        .observacao-cell {
            max-width: 300px;
            word-wrap: break-word;
        }

        @media (max-width: 768px) {
            .observacao-cell {
                max-width: 100%;
            }
        }
    </style>
</head>
<body>
<h1>Vistorias realizadas</h1>
    <form method="post">
        <label for="data_filtro">Filtrar por Data:</label>
        <input type="date" name="data_filtro">
        
        <label for="cidade_filtro">Filtrar por Cidade:</label>
        <select name="cidade_filtro" id="cidade_filtro">
            <option value="">Todas as Cidades</option>
            <option value="CNI">CNI</option>
            <option value="RSL">RSL</option>
            <option value="PUN">PUN</option>
            <option value="VDA">VDA</option>
            <option value="CDR">CDR</option>
            <option value="IRI">IRI</option>
        </select>
        

        <input type="submit" value="Filtrar">
    </form>
    <!-- Botões e tabela (mantidos iguais ao seu código anterior) -->
    <div class="botoes">
            <a href="atendimento_incorretos.php" class="button">OSs Incorretas</a>
            <a href="https://nocsz.gegnet.com.br/ranking_tecnico.php" class="button">Gráfico e Percentual </a>
        </div>
    <table>
        <tr>
            <th>Nº</th>
            <th class="date-column">Data</th>
            <th>Protocolo</th>
            <th>Nº O.S</th>
            <th>Técnico</th>
            <th>Cidade</th>
            <th>Qualidade das Fotos Anexadas?</th>
            <th>Todas as fotos foram inseridas?</th>
            <th>Dificuldade do Cliente foi resolvida?</th>
            <th>Quem abriu o chamado assinou a O.S?</th>
            <th>Configurações do roteador, DNS, versão estão OK?</th>
            <th class="observacao-cell">Observação</th>
            <th>Atendimento concluído?</th>
        </tr>
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

        // Verificar se uma data foi selecionada
        if (isset($_POST['data_filtro'])) {
            $data_filtro = $_POST['data_filtro'];
        } else {
            $data_filtro = '';
        }

        // Verificar se uma cidade foi selecionada
        if (isset($_POST['cidade_filtro'])) {
            $cidade_filtro = $_POST['cidade_filtro'];
        } else {
            $cidade_filtro = '';
        }

        // Construir a consulta SQL com base nos filtros
        $sql = "SELECT * FROM atendimento_tecnico WHERE 1=1";

        if (!empty($data_filtro)) {
            $sql .= " AND data = '$data_filtro'";
        }

        if (!empty($cidade_filtro)) {
            $sql .= " AND cidade = '$cidade_filtro'";
        }

        $result = $conn->query($sql);

        $lineNumber = 1; // Inicializa o número da linha

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $lineNumber . '</td>';
                echo '<td>' . $row['data'] . '</td>';
                echo '<td>' . $row['protocolo'] . '</td>';
                echo '<td>' . $row['os'] . '</td>';
                echo '<td>' . $row['tecnico'] . '</td>';
                echo '<td>' . $row['cidade'] . '</td>';
                echo '<td>' . $row['qualidade'] . '</td>';
                echo '<td>' . $row['fotos_anexadas'] . '</td>';
                echo '<td>' . $row['dificuldade_resolvida'] . '</td>';
                echo '<td>' . $row['assinatura_os'] . '</td>';
                echo '<td>' . $row['configuracoes_ok'] . '</td>';
                echo '<td>' . $row['observacao'] . '</td>';
                echo '<td>' . $row['atendimento_concluido'] . '</td>';
                echo '</tr>';
                $lineNumber++; // Incrementa o número da linha
            }
        } else {
            echo "<tr><td colspan='13'>Nenhum dado encontrado.</td></tr>";
        }

        $conn->close();
        ?>
    </table>
    <button id="exportExcel" class="button">Exportar para Excel</button>

    <script>
    document.getElementById('exportExcel').addEventListener('click', function () {
        exportToExcel();
    });

    function exportToExcel() {
        const table = document.querySelector('table');
        const rows = table.querySelectorAll('tr');

        const data = [];

        for (let i = 1; i < rows.length; i++) {
            const cols = rows[i].querySelectorAll('td');
            const rowData = [];
            for (let j = 0; j < cols.length; j++) {
                rowData.push(cols[j].innerText);
            }
            data.push(rowData.join('\t'));
        }

        const excelData = data.join('\n');
        const blob = new Blob([excelData], { type: 'application/vnd.ms-excel' });
        const link = document.createElement('a');
        link.href = window.URL.createObjectURL(blob);
        link.download = 'vistorias.xls';
        link.click();
    }
</script>

</body>
</html>