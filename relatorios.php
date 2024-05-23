<?php
session_start();
    include 'conexao.php';
    include 'protect.php';
   
    $countSql = "SELECT COUNT(*) as total FROM agendamentos";
$countResult = $conexao->query($countSql);
$countRow = $countResult->fetch_assoc();
$totalAgendamentos = $countRow['total'];

   // Processa o formulário quando for enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['Salvar'])) {
        $id = $_POST["id"];
        $observacao = $_POST["observacao"];

        // Atualize a observação no banco de dados
        $sql = "UPDATE agendamentos SET observacao = '$observacao' WHERE id = $id";

        if ($conexao->query($sql) === TRUE) {
            echo "Observação atualizada com sucesso!";
        } else {
            echo "Erro ao atualizar a observação: " . $conexao->error;
        }
    } elseif (isset($_POST['Excluir'])) {
        $id = $_POST["id"];
    
        // Captura o nome do usuário antes de excluir a linha
        $usuarioExclusao = $_SESSION['usuario']; // Substitua 'nome_usuario' pela chave adequada em sua sessão
    
        // Consulta SQL para selecionar os dados da linha antes de excluir
        $selectSql = "SELECT * FROM agendamentos WHERE id = $id";
        $selectResult = $conexao->query($selectSql);
    
        if ($selectResult->num_rows > 0) {
            $rowToBackup = $selectResult->fetch_assoc();
    
            // Insira a linha no banco de backup com o nome do usuário
            $backupSql = "INSERT INTO agendamentos_backup (dataHora, protocolo, usuario, observacao, usuario_exclusao) 
                          VALUES ('" . $rowToBackup['dataHora'] . "', '" . $rowToBackup['protocolo'] . "', '" . $rowToBackup['usuario'] . "', '" . $rowToBackup['observacao'] . "', '$usuarioExclusao')";
            $backupResult = $conexao->query($backupSql);
    
            // Verifique se a inserção no backup foi bem-sucedida antes de excluir
            if ($backupResult) {
                // Exclua a linha do banco de dados principal
                $deleteSql = "DELETE FROM agendamentos WHERE id = $id";
    
                if ($conexao->query($deleteSql) === TRUE) {
                    echo "Registro excluído com sucesso!";
                } else {
                    echo "Erro ao excluir o registro: " . $conexao->error;
                }
            } else {
                echo "Erro ao fazer backup da linha.";
            }
        } else {
            echo "Linha não encontrada.";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatórios de Agendamentos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css">
    <style>
body {
    background-color:#000;
    color: #fff; /* Cor do texto clara */
    font-family: 'Fira Code', monospace; /* Use a fonte Fira Code para o texto */
}

.container {
    margin-top: 20px;
    background-color: #222; /* Fundo mais escuro para o conteúdo */
    padding: 20px;
    border-radius: 5px; /* Borda arredondada para o conteúdo */
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.5); /* Sombra mais escura */
}

h1 {
    color: #fff; /* Cor do título clara */
    font-family: 'Fira Code', monospace; /* Use a fonte Fira Code para o texto */
    font-size: 36px; /* Tamanho de fonte maior para o título */
}

.table {
    background-color: #444; /* Fundo mais escuro para a tabela */
    color: #fff; /* Cor do texto clara */
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.5); /* Sombra mais escura */
}

.btn-success {
    background-color: #5cb85c; /* Cor do botão de sucesso */
    color: #fff;
    border: none; /* Sem borda */
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2); /* Sombra sutil */
    font-family: 'Roboto', sans-serif; /* Fonte estilosa para os botões */
}

.btn-danger {
    background-color: #d9534f; /* Cor do botão de perigo */
    color: #fff;
    border: none; /* Sem borda */
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2); /* Sombra sutil */
    font-family: 'Roboto', sans-serif; /* Fonte estilosa para os botões */
}

.notification {
    background-color: #333; /* Cor de fundo escura para a notificação */
    color: #fff; /* Cor do texto da notificação clara */
}

footer {
    background-color: #333;
    color: #fff;
    padding: 20px 0;
    text-align: center;
    font-size: 16px;
    border-top: 1px solid #555; /* Linha superior */
    font-family: 'Lobster', cursive; /* Fonte estilosa para o rodapé */
    font-size: 18px; /* Tamanho de fonte maior para o rodapé */
}
/* Botão "Salvar" */
.btn-success {
    background-color: #007bff; /* Azul */
    color: #fff;
    border: none; /* Sem borda */
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2); /* Sombra sutil */
    font-family: 'Roboto', sans-serif; /* Fonte estilosa para os botões */
}

