<?php
    include 'conexao.php'; //Include de conexao com o Banco de dados
    include 'protect.php'; //Include utilizado para não deixar o usuário entrar nas páginas sem utilizar o login

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NOC-<?= $_SESSION['usuario']; ?></title>
    <!-- Inclua o Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="home.css">
    <style>
 

    </style>
    <link rel="icon" href="data:image/png;base64,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" type="image/x-icon">
</head>
<body>
    
<?php
// Inicie ou retome a sessão
session_start();

// Verifique se o usuário está logado
if (isset($_SESSION['usuario_id'])) {
    $usuario_id = $_SESSION['usuario_id'];

    // Consulta SQL para buscar o nome do usuário pelo ID
    $sql = "SELECT nome FROM usuarios WHERE id = $usuario_id";

    // Execute a consulta
    $result = $conn->query($sql);

    // Verifique se a consulta foi bem-sucedida
    if ($result->num_rows > 0) {
        // Extrai os dados do resultado
        $row = $result->fetch_assoc();
        $nomeUsuario = $row['nome'];

        // Exibe o nome do usuário no topo da página
        echo '<div id="user">Usuário logado: ' . $nomeUsuario . '</div>';
    }
}
?>

<div class="title-container">
    <h1>NOC-Ferramentas</h1>
    <h3 class="blinking-cursor">|</h3>
    </div>
    <svg xmlns="http://www.w3.org/2000/svg" height="1em" width="1em" viewBox="0 0 448 512">
    <!-- Seu código SVG -->
</svg>
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
<!-- card_upload_foto.php -->
<?php
// Inicie a sessão
session_start();

// Configuração do banco de dados
$server = 'ws4.altcloud.net.br';
$usuario = 'ggnet_nocsz';
$senha = 'ae7$6bPiLz/gp#iF';
$base = 'ggnet_nocsz';

// Conexão com o banco de dados
$conn = new mysqli($server, $usuario, $senha, $base);

