
<?php
    include 'conexao.php'; //Include de conexao com o Banco de dados
    include 'protect.php'; //Include utilizado para não deixar o usuário entrar nas páginas sem utilizar o login

?>
<?php
    include 'conexao.php'; //Include de conexao com o Banco de dados
    include 'protect.php'; //Include utilizado para não deixar o usuário entrar nas páginas sem utilizar o login

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendados SZ.CHAT</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" href="data:image/png;base64,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" type="image/x-icon">
    <style>
    #user-info {
        position: absolute;
        top: 10px;
        left: 10px; /* Alterado para a esquerda para manter a simetria com o botão de logout */
        display: flex;
        align-items: center;
    }

    .logout-button {
        background-color: #333; /* Cor de fundo do botão no tema escuro */
        color: #FFF; /* Cor do texto do botão no tema escuro */
        padding: 10px 20px;
        border: 1px solid #333; /* Cor da borda no tema escuro */
        border-radius: 5px;
        font-weight: bold;
        text-align: center;
    }

    .logout-button:hover {
        background-color: #555; /* Cor de fundo do botão ao passar o mouse no tema escuro */
        border: 1px solid #555; /* Cor da borda ao passar o mouse no tema escuro */
    }

    /* Alterações para melhorar a legibilidade do texto em um fundo escuro */
    body {
        background-image: url('pexels-khezez-_-خزاز-19191196.jpg');
        color: #FFF;
    }

    /* Exemplo de classe para texto em destaque */
    .highlight-text {
        color: #FFC107; /* Cor para texto em destaque no tema escuro */
    }

    .form {
        color: #FFC107
    }
</style>


</head>
<body>
<div id="user-info">
    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512">
        <!-- Seu código SVG -->
    </svg>
    <span style="width: 10px;"></span>
    <h6><?= $_SESSION['usuario']; ?></h6>
  
    <a href="logout.php" class="logout-button">Sair</a>
</div>

    

    <div class="container">
    
        <!-- Logomarca -->
        <div class="logo">
    <img class="responsive-img" src="https://s3.amazonaws.com/mktzap-media-storage-master/whitelabel/companies/logo_login/7ae26d275da4474d90ad043a6ab4ca046d87af48" alt="Logomarca">
    <div class="container d-flex justify-content-end">
   

</div>


        <h1>Agendados NOC-suporte</h1>
        <dvi class="form">
        

        
<div class="formulario fade-in">
    <form id="agendamentoForm" action="agendar_noc.php" method="POST">
        <!-- Adição do campo oculto para o nome do usuário -->
        <input type="hidden" name="usuario" value="<?= $_SESSION['usuario']; ?>">

        <div class="mb-3">
            <label for="protocolo_noc" class="form-label">Protocolo</label>
            <input type="text" class="form-control" id="protocolo_noc" name="protocolo_noc">
        </div>
        <div class="mb-3">
            <label for="dataHora" class="form-label">Data e Horário</label>
            <input type="datetime-local" class="form-control" id="dataHora_noc" name="dataHora_noc">
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-primary">Agendar</button>
        </div>
    </form>
</div>
        </div>

        <div class="text-center mt-3">
            <a href="relatorios_suporte.php" class="btn btn-success">Relatórios</a>
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