/* Botão "Excluir" */
.btn-danger {
    background-color: #dc3545; /* Vermelho */
    color: #fff;
    border: none; /* Sem borda */
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2); /* Sombra sutil */
    font-family: 'Roboto', sans-serif; /* Fonte estilosa para os botões */
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
    width: 40px;
    height: 40px;
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





    </style>
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        var rows = document.querySelectorAll(".table tbody tr");

        rows.forEach(function (row) {
            var cells = row.querySelectorAll("td");

            var dataHoraAgendada = cells[1].textContent.trim(); // Coluna que contém a data/hora agendada
            var protocolo = cells[2].textContent.trim(); // Coluna que contém o protocolo

            // Quebra a data e a hora em partes
            var partesDataHora = dataHoraAgendada.split(" ");
            var data = partesDataHora[0];
            var hora = partesDataHora[1];

            // Divide a data em partes
            var partesData = data.split("/");
            var dia = partesData[0];
            var mes = partesData[1] - 1; // Os meses em JavaScript são de 0 a 11
            var ano = partesData[2];

            // Divide a hora em partes
            var partesHora = hora.split(":");
            var horas = partesHora[0];
            var minutos = partesHora[1];

            // Cria um objeto de data JavaScript com a data e a hora
            var dataHoraAgendadaObj = new Date(ano, mes, dia, horas, minutos);

            // Obtém a data/hora atual do navegador
            var dataHoraAtual = new Date();

            // Verifica se a data/hora agendada já passou ou é a mesma
            if (dataHoraAgendadaObj <= dataHoraAtual) {
                // Se a data/hora agendada já passou ou é a mesma, exibe uma notificação pop-up
                var observacao = cells[3].querySelector("textarea").value; // Obtém a observação
                var mensagem = "Protocolo: " + protocolo + "\n" +
                    "Data e Hora Agendada: " + dataHoraAgendada + "\n" +
                    "Observação: " + observacao;

                if (Notification.permission === "granted") {
                    // Se a permissão de notificação já foi concedida, exibe a notificação
                    var notification = new Notification("Esta na hora!!!", {
                        body: mensagem
                    });
                } else if (Notification.permission !== "denied") {
                    // Se a permissão de notificação não foi negada, solicita a permissão
                    Notification.requestPermission().then(function (permission) {
                        if (permission === "granted") {
                            // Se o usuário conceder a permissão, exibe a notificação
                            var notification = new Notification("Seu agendamento chegou!!", {
                                body: mensagem
                            });
                        }
                    });
                }
            }
        });
    });
</script>

</head>
<body>
<div id="user-info">
    <h6><button onclick="mostrarFormulario()">
        <?= $_SESSION['usuario']; ?>
        <span>
            <?php
            $foto_path = "uploads/" . $_SESSION['id_usuario'] . "_foto.jpg";

            // Verifica se o arquivo da foto existe
            if (file_exists($foto_path)) {
                // Se existir, exibe a foto do usuário com um tamanho pequeno
                echo '<img src="' . $foto_path . '" alt="Foto do Usuário" style="width: 30px; height: 30px; border-radius: 50%;">';
            } else {
                // Se não existir, exibe uma imagem padrão com um tamanho pequeno
                echo '<img src="https://static.vecteezy.com/ti/vetor-gratis/p3/8302514-eps10-branco-usuario-icone-solido-ou-logotipo-em-simples-plano-moderno-estilo-isolado-em-fundo-preto-gratis-vetor.jpg" alt="Imagem Padrão" style="width: 30px; height: 30px; border-radius: 50%;">';
            }
            ?>
        </span>
    </button></h6>
    <a href="logout.php" class="logout-button">Sair</a>
</div>
<div class="container">
    <h1>Relatórios de Agendamentos</h1>
    <p>Total de Agendamentos: <?php echo $totalAgendamentos; ?></p>
    
    <!-- Resto do seu código HTML ... -->
</div>

<div id="dataHora"></div>


    
    <div class="container">
      

        <table class='table'>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Data e Hora</th>
                    <th>Protocolo</th>
                    <th>Usuário que agendou</th>
                    <th>Observação</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Consulta SQL para buscar agendamentos
                $sql = "SELECT id, DATE_FORMAT(dataHora, '%d/%m/%Y %H:%i') as dataHora, protocolo, usuario, observacao FROM agendamentos ORDER BY DATE(dataHora) ASC, TIME(dataHora) ASC";
                $result = $conexao->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