// Verifica a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Verifica se o usuário está logado
if (!isset($_SESSION['id_usuario'])) {
    die("Usuário não está logado. Redirecionando para a página de login...");
    // Pode redirecionar para a página de login ou realizar outras ações apropriadas.
}

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['foto'])) {
    // Diretório para salvar as fotos (certifique-se de que o diretório tem permissões de escrita)
    $diretorio_destino = 'uploads/';

    // Id do usuário logado
    $id_usuario = $_SESSION['id_usuario'];

    // Gera um nome único para a foto usando o nome do usuário logado
    $nome_foto = $id_usuario . '_foto.' . pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);

    // Move a foto para o diretório de destino
    move_uploaded_file($_FILES['foto']['tmp_name'], $diretorio_destino . $nome_foto);

    // Insere no banco de dados associando a foto ao usuário logado
    $sql = "UPDATE usuarios SET foto = '$nome_foto' WHERE id = $id_usuario";
    if ($conn->query($sql) === TRUE) {
        echo "Foto salva com sucesso.";
    } else {
        echo "Erro ao salvar a foto no banco de dados: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload de Foto</title>
    <style>
        body {
            color: #fff;
            font-family: Arial, sans-serif;
        }

        .card {
            background-color: #444;
            padding: 20px;
            border-radius: 10px;
            margin: 20px;
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input {
            margin-bottom: 10px;
        }

        input[type="file"] {
            color: transparent;
        }

        input[type="submit"] {
            background-color: #00f;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div id="formularioUpload" class="card" style="display: none;">
    <form action="" method="post" enctype="multipart/form-data">
        <label for="foto">Escolha uma foto:</label>
        <input type="file" name="foto" id="foto" accept="image/*" required>
        <br>
        <input type="submit" value="Enviar Foto">
    </form>
</div>

<script>
    function mostrarFormulario() {
        var formulario = document.getElementById('formularioUpload');
        formulario.style.display = 'block';
    }
</script>

</body>
</html>




<?php
// Sua conexão com o banco de dados (substitua as informações conforme necessário)
$host = "ws4.altcloud.net.br";
$usuario_bd = "ggnet_nocsz";
$senha_bd = "ae7$6bPiLz/gp#iF";
$nome_bd = "ggnet_nocsz";

$conn = new mysqli($host, $usuario_bd, $senha_bd, $nome_bd);

// Verificar se houve algum erro na conexão
if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

// Verificar se o nome de usuário está na lista permitida
$usuario = $_SESSION['usuario'];

// Consultar o banco de dados para obter as permissões do usuário
$query = "SELECT permissao FROM usuarios WHERE nome = '$usuario'";

$result = $conn->query($query);

if ($result) {
    $row = $result->fetch_assoc();
    $permissao = $row['permissao'];

    // Verificar se o usuário tem a permissão "admin"
    if ( $permissao == 'dev' || $permissao == 'usuario_comum' || $permissao == 'admin' ) {
        ?>
        <div id="menu">
        <div  id="title">NOC</div>      
        <div class="menu-row">
            
        <div class="menu-item">
                <a href="https://nocsz.gegnet.com.br/agendadosSZ" target="_blank">
                    <img src="https://img.freepik.com/vetores-premium/icone-de-calendario-em-estilo-simples-ilustracao-vetorial-de-agenda-em-fundo-branco-isolado-conceito-de-negocios-de-planejador-de-agenda_157943-2476.jpg" alt="Agendados SZ" class="icone-agendados">
                    <span>Agendados SZ.CHAT</span>
                </a>
            </div>
            <div class="menu-item">
                <a href="https://nocsz.gegnet.com.br/agendado_noc_suporte" target="_blank">
                    <img src="https://cdn.icon-icons.com/icons2/37/PNG/512/clock_theapplication_2900.png" alt="Agendados SZ" class="icone-nocsuporte">
                    <span>Agendados NOC suporte</span>
                </a>
            </div>
            <div class="menu-item">
                <a href="https://nocsz.gegnet.com.br/ligações_perdidas" target="_blank">
                    <img src="https://cdn-icons-png.flaticon.com/512/2228/2228048.png" alt="Agendados SZ" class="icone-nocsuporte">
                    <span>ligações perdidas</span>
                </a>
            </div>           
            <div class="menu-item">
                <a href="fila" target="_blank">
                    <img src="https://cdn-icons-png.flaticon.com/512/6009/6009580.png" alt="Planilha de  Ligações Perdidas" class="icone-agendados">
                    <span>Fila SZ.CHAT</span>
                </a>
            </div>
            </div>
            </div>
            <?php
// Sua conexão com o banco de dados (substitua as informações conforme necessário)
$host = "ws4.altcloud.net.br";
$usuario_bd = "ggnet_nocsz";
$senha_bd = "ae7$6bPiLz/gp#iF";
$nome_bd = "ggnet_nocsz";

$conn = new mysqli($host, $usuario_bd, $senha_bd, $nome_bd);

// Verificar se houve algum erro na conexão
if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

// Verificar se o nome de usuário está na lista permitida
$usuario = $_SESSION['usuario'];

// Consultar o banco de dados para obter as permissões do usuário
$query = "SELECT permissao FROM usuarios WHERE nome = '$usuario'";

$result = $conn->query($query);

if ($result) {
    $row = $result->fetch_assoc();
    $permissao = $row['permissao'];

    // Verificar se o usuário tem a permissão "admin"
    if ($permissao == 'usuario_comum' || $permissao == 'admin' || $permissao == 'superadmin' || $permissao == 'dev') {
    echo '<div id="menu">';
    echo '<h4>Área do Conhecimento</h4>';
    echo '<div class="menu-row">';//div que abre a separação para ferramentas admin

    echo '<div class="menu-item">';
    echo '<a href="https://sites.google.com/view/ggnetwiki/bem-vindo?authuser=1" class="button" target="_blank">';
    echo '<img src="https://cdn.icon-icons.com/icons2/70/PNG/512/wikipedia_14084.png" alt="Agendados SZ" class="icone-agendados">';
    echo '<span>WIKI-NOC</span>';
    echo '</a>';
    echo '</div>'; 

    echo '<div class="menu-item">';
    echo '<a href="https://ead.datacom.com.br/login/index.php" class="button" target="_blank">';
    echo '<img src="https://media.licdn.com/dms/image/C4D0BAQHxLLTFm_gZNg/company-logo_200_200/0/1630573141086/datacom_teracom_logo?e=2147483647&v=beta&t=xDq2Bgjrwzpzv_ofPxrOR-fXsGk7OupsDZSzUa8XnHc" alt="Agendados SZ" class="icone-agendados">';
    echo '<span>EAD-DATACOM</span>';
    echo '</a>';
    echo '</div>'; 

    echo '<div class="menu-item">';
    echo '<a href="https://cursoseventos.nic.br/cursos/cursosonline/" class="button" target="_blank">';
    echo '<img src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/7c/NIC.br_logo.svg/640px-NIC.br_logo.svg.png" alt="Agendados SZ" class="icone-agendados">';
    echo '<span>Curso Online NIC.BR</span>';
    echo '</a>';
    echo '</div>'; 

    echo '<div class="menu-item">';
    echo '<a href="https://ggnet.cademi.com.br/auth/login?redirect=%2Farea%2Fvitrine" class="button" target="_blank">';
    echo '<img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSCq7Sz3xGbSj8U8greoYlHwVPyoL4Sk4sb2wyyYmXtng&s" alt="Agendados SZ" class="icone-agendados">';
    echo '<span>Academia GGnet</span>';
    echo '</a>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
}
// Fechar a conexão com o banco de dados
$conn->close();
} else {
   echo 'Erro na consulta ao banco de dados: ' . $conn->error;
}

?>
            
            <div id="menu">
            <div  id="title">Outros</div>  
            <div class="menu-row">
            <div class="menu-item">
                <a href="https://ggnet.gcommit.com.br/login" target="_blank">
                    <img src="https://ggnet.gcommit.com.br/assets/img/logo.png" alt="Gcommit" class="icone-agendados">
                    <span>gCOMMIT</span>
                </a>
            </div>
            <div class="menu-item">
                <a href="https://plutao.geogridmaps.com.br/ggnet/" target="_blank">
                    <img src="https://eros.geogridmaps.com.br/acessoline/geogridlayout/imagensLogin/nova-logo.png" alt="Ícone do Programa 2" class="icone-agendados">
                    <span>Geogrid</span>
                </a>
            </div>
            <div class="menu-item">
                <a href="http://grafana.acessoline.net.br/login" target="_blank">
                    <img src="https://www.ambientelivre.com.br/media/k2/items/cache/218fa54275e0e31c37b4e5091d9112ba_L.jpg" alt="Ícone do Programa 4" class="icone-agendados">
                    <span>Grafana</span>
                </a>
            </div>
            <div class="menu-item">
                <a href="https://187.85.152.170:8060/#/home" target="_blank">
                    <img src="https://cdn.icon-icons.com/icons2/2236/PNG/512/file_log_format_type_icon_134704.png" alt="" class="icone-agendados">
                    <span>ISP TI LOGS</span>
                </a>
            </div>
            <div class="menu-item">
                <a href="https://srv-rad-01.gegnet.net.br/login" target="_blank">
                <a href="javascript:void(0);" onclick="exibirLoginCard('https://srv-rad-01.gegnet.net.br/login', 'gegnet', 'pfU02U9S0BfNEKRk')">
                    <img src="https://srv-rad-01.gegnet.net.br/public/img/grafana_icon.svg" alt="Agendados SZ" class="icone-agendados">
                    <span>PrimeAuth Dashboard</span>
                </a>
            </div>
            <div class="menu-item">
                <a href="https://integrator6.gegnet.com.br/#/app" target="_blank">
                    <img src="https://integrator6.gegnet.com.br/assets/img/integrator6.png" alt="Ícone do Programa 3" class="icone-agendados">
                    <span>Integrator 6 GGNET</span>
                </a>
            </div>
           <div class="menu-item">
                <a href="https://zbx.gegnet.com.br/zabbix.php?show=1&name=&severities%5B3%5D=3&severities%5B4%5D=4&severities%5B5%5D=5&inventory%5B0%5D%5Bfield%5D=type&inventory%5B0%5D%5Bvalue%5D=&evaltype=0&tags%5B0%5D%5Btag%5D=&tags%5B0%5D%5Boperator%5D=0&tags%5B0%5D%5Bvalue%5D=&show_tags=3&tag_name_format=0&tag_priority=&compact_view=1&filter_name=&filter_show_counter=0&filter_custom_time=0&sort=clock&sortorder=DESC&age_state=0&show_symptoms=0&show_suppressed=0&unacknowledged=0&details=0&highlight_row=0&action=problem.view" target="_blank">
                    <img src="https://made4it.com.br/wp-content/uploads/2020/10/zabbix_logo_500x131.png" alt="Ícone do Programa 5" class="icone-agendados">
                    <span>Zabbix</span>
                </a>
            </div>
            <div class="menu-item">
                <a href="https://www.google.com/maps/d/u/0/viewer?mid=1Sj-SHuzbT985N3yjpDsEe0pMN0aBwM8&ll=-26.23654462653357%2C-51.04796141929931&z=13" target="_blank">
                    <img src="https://cdn-icons-png.flaticon.com/512/235/235861.png" alt="Ícone do Programa 5" class="icone-agendados">
                    <span>Lojas GGNET</span>
                </a>
            </div>

            <div class="menu-item">
                <a href="https://unifi.gegnet.com.br:8443" target="_blank">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSCq7Sz3xGbSj8U8greoYlHwVPyoL4Sk4sb2wyyYmXtng&s" alt="Ícone do Programa 5" class="icone-agendados">
                    <span>UNIFI-GGNET</span>
                </a>
            </div>
            
            <div class="menu-item">
                <a href="http://myisp.gegnet.com.br/MyIspWeb/admin/index.jsp" target="_blank">
                    <img src="https://cdn-icons-png.flaticon.com/512/630/630886.png" alt="MYisp GGnet" class="icone-agendados">
                    <span>MYISP GGNET</span>
                </a>
            </div>          
           
            
            <div class="menu-item">
                <a href="https://unifi.infopasa.net.br:8443/manage/account/login?redirect=%2Fmanage%2Fsite%2F3wqtxnv1%2Fdevices%2F1%2F50" target="_blank">
                <a href="javascript:void(0);" onclick="exibirLoginCard('https://unifi.infopasa.net.br:8443/manage/account/login?redirect=%2Fmanage%2Fsite%2F3wqtxnv1%2Fdevices%2F1%2F50', 'infopasa', 'Info4219Pasa.')">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS_Kej4CUUvPp6HuWQ7E5oV7NuBLkvPsNK-wg&usqp=CAU" alt="Agendados SZ" class="icone-agendados">
                    <span>Unifi Infopasa</span>
                </a>
            </div>
            <div class="menu-item">
                <a href="javascript:void(0);" onclick="exibirLoginCard('https://omada.tplinkcloud.com/login', 'ips@infopasa.com.br', 'Infopasa@2020')">
                    <img src="https://play-lh.googleusercontent.com/FW3wu85sc7EtgSnPoCY_NBQq4yeB0ZcUL62dkruhcDTs7u3OsnbGL0-mzFMiGbmiaw=w600-h300-pc0xffffff-pd" alt="Agendados SZ" class="icone-agendados">
                    <span>Omada TP-link</span>
                </a>
            </div>
            
            
            <div class="menu-item">
                <a href="https://ggnet.sz.chat/" target="_blank">
                    <img src="https://play-lh.googleusercontent.com/fvozbxumHSsM5EZLpXGAnGMp5JT3QiRzcn42h9Dwo8l8gFKJ3D_vUsGcDSL5VdgodN8" alt="Ícone do Programa 6" class="icone-agendados">
                    <span>SZ.CHAT</span>
                </a>
            </div>
          
            
            <div class="menu-item">
                <a href="https://manutencao.gegnet.com.br/indexNovo.php?page=dashboard" target="_blank">
                    <img src="https://png.pngtree.com/png-vector/20210927/ourmid/pngtree-maintenance-icon-flat-png-image_3958973.png" alt="Agendados SZ" class="icone-agendados">
                    <span>Manutenções</span>
                </a>
            </div>
            <div class="menu-item">
                <a href="https://glpi.gegnet.com.br/" target="_blank">
                    <img src="https://static.vecteezy.com/ti/vetor-gratis/p3/14528287-icone-do-administrador-de-ti-estilo-simples-vetor.jpg" alt="Agendados SZ" class="icone-agendados">
                    <span>Chamados TI</span>
                </a>
            </div>
            <div id="loginCard">
    <p>Login: <span id="login">seu_login</span></p>
    <p>Senha: <span id="senha">sua_senha</span></p>
    <button onclick="ocultarLoginCard()">Fechar</button>
</div>
        </div>
        </div>  
        </div>
    </div>
    <?php
    } // Fim do bloco if de permissão
} // Fim do bloco if de resultado
?>
 
 <?php
include('home2.php');
?>


    </div>

    <!-- Inclua o Bootstrap JS e jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" ></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Inclua o FontAwesome para ícones -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <BR></BR>
    <script>
    // Função para exibir o cartão de login e redirecionar para o link
    function exibirLoginCard(link, login, senha) {
        document.getElementById('login').innerText = login;
        document.getElementById('senha').innerText = senha;
        document.getElementById('loginCard').style.display = 'block';

        setTimeout(function() {
            window.location.href = link;
        }, 2000); //definido para 2 segundos direcionar para a pagina 
    }

    // Função para ocultar o cartão de login
    function ocultarLoginCard() {
        document.getElementById('loginCard').style.display = 'none';
    }
</script>


    <footer>
    <p>&copy; 2023 Desenvolvido por <a href="https://www.linkedin.com/in/alecxandro-xavier-406a1a13a/" target="_blank">Alecx Xavier</a>.</p>

    </footer>
</body>
</html>
