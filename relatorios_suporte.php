<?php
session_start();
include 'conexao.php';
include 'protect.php';
// Conexão com o banco de dados (ajuste as informações conforme seu ambiente)
$servername = "ws4.altcloud.net.br";
$username = "ggnet_nocsz";
$password = "ae7$6bPiLz/gp#iF";
$dbname = "ggnet_nocsz";

// Cria uma conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

// Processa o formulário quando for enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['Salvar'])) {
        $id = $_POST["id"];
        $observacao = $_POST["observacao"];

        // Atualize a observação no banco de dados
        $sql = "UPDATE agendamentos_noc SET observacao = '$observacao' WHERE id = $id";

        if ($conn->query($sql) === TRUE) {
            echo "Observação atualizada com sucesso!";
        } else {
            echo "Erro ao atualizar a observação: " . $conn->error;
        }
    } elseif (isset($_POST['Excluir'])) {
        $id = $_POST["id"];

        // Exclua a linha do banco de dados
        $sql = "DELETE FROM agendamentos_noc WHERE id = $id";

        if ($conn->query($sql) === TRUE) {
            echo "Registro excluído com sucesso!";
        } else {
            echo "Erro ao excluir o registro: " . $conn->error;
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
    background-color: #333; /* Cor de fundo escura */
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
    background-color: #333;
    padding: 10px;
    border-radius: 5px;
    text-align: center;
    color: #fff; /* Cor do texto */
}

#user-info h6 {
    margin: 5px 0;
    color: #007bff; /* Cor do link */
}

#user-info a {
    text-decoration: none;
    color: #007bff; /* Cor do link */
}

#user-info img {
    max-width: 70px; /* Ajuste o tamanho da imagem conforme necessário */
    border-radius: 50%;
    margin: 10px 0;
}

.logout-button {
    background-color: #dc3545; /* Cor de fundo do botão de logout */
    color: #fff; /* Cor do texto do botão de logout */
    padding: 4px 10px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    text-decoration: none;
    font-size: 14px;
}

.logout-button:hover {
    background-color: #c82333; /* Cor de fundo do botão de logout ao passar o mouse */
}


    </style>
</head>
<body>
<div id="user-info">
    <h6><a href="editar_perfil.php"><?= $_SESSION['usuario']; ?></a></h6>

    <?php
        $foto_path = "uploads/" . $_SESSION['id_usuario'] . "_foto.jpg";

        // Verifica se o arquivo da foto existe
        if (file_exists($foto_path)) {
            // Se existir, exibe a foto do usuário
            echo '<img src="' . $foto_path . '" alt="Foto do Usuário">';
        } else {
            // Se não existir, exibe uma imagem padrão
            echo '<img src="https://static.vecteezy.com/ti/vetor-gratis/p3/8302514-eps10-branco-usuario-icone-solido-ou-logotipo-em-simples-plano-moderno-estilo-isolado-em-fundo-preto-gratis-vetor.jpg" alt="Imagem Padrão">';
        }
    ?>

    <a href="logout.php" class="logout-button">Sair</a>
</div>

    <div class="container">
        <h1>Relatórios de Agendamentos</h1>

        <table class='table'>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Data e Hora</th>
                    <th>Protocolo</th>
                    <th>Usuario</th>
                    <th>Observação</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Consulta SQL para buscar agendamentos
                $sql = "SELECT id, DATE_FORMAT(dataHora_noc, '%d/%m/%Y %H:%i') as dataHora_noc, Protocolo_noc, Observacao, nome_usuario FROM agendamentos_noc ORDER BY DATE(dataHora_noc) ASC, TIME(dataHora_noc) ASC";
                $result = $conn->query($sql);
                
                if ($result === FALSE) {
                    die("Erro na consulta: " . $conn->error);
                }
                
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td class='text-branco'>" . $row["id"] . "</td>";
                        echo "<td class='text-branco'>" . $row['dataHora_noc'] . "</td>";
                        echo "<td class='text-branco'>" . $row["Protocolo_noc"] . "</td>";
                        echo "<td class='text-branco'>" . $row["nome_usuario"] . "</td>"; // Adiciona o nome do usuário
                        echo "<td>";
                        echo "<form method='post' action=''>";
                        echo "<input type='hidden' name='id' value='" . $row["id"] . "'>";
                        echo "<textarea class='text-branco' name='observacao'>" . $row["Observacao"] . "</textarea>";
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

        <!-- Botão para copiar protocolos e datas com horários -->
        <div class="text-center mt-3">
            <button class="btn btn-primary" id="btnCopiar">Copiar atualização de grupo</button>
        </div>

    </div>

    <!-- Script JavaScript para copiar o conteúdo da tabela -->
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        document.getElementById("btnCopiar").addEventListener("click", function () {
            const table = document.querySelector(".table");
            const rows = table.querySelectorAll("tbody tr");
            let texto = "Agendamentos NOC-Suporte\n\n";

            rows.forEach(function (row) {
                const columns = row.querySelectorAll("td");
                texto += `Data e Hora: ${columns[1].textContent}, Protocolo: ${columns[2].textContent}, \n Usuário: ${columns[3].textContent}\n`;
            });

            const textarea = document.createElement("textarea");
            textarea.value = texto;
            document.body.appendChild(textarea);
            textarea.select();
            document.execCommand("copy");
            document.body.removeChild(textarea);

            alert("Dados foram copiados para a área de transferência!");
        });
    });
</script>

















    <!-- Resto do código HTML ... -->

    <!-- Botão para voltar à página anterior (index.php) -->
    <div class="text-center mt-3">
        <a href="agendado_noc_suporte.php" class="btn btn-primary">Voltar</a>
    </div>

    <?php
    // Fechar a conexão com o banco de dados
    $conn->close();
    ?>

    <footer>
        <p>&copy; 2023 Desenvolvido por <a href="https://codeversesolutions.com.br">Alecx Xavier</a>.</p>
    </footer>

</body>
</html>
