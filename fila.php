<?php
session_start();

// Verifica se o usuário está logado, caso contrário, redireciona para a página de login
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

// Conecte-se ao banco de dados
$server = 'ws4.altcloud.net.br';
$usuario = 'ggnet_nocsz';
$senha = 'ae7$6bPiLz/gp#iF';
$base = 'ggnet_nocsz';

$conexao = mysqli_connect($server, $usuario, $senha, $base);

// Verifique a conexão
if (!$conexao) {
    die("Erro na conexão com o banco de dados: " . mysqli_connect_error());
}

// Função para obter a lista de clientes na fila
function obterFila($conexao) {
    $sql = "SELECT nome_cliente, data_hora_entrada FROM fila ORDER BY data_hora_entrada";
    $resultado = mysqli_query($conexao, $sql);

    $fila = array();

    while ($row = mysqli_fetch_assoc($resultado)) {
        $fila[] = $row;
    }

    return $fila;
}

// Função para passar a vez para o próximo cliente na fila
function passarAVez($conexao) {
    $sql = "SELECT nome_cliente FROM fila ORDER BY data_hora_entrada LIMIT 1";
    $resultado = mysqli_query($conexao, $sql);

    if ($row = mysqli_fetch_assoc($resultado)) {
        $nome_cliente = $row['nome_cliente'];
        $sql = "DELETE FROM fila WHERE nome_cliente = '$nome_cliente'";
        if (mysqli_query($conexao, $sql)) {
            $sql = "INSERT INTO fila (nome_cliente) VALUES ('$nome_cliente')";
            if (mysqli_query($conexao, $sql)) {
                return $nome_cliente;
            }
        }
    }
    return false;
}

// Verifica se o botão "Entrar na fila" foi clicado
if (isset($_POST['entrar_na_fila'])) {
    // Obtém o nome do cliente a partir da sessão
    $nome_cliente = $_SESSION['usuario'];

    // Verifica se o cliente já está na fila antes de inseri-lo novamente
    $sql = "SELECT nome_cliente FROM fila WHERE nome_cliente = '$nome_cliente'";
    $resultado = mysqli_query($conexao, $sql);

    if (mysqli_num_rows($resultado) == 0) {
        // O cliente não está na fila, então podemos adicioná-lo
        $sql = "INSERT INTO fila (nome_cliente) VALUES ('$nome_cliente')";
        
        if (mysqli_query($conexao, $sql)) {
            echo "Você entrou na fila com sucesso!";
        } else {
            echo "Erro ao entrar na fila: " . mysqli_error($conexao);
        }
    } else {
        // O cliente já está na fila
        echo "Você já está na fila!";
    }
}

// Verifica se o botão "Sair da fila" foi clicado
if (isset($_POST['sair_da_fila'])) {
    // Obtém o nome do cliente a partir da sessão
    $nome_cliente = $_SESSION['usuario'];

    // Remove o nome do cliente da fila
    $sql = "DELETE FROM fila WHERE nome_cliente = '$nome_cliente'";
    if (mysqli_query($conexao, $sql)) {
        echo "Você saiu da fila com sucesso!";
    } else {
        echo "Erro ao sair da fila: " . mysqli_error($conexao);
    }
}

// Obtém a lista de clientes na fila
$listaFila = obterFila($conexao);

// Obtém o nome do cliente da vez na fila
$clienteDaVez = current($listaFila);

// Verifica se o usuário atual é o próximo na fila
$mostrarBotao = ($_SESSION['usuario'] == $clienteDaVez['nome_cliente']);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Fila SZ.chat</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="fila.css">
    <style>
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

    <div class="container mt-5">
        <h1 class="text-center">Bem-vindo à fila SZ.chat</h1>
        <div class="text-center mt-3">
            <span id="usuario-nome" class="linha-comando-animacao"></span>
        </div>

        <form method="post" class="text-center mt-3">
            <button type="submit" name="entrar_na_fila" class="btn btn-primary">Entrar na fila</button>
            <button type="submit" name="sair_da_fila" class="btn btn-danger">Sair da fila</button>
           
            <?php
            if ($mostrarBotao) {
                // O botão será exibido apenas para o usuário da vez
                echo '<button type="submit" name="passar_a_vez" class="btn btn-success">Passar a vez</button>';
            }
            ?>
        </form>
        
        <h2 class="text-center mt-4">Atendentes na fila:</h2>
        <div id="conteudoParaAtualizar">
        <ul class="list-group mt-2" id="fila-list">
            <?php
            foreach ($listaFila as $cliente) {
                $classeCSS = ($cliente == $clienteDaVez) ? 'list-group-item list-group-item-warning' : 'list-group-item';
                echo "<li class='$classeCSS'>$cliente[nome_cliente] (Entrou em: $cliente[data_hora_entrada])</li>";
            }
            ?>
            </div>
        </ul>
    </div>
    <script>
        // Atualizar a fila com JavaScript
        var filaList = document.getElementById('fila-list');

        function atualizarFila() {
            fetch('atualizar_fila.php')
                .then(response => response.text())
                .then(data => {
                    filaList.innerHTML = data;
                });
        }

        // Chame a função de atualização quando a página é carregada
        atualizarFila();

        // Atualize a fila quando o usuário clicar em "Passar a vez"
        document.querySelector('button[name="passar_a_vez"]').addEventListener('click', function() {
            fetch('passar_a_vez.php')
                .then(response => response.text())
                .then(data => {
                    if (data === 'success') {
                        atualizarFila();
                    }
                });
        });
    </script>
    <!-- Adicione este código JavaScript no final do seu arquivo HTML -->

    <script>
        function atualizarPagina() {
            location.reload();
        }

        // Atualiza a página a cada 5 segundos
        setInterval(atualizarPagina, 6000); // 5000 milissegundos = 5 segundos
    </script>
    <script>
        const nomeUsuario = "<?php echo $_SESSION['usuario']; ?>";
        const spanUsuario = document.getElementById("usuario-nome");
        let i = 0;

        function typeUsername() {
            if (i < nomeUsuario.length) {
                spanUsuario.textContent += nomeUsuario.charAt(i);
                i++;
                setTimeout(typeUsername, 100); // Ajuste o tempo entre as letras digitadas
            }
        }

        typeUsername();
    </script>
</body>
</html>

<?php
// Fecha a conexão com o banco de dados
mysqli_close($conexao);
?>
