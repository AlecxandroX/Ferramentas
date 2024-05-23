<!DOCTYPE html>
<html>

<head>
<style>
body {
    font-family: Arial, sans-serif;
    background-color: #f5f5f5; /* Cor de fundo clara */
    color: #333; /* Cor do texto em preto */
    margin: 0;
    padding: 0;
}

.header {
    background-color: #3498db; /* Azul claro para o cabeçalho */
    color: #ffffff;
    text-align: center;
    padding: 20px;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

.form-container {
    background-color: #ecf0f1; /* Cinza claro para o formulário */
    border: 1px solid #dcdcdc; /* Borda um pouco mais escura */
    border-radius: 5px;
    padding: 20px;
    margin-bottom: 20px;
}

.form-label {
    display: block;
    font-weight: bold;
    color: #333; /* Cor do texto em preto */
}

.form-input {
    width: 100%;
    padding: 10px;
    margin: 5px 0;
    border: 1px solid #dcdcdc; /* Borda um pouco mais escura */
    border-radius: 5px;
    background-color: #f9f9f9; /* Fundo do input um pouco mais claro */
    color: #333; /* Cor do texto em preto */
}

.submit-button {
    background-color: #3498db; /* Azul claro para o botão */
    color: #ffffff;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
}

.submit-button:hover {
    background-color: #2980b9; /* Azul um pouco mais escuro no hover */
}

.table-container {
    display: flex;
    flex-wrap: wrap;
}

.table-block {
    background-color: #ecf0f1; /* Cinza claro para os blocos de tabela */
    border: 1px solid #dcdcdc; /* Borda um pouco mais escura */
    border-radius: 5px;
    margin: 10px;
    padding: 15px;
    width: calc(33.33% - 20px);
    box-sizing: border-box;
    color: #333; /* Cor do texto em preto */
}

.table-cell {
    margin: 5px 0;
}

@media (max-width: 768px) {
    .table-block {
        width: 100%;
    }
}

#gerarPDF {
    display: inline-block;
    padding: 10px 20px;
    background-color: #a238ff; /* Verde claro para o botão PDF */
    color: #ffffff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

#gerarPDF:hover {
    background-color: #a238ff; /* Verde um pouco mais escuro no hover */
}

.header {
    background-color: #000; /* Verde claro para o cabeçalho */
    color: #ffffff;
}

/* Adicione esta classe para ocultar o formulário por padrão */
.hidden-form {
    display: none;
}

/* Estilo padrão do botão de alternar */
#toggleFilters {
    background-color: #a238ff; /* Verde claro para o botão de alternar */
    color: #ffffff;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
}

/* Estilo do botão de alternar quando o formulário está visível */
#toggleFilters.active {
    background-color: #a238ff; /* Verde um pouco mais escuro no estado ativo */
}


</style>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.4.1/jspdf.debug.js" integrity="sha384-THVO/sM0mFD9h7dfSndI6TS0PgAGavwKvB5hAxRRvc0o9cPLohB0wb/PTA7LdUHs" crossorigin="anonymous"></script>
</head>

<body>
    <div class="header">
        <img src="https://s3.amazonaws.com/mktzap-media-storage-master/whitelabel/companies/logo_login/7ae26d275da4474d90ad043a6ab4ca046d87af48" alt="blsdm">
    </div>
    <div class="container">
    <div class="form-container hidden-form"> <!-- Adicione a classe hidden-form -->
        <form method="post">
                <label for="data_inicio" class="form-label">Data de início:</label>
                <input type="date" name="data_inicio" class="form-input">
                <label for="data_fim" class="form-label">Data de fim:</label>
                <input type="date" name="data_fim" class="form-input">
                <label for="cidade" class="form-label">Selecione uma regional:</label>
                <select name="cidade" class="form-input">
                    <option value="">Todas as Cidades</option>
                    <option value="CNI">CNI</option>
                    <option value="RSL">RSL</option>
                    <option value="VDA">VDA</option>
                    <option value="PUN">PUN</option>
                    <option value="CDR">CDR</option>
                    <option value="IRI">IRI</option>
                </select>
                <input type="submit" value="Filtrar" class="submit-button" style="background-color: #D61400; color: #fff;">
                <button id="gerarPDF" style="background-color: #D61400; color: #fff;">Gerar PDF</button>
                </form>
    </div>
    
    <button id="toggleFilters">
        <i class="fas fa-bars"></i> Mostrar Filtros
    </button>
    <BR></BR>
            <br>
            <script>