echo "<td>" . $row["id"] . "</td>";
echo "<td>" . $row['dataHora'] . "</td>";
echo "<td>" . $row["protocolo"] . "</td>";
echo "<td>" . $row["usuario"] . "</td>"; // Adicione esta linha para exibir a coluna "usuario"
echo "<td>";
echo "<form method='post' action=''>";
echo "<input type='hidden' name='id' value='" . $row["id"] . "'>";
echo "<textarea name='observacao'>" . $row["observacao"] . "</textarea>";
echo "</td>";
echo "<td>";
echo "<button type='submit' class='btn btn-success' name='Salvar'>Salvar</button>";
echo "</form>";
echo "<form method='post' action=''>";
echo "<input type='hidden' name='id' value='" . $row["id"] . "'>";
echo "<button type='submit' class='btn btn-danger' name='Excluir'>Excluir</button>";
echo "</form>";
echo "</td>";
echo "</tr>";
                    }
                } else {
                    echo "Nenhum agendamento encontrado.";
                }
                ?>
            </tbody>
        </table>
        <!-- Script JavaScript para copiar dados sem o ID -->
        <script>
document.addEventListener("DOMContentLoaded", function () {
    // Seleciona o botão de cópia
    var copiarBotao = document.getElementById("copiarDados");

    // Adiciona um ouvinte de evento de clique ao botão
    copiarBotao.addEventListener("click", function () {
        // Seleciona a tabela
        var table = document.querySelector(".table");

        // Obtém todas as linhas da tabela (exceto o cabeçalho)
        var rows = table.querySelectorAll("tbody tr");

        // Inicializa uma variável para armazenar os dados a serem copiados
        var dataToCopy = "Agendamentos-Digital\n\n";

        // Loop através das linhas da tabela
        rows.forEach(function (row) {
            // Obtém as células da linha (exceto a primeira célula que contém o ID)
            var cells = row.querySelectorAll("td:not(:first-child)");

            // Obtém o texto das células que você deseja copiar (Data e Hora, Protocolo)
            var dataHora = cells[0].textContent.trim();
            var protocolo = cells[1].textContent.trim();
            var usuario = cells[2].textContent.trim(); // Supondo que "Usuário" é a terceira coluna

            // Concatena os dados formatados ao texto
            dataToCopy += "Data e Hora: " + dataHora + ", Protocolo: " + protocolo + ",\n Usuário: " + usuario + "\n";
        });

        // Cria um elemento de texto oculto para copiar os dados
        var textArea = document.createElement("textarea");
        textArea.value = dataToCopy;
        document.body.appendChild(textArea);

        // Seleciona o texto na área de texto
        textArea.select();

        // Copia o texto para a área de transferência
        document.execCommand("copy");

        // Remove o elemento de texto oculto
        document.body.removeChild(textArea);

        // Exibe uma mensagem de sucesso
        alert("Dados copiados para a área de transferência");
    });
});
</script>


<script>
// Função para atualizar a página automaticamente a cada X segundos (defina o valor desejado em milissegundos)
function autoRefresh() {
    setTimeout(function () {
        location.reload(); // Recarrega a página
    }, 30000); // Atualize a cada 30 segundos (ajuste conforme necessário)
}

// Chame a função de atualização automática quando a página for carregada
window.addEventListener('load', autoRefresh);
</script>



        <!-- Resto do código HTML ... -->

        <?php
        // Fechar a conexão com o banco de dados
        $conexao->close();
        ?>
    </div>
    <!-- Resto do código HTML ... -->
<!-- Botão para copiar os dados para a área de transferência -->


<!-- Botão para voltar à página anterior (index.php) -->
<div class="text-center mt-3">
<button  id="copiarDados" class="btn btn-primary">Copiar Dados</button>
    <a href="agendadosSZ.php" class="btn btn-primary">Voltar</a>
</div>
<br>

<?php
// Fechar a conexão com o banco de dados
$conexao->close();
?>

<footer>
<p>&copy; 2023 Desenvolvido por <a href="https://www.linkedin.com/in/alecxandro-xavier-406a1a13a/" target="_blank">Alecx Xavier</a>.</p>
    </footer>
</body>

</html>
