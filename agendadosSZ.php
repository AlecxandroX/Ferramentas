<?php
    include 'conexao.php'; // Include de conexão com o Banco de dados
    include 'protect.php'; // Include utilizado para não deixar o usuário entrar nas páginas sem utilizar o login
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendados SZ.CHAT</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="icon" href="https://cdn-icons-png.flaticon.com/512/2693/2693507.png" type="image/x-icon">

    <!-- Importando o arquivo do jQuery -->
    <script src="jquery.min.js"></script>
    <script src="notificacoes.js"></script>

    <!-- Estilos CSS para personalização -->
    <style>
        body {
          background-color:#000;
            color: #fff; /* Cor do texto */
        }
        .formulario {
            background-color: #333; /* Cor de fundo do formulário */
            border: 1px solid #666; /* Cor da borda do formulário */
        }

        .tituloTabela {
            background-color: #333; /* Cor de fundo do título da tabela */
            border-bottom: 1px solid #666; /* Cor da borda inferior do título da tabela */
        }
      #user-info {
    position: absolute;
    top: 10px; /* Distância do topo */
    right: 10px; /* Distância da direita */
    display: flex;
    align-items: center;
}
.card-protocolos-atrasados {
    height: 250px;
    overflow-y: scroll;
}

.card-protocolos-atrasados table td {
    color: #fff; /* Cor do texto dentro das células da tabela */
}


.logout-button {
    background-color: #FF0000; /* Cor de fundo do botão (substitua pela cor desejada) */
    color: #FFFFFF; /* Cor do texto do botão (substitua pela cor desejada) */
    padding: 10px 20px;
    border: 1px solid #FF0000; /* Cor da borda (substitua pela cor desejada) */
    border-radius: 5px;
    font-weight: bold;
    text-align: center;
}

