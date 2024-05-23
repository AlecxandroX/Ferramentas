<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    

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
    if ($permissao == 'admin' || $permissao == 'superadmin' || $permissao == 'dev') {
    echo '<div id="menu">';
    echo '<h4> Ferramentas Supervisores</h4>';
    echo '<div class="menu-row">';//div que abre a separação para ferramentas admin


    echo '<div class="menu-item">';
    echo '<a href="relatorios_perdidas.php" class="button" target="_blank">';
    echo '<img src="https://cdn-icons-png.flaticon.com/512/4024/4024382.png" alt="Agendados SZ" class="icone-agendados">';
    echo '<span>Relatórios ligações perdidas</span>';
    echo '</a>';
    echo '</div>';

    echo '<div class="menu-item">';
    echo '<a href="backup_agendadosSZ.php" class="button" target="_blank">';
    echo '<img src="https://static.vecteezy.com/ti/vetor-gratis/p3/6070687-estilo-de-icone-de-backup-de-dados-gratis-vetor.jpg" alt="Agendados SZ" class="icone-agendados">';
    echo '<span>Backup agendados SZ</span>';
    echo '</a>';
    echo '</div>';

    echo '<div class="menu-item">';
    echo '<a href="grafico_perdidas.php" class="button" target="_blank">';
    echo '<img src="https://png.pngtree.com/png-vector/20190916/ourlarge/pngtree-graph-icon-for-your-project-png-image_1731094.jpg" alt="Agendados SZ" class="icone-agendados">';
    echo '<span>Percentual Ligações Perdidas</span>';
    echo '</a>';
    echo '</div>';

    echo '<div class="menu-item">';
    echo '<a href="grafico_agendados.php" class="button" target="_blank">';
    echo '<img src="https://w7.pngwing.com/pngs/300/918/png-transparent-chart-computer-icons-analytics-growth-icon-infographic-angle-text.png" alt="Agendados SZ" class="icone-agendados">';
    echo '<span>Usuarios que mais chamam clientes agendados</span>';
    echo '</a>';
    echo '</div>';

    echo '<div class="menu-item">';
    echo '<a href="registro.php" class="button" target="_blank">';
    echo '<img src="https://cdn-icons-png.flaticon.com/512/72/72648.png" alt="Agendados SZ" class="icone-agendados">';
    echo '<span>Registro novo usuario</span>';
    echo '</a>';
    echo '</div>';

    echo '<div class="menu-item">';
    echo '<a href="usuarios.php" class="button" target="_blank">';
    echo '<img src="https://icones.pro/wp-content/uploads/2021/02/icone-utilisateur-gris.png" alt="Agendados SZ" class="icone-agendados">';
    echo '<span>Usuarios</span>';
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
    if ($permissao == 'superadmin' || $permissao == 'dev' || $permissao == 'CS'|| $permissao == 'gestor'  || $permissao == 'admin') {
    echo '<div id="menu">';
    echo '<h4> Ferramentas Monitoria de O.Ss </h4>';
    echo '<div class="menu-row">';//div que abre a separação para ferramentas admin
    echo '<div class="menu-item">';
    echo '<a href="ranking_tecnico.php" class="button" target="_blank">';
    echo '<img src="https://cdn-icons-png.flaticon.com/512/1794/1794481.png" alt="Agendados SZ" class="icone-agendados">';
    echo '<span>Graficos de OS</span>';
    echo '</a>';
    echo '</div>';

    echo '<div class="menu-item">';
    echo '<a href="relatorio_vistoria.php" class="button" target="_blank">';
    echo '<img src="https://w7.pngwing.com/pngs/360/811/png-transparent-computer-icons-distribution-audit-miscellaneous-text-rectangle.png" alt="Agendados SZ" class="icone-agendados">';
    echo '<span>Relatorio vistoria</span>';
    echo '</a>';
    echo '</div>';

    echo '<div class="menu-item">';
    echo '<a href="percentual_tecnico.php" class="button" target="_blank">';
    echo '<img src="https://cdn.icon-icons.com/icons2/37/PNG/512/percentage_3932.png" alt="Agendados SZ" class="icone-agendados">';
    echo '<span>Percentual Tecnico</span>';
    echo '</a>';
    echo '</div>';

    echo '<div class="menu-item">';
    echo '<a href="vistorias.php" class="button" target="_blank">';
    echo '<img src="https://cdn-icons-png.flaticon.com/512/88/88450.png" alt="Agendados SZ" class="icone-agendados">';
    echo '<span>Formulario vistoria OS</span>';
    echo '</a>';
    echo '</div>';

    echo '<div class="menu-item">';
    echo '<a href="atendimento_incorretos.php" class="button" target="_blank">';
    echo '<img src="https://cdn-icons-png.flaticon.com/512/3801/3801544.png" alt="Agendados SZ" class="icone-agendados">';
    echo '<span>Atendimentos incorretos</span>';
    echo '</a>';
    echo '</div>';
  
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
    if ($permissao == 'superadmin' || $permissao == 'dev' || $permissao == 'CS') {
    echo '<div id="menu">';
    echo '<h4> Ferramentas CS </h4>';
    echo '<div class="menu-row">';//div que abre a separação para ferramentas admin

    echo '<div class="menu-item">';
    echo '<a href="graficos_reincidencia.php" class="button" target="_blank">';
    echo '<img src="https://png.pngtree.com/png-vector/20190916/ourlarge/pngtree-graph-icon-for-your-project-png-image_1731094.jpg" alt="Agendados SZ" class="icone-agendados">';
    echo '<span>Graficos Reincidencias</span>';
    echo '</a>';
    echo '</div>';

    echo '<div class="menu-item">';
    echo '<a href="reincidencia.php" class="button" target="_blank">';
    echo '<img src="https://png.pngtree.com/png-vector/20190916/ourlarge/pngtree-graph-icon-for-your-project-png-image_1731094.jpg" alt="Agendados SZ" class="icone-agendados">';
    echo '<span>Formulario Reincidencias</span>';
    echo '</a>';
    echo '</div>';

    echo '<div class="menu-item">';
    echo '<a href="https://docs.google.com/spreadsheets/d/1Qk31yt0AcBaLFiqfbY35V1zDvBkWh7_AZt6B-IRLGyo/edit#gid=0" class="button" target="_blank">';
    echo '<img src="https://cdn.icon-icons.com/icons2/1377/PNG/512/xofficespreadsheet_92797.png" alt="Agendados SZ" class="icone-agendados">';
    echo '<span>2023_Elogios e Reclamações</span>';
    echo '</a>';
    echo '</div>';

    echo '<div class="menu-item">';
    echo '<a href="https://docs.google.com/spreadsheets/d/19G2-Uzi6dm6alzr6IA79nlKzZFvtUkdT5rENN9jJMz8/edit?resourcekey#gid=1178776105" class="button" target="_blank">';
    echo '<img src="https://img.freepik.com/vetores-gratis/medidor-de-satisfacao-emoji-pequeno_78370-2020.jpg?size=626&ext=jpg&ga=GA1.1.1395880969.1709424000&semt=sph" alt="Agendados SZ" class="icone-agendados">';
    echo '<span>Pesquisa de Satisfação com o Suporte (respostas)</span>';
    echo '</a>';
    echo '</div>';


    echo '<div class="menu-item">';
    echo '<a href="https://docs.google.com/spreadsheets/d/1RGXGs8i8PzkjBGwGJ6UTALMNPzOcu7UmfRtuZ9LIrF0/edit#gid=259750165" class="button" target="_blank">';
    echo '<img src="https://img2.gratispng.com/20180505/kfw/kisspng-proofreading-computer-icons-organization-pest-control-5aed999acc6296.9746734815255207948372.jpg" alt="Agendados SZ" class="icone-agendados">';
    echo '<span>Notas SZ.CHAT</span>';
    echo '</a>';
    echo '</div>';

    echo '<div class="menu-item">';
    echo '<a href="https://docs.google.com/spreadsheets/d/1FWnvsBKyDP1T7SYWHt2DYEk4qwaFCxAlPKUO5AryLrw/edit#gid=425356256" class="button" target="_blank">';
    echo '<img src="https://infovestibular.examtime.com/files/2014/10/Elegant_circle-icons-78.png" alt="Agendados SZ" class="icone-agendados">';
    echo '<span>Notas Financeiro</span>';
    echo '</a>';
    echo '</div>';

    echo '<div class="menu-item">';
    echo '<a href="https://docs.google.com/spreadsheets/d/12jE4J5eZsXcX5ZSOjmm8rwFFzwjuvi9mj8LXnygVKGk/edit#gid=486791788" class="button" target="_blank">';
    echo '<img src="https://cdn-icons-png.flaticon.com/512/2810/2810993.png" alt="Agendados SZ" class="icone-agendados">';
    echo '<span>Motivos de Abertura</span>';
    echo '</a>';
    echo '</div>';


   

    echo '<div class="menu-item">';
    echo '<a href="relatorio_reincidencia.php" class="button" target="_blank">';
    echo '<img src="https://i.pinimg.com/originals/92/35/5e/92355e509208cfa8bc7a912d134a6bf9.png" alt="Agendados SZ" class="icone-agendados">';
    echo '<span>Relatorio Reincidencias</span>';
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
</body>
</html>