document.addEventListener('DOMContentLoaded', function () {
    // Adicione um evento de clique ao botão
    document.getElementById('toggleFilters').addEventListener('click', function () {
        // Obtém os elementos do formulário
        var formContainer = document.querySelector('.form-container');

        // Alterna a classe 'hidden-form' para mostrar/ocultar o formulário
        if (formContainer.classList.contains('hidden-form')) {
            formContainer.classList.remove('hidden-form');
            this.innerHTML = '<i class="fas fa-filter"></i> Ocultar Filtros';
        } else {
            formContainer.classList.add('hidden-form');
            this.innerHTML = '<i class="fas fa-filter"></i> Mostrar Filtros';
        }
    });
});
</script>

           
        </div>
       
        <div class="table-container">
        <?php
// Conexão com o banco de dados
$server = 'ws4.altcloud.net.br';
$usuario = 'ggnet_nocsz';
$senha = 'ae7$6bPiLz/gp#iF';
$base = 'ggnet_nocsz';

try {
    // Conecta ao banco de dados
    $pdo = new PDO("mysql:host=$server;dbname=$base", $usuario, $senha);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Defina a consulta SQL com base nos filtros de datas e cidade
    $sql = "SELECT * FROM atendimento_tecnico WHERE atendimento_concluido = 'nao'";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!empty($_POST['data_inicio']) && !empty($_POST['data_fim'])) {
            $data_inicio = $_POST['data_inicio'];
            $data_fim = $_POST['data_fim'];
            $sql .= " AND data BETWEEN :data_inicio AND :data_fim";
        }

        if (!empty($_POST['cidade']) && $_POST['cidade'] !== 'Todas as Cidades') {
            $cidade = $_POST['cidade'];
            $sql .= " AND cidade = :cidade";
        }
    }

    $stmt = $pdo->prepare($sql);

    if (isset($data_inicio) && isset($data_fim)) {
        $stmt->bindParam(':data_inicio', $data_inicio);
        $stmt->bindParam(':data_fim', $data_fim);
    }

    if (isset($cidade)) {
        $stmt->bindParam(':cidade', $cidade);
    }

    $stmt->execute();

    echo '<div class="table-container">';
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo '<div class="table-block">';
        echo '<div class="table-cell"><b>Data:</b> ' . $row['data'] . '</div>';
        echo '<div class="table-cell"><b>Protocolo:</b> ' . $row['protocolo'] . '</div>';
        echo '<div class="table-cell"><b>O.S:</b> ' . $row['os'] . '</div>';
        echo '<div class="table-cell"><b>Cidade:</b> ' . $row['cidade'] . '</div>';
        echo '<div class="table-cell"><b>Técnico:</b> ' . $row['tecnico'] . '</div>';
        echo '<div class="table-cell"><b>Não conformidade:</b> ' . $row['observacao'] . '</div>';
        echo '<div class="table-cell"><b><br><br><br></b> ' . $row['#'] . '</div>';
        
        echo '</div>';
    }
    echo '</div>';
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}

// Fecha a conexão
?>


</div>
    </div>
    <script>
document.getElementById("gerarPDF").addEventListener("click", function() {
    // 1. Crie um novo jsPDF com configurações de página personalizadas
    var doc = new jsPDF('p', 'mm', 'a4'); // 'p' para retrato, 'l' para paisagem

    // 2. Defina estilos de fonte personalizados (opcional)
    doc.setFont("helvetica");
    doc.setFontSize(12);

    // 3. Função para adicionar conteúdo da página ao PDF
    function addPageContent() {
        // 4. Coleta o conteúdo HTML da página
        var pageContent = document.body.innerHTML;

        // 5. Adiciona o conteúdo coletado ao PDF com posicionamento personalizado
        doc.fromHTML(pageContent, 15, 15);

        // 6. Adicione um rodapé (opcional)
        doc.text(15, doc.internal.pageSize.height - 15, "Página " + doc.internal.getNumberOfPages());

        // 7. Salve ou abra o PDF
        doc.save('pagina.pdf');
    }

    // 8. Chame a função para adicionar o conteúdo da página ao PDF
    addPageContent();
});
</script>


</body>
</html>