.logout-button:hover {
    background-color: #FF3333; /* Cor de fundo do botão ao passar o mouse (substitua pela cor desejada) */
    border: 1px solid #FF3333; /* Cor da borda ao passar o mouse (substitua pela cor desejada) */
}

      .responsive-img {
        max-width: 100%;
        height: auto;
      }

      /* Extra small devices (portrait phones, less than 576px)*/
      @media (max-width: 575.98px) {
        
      }

      /* Small devices (landscape phones, 576px and up)*/
      @media (min-width: 576px) and (max-width: 767.98px) {
        
      }

      /* Medium devices (tablets, 768px and up)*/
      @media (min-width: 768px) and (max-width: 991.98px) {
        
      }

      /* Large devices (desktops, 992px and up)*/
      @media (min-width: 992px) and (max-width: 1199.98px) {
        
      }

      /* Extra large devices (large desktops, 1200px and up)*/
      @media (min-width: 1200px) {
        /*.card-protocolos-atrasados {
          position: absolute; 
          top: 0px; 
          right: 0px;
        } */
      }

      .card-protocolos-atrasados {
        height: 250px;
        overflow-y: scroll;
      }
      .logo-section {
    background-color: #333; /* Change this color to your desired dark background color */
    padding: 20px; /* Adjust the padding as needed */
    text-align: center; /* Center align content */
    color: #fff; /* Set text color to white or any contrasting color */
  }

  .logo img {
    max-width: 100%; /* Ensure the logo image doesn't exceed its container */
    height: auto; /* Maintain the aspect ratio of the logo */
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
    

</head>

<script>
    var notificou = false;
    //Utilizado para carregar a validação do banco via PHP para quando ocorrer um chamado ele mostrar na tela um alert
    $(document).ready(function (){
        setInterval(function (){ //Gera de 1 em 1 segundo
            if(notificou == false) { 
                $('#count').load('meu_script_2.php');
                obtemProtocolosAntigos();
            } else {
                setInterval(function (){ //Gera de 1 em 1 minuto
                    $('#count').load('meu_script_2.php'); 
                }, 61000);
            }
        }, 1000)
    });

    //Formatador de data entra como aaaa-mm-dd retorna dd/mm/aaaa
    function formatarDataNova(dataNova) {
        var [data, hora] = dataNova.split(' ');
        var [ano, mes, dia] = data.split('-');
        var [h, min, s] = hora.split(':');

        return `${dia}/${mes}/${ano} ${h}:${min}`; 
    } 

    function obtemProtocolosAntigos() {
      $.ajax({ //Ajax utilizado para sempre validar caso algum colaborador feche o protocólo
        url: "recebeProtocolosAntigos.php",
        
        success: function(xml) {

          $('#tabelaProtocolosAtrasados tbody').empty();

          $(xml).find('Registro').each(function() {
            var dataProtocolo = $(this).find('dataHora').text();
                dataFormatada = formatarDataNova(dataProtocolo);

            $('#tabelaProtocolosAtrasados tbody').append(
                '<tr>' +
                    '<td>'+$(this).find('idProtocolo').text()+'</td>' +
                    '<td>'+dataFormatada+'</td>' +
                    '<td>'+$(this).find('protocolo').text()+'</td>'+			
                    '<td>'+$(this).find('observacao').text()+'</td>'+			
                '</tr>'
            );
          }); 
        },
        beforeSend: function() {}
      }); 
    } 

    function showNotification(idProtocolo, data, protocolo, observacao) {
  if (Notification.permission !== "granted") {
    Notification.requestPermission().then(function (permission) {
      if (permission === "granted") {
        var notification = new Notification("Protocolo Atrasado", {
          body: `Protocolo ${protocolo} está atrasado!`,
        });

        notification.onclick = function () {
          // Você pode definir o que acontece quando o usuário clica na notificação
          // Neste exemplo, você pode redirecioná-los para a página de detalhes do protocolo atrasado
          window.location.href = `detalhes_protocolo.php?id=${idProtocolo}`;
        };
      }
    });
  } else {
    var notification = new Notification("Protocolo Atrasado", {
      body: `Protocolo ${protocolo} está atrasado!`,
    });

    notification.onclick = function () {
      // Você pode definir o que acontece quando o usuário clica na notificação
      // Neste exemplo, você pode redirecioná-los para a página de detalhes do protocolo atrasado
      window.location.href = `detalhes_protocolo.php?id=${idProtocolo}`;
    };
  }
}

// Chamada à função para exibir notificações quando a página é carregada
obtemProtocolosAntigos();


</script>


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

    <div id="count"></div> <!-- NÃO REMOVER, utilizada para disparar e verificar os protocolos que estao no banco a cada 1 segundo via J.query-->

    

    

    <div class="container" style="position: relative;">
        <!-- Logomarca -->
        <div class="logo">
          <img class="responsive-img" src="https://s3.amazonaws.com/mktzap-media-storage-master/whitelabel/companies/logo_login/7ae26d275da4474d90ad043a6ab4ca046d87af48" alt="Logomarca">
        </div>

        <h1>Agendados SZ.CHAT</h1>

        <div class="row">
          

          <div class="col-6">
            <div class="formulario fade-in">
              <form id="agendamentoForm" action="agendar.php" method="POST">
                <div class="mb-3">
                  <label for="protocolo" class="form-label">Protocolo</label>
                  <input type="text" class="form-control" id="protocolo" name="protocolo">
                </div>
                <div class="mb-3">
                  <label for="dataHora" class="form-label">Data e Horário</label>
                  <input type="datetime-local" class="form-control" id="dataHora" name="dataHora">
                </div>
                <input type="hidden" name="usuario" value="<?= $_SESSION['usuario']; ?>">
                <div class="text-center">
                  <button type="submit"  class="btn btn-primary">Agendar</button>
                </div>
              </form>
            </div>
          </div>

          <div class="col-6">
            <div class="formulario fade-in card-protocolos-atrasados"> <!-- Utilizado para fazer o card lateral -->
              <div class="tituloTabela d-flex justify-content-center">
                <label for="protocolosAtrasados" style="border-bottom: 1px solid black;" >Protocolos Atrasados</label>
              </div>
              <table id="tabelaProtocolosAtrasados" class="table">
                <thead>
                  <tr>
                    <td>id</td>
                    <td>Data</td>
                    <td>Protocolo</td>
                    <td>OBS</td>
                  </tr>
                </thead>
                <tbody></tbody>  
              </table>
            </div>
          </div>

        </div>

        

        <div class="text-center mt-3">
            <a href="relatorios.php" class="btn btn-primary">Relatórios</a>
        </div>
        <!-- Botão para voltar à página home.php -->
<div class="text-center mt-3">
    <a href="home.php" class="btn btn-primary">Voltar para o menu</a>
</div>

        
    </div>
    <br>

    <!-- Rodapé -->
    <footer>
    <p>&copy; 2023 Desenvolvido por <a href="https://www.linkedin.com/in/alecxandro-xavier-406a1a13a/" target="_blank">Alecx Xavier</a>.</p>
    </footer>


    <!-- Scripts do Bootstrap (JavaScript) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js"></script>

    <!-- JavaScript personalizado para notificação -->
    
       
</body>
</html>
