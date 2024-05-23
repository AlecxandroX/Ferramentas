<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário de Inserção de E-mails</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
         body {
            font-family: Arial, sans-serif;
            background-image: url('cliente_feliz.jpg');
            background-size: cover; /* Ajusta o tamanho da imagem para cobrir todo o corpo */
            background-position: center; /* Centraliza a imagem */
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            max-width: 500px;
            padding: 20px;
            border-radius: 10px;
            background-color: rgba(255, 255, 255, 0.5); /* Adiciona um fundo branco com 50% de opacidade */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            margin-bottom: 20px;
            text-align: center;
        }

        label {
            font-weight: bold;
        }

        textarea,
        input[type="text"] {
            resize: none;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 10px;
            width: 100%;
            background-color: rgba(255, 255, 255, 0.5); /* Adiciona um fundo branco com 50% de opacidade */
        }

        .btn-submit {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-submit:hover {
            background-color: #0056b3;
        }

        /* Estilos para a imagem */
        img {
            display: block;
            margin: 0 auto;
            max-width: 200px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <?php
    // Informações de conexão ao banco de dados
    $server = 'ws4.altcloud.net.br';
    $usuario = 'ggnet_nocsz';
    $senha = 'ae7$6bPiLz/gp#iF';
    $base = 'ggnet_nocsz';

    // Verificar se o formulário foi submetido
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Conexão com o banco de dados
        $conn = new mysqli($server, $usuario, $senha, $base);

        // Verificar conexão
        if ($conn->connect_error) {
            die("Erro de conexão: " . $conn->connect_error);
        }

        // Verificar se os e-mails foram enviados via formulário
        if (isset($_POST['emails']) && isset($_POST['nomes'])) {
            // Obter os e-mails e nomes do formulário
            $emails = explode("\n", $_POST['emails']);
            $nomes = explode("\n", $_POST['nomes']);

            // Limpar e validar os e-mails e nomes
            $valid_entries = [];
            foreach ($emails as $key => $email) {
                $email = trim($email);
                $nome = isset($nomes[$key]) ? trim($nomes[$key]) : ''; // Verificar se o nome correspondente existe
                if (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $valid_entries[] = array(
                        'email' => $conn->real_escape_string($email),
                        'nome' => $conn->real_escape_string($nome)
                    );
                }
            }

            // Inserir os e-mails e nomes no banco de dados
            if (!empty($valid_entries)) {
                $values = array();
                foreach ($valid_entries as $entry) {
                    $values[] = "('" . $entry['email'] . "', '" . $entry['nome'] . "')";
                }
                $sql = "INSERT INTO clientes (email, nome) VALUES " . implode(", ", $values);
                if ($conn->query($sql) === TRUE) {
                    echo "E-mails e nomes inseridos com sucesso!";
                    // Redirecionar para a mesma página após 2 segundos
                    echo '<script>setTimeout(function(){ window.location.href = window.location.href; }, 1500);</script>';
                } else {
                    echo "Erro ao inserir os e-mails e nomes: " . $conn->error;
                }
            } else {
                echo "Nenhum e-mail válido encontrado para inserção.";
            }
        }

        // Fechar conexão com o banco de dados
        $conn->close();
    }
    ?>

    <div class="container">
        <img src="https://s3.amazonaws.com/mktzap-media-storage-master/whitelabel/companies/logo_login/7ae26d275da4474d90ad043a6ab4ca046d87af48" alt="">
        <h2>Pesquisa de Satisfação</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="mb-3">
                <label for="emails" class="form-label">Insira os e-mails:</label>
                <textarea name="emails" id="emails" rows="5" class="form-control" placeholder="Insira os e-mails um por linha"></textarea>
            </div>
            <div class="mb-3">
                <label for="nomes" class="form-label">Insira os nomes:</label>
                <textarea name="nomes" id="nomes" rows="5" class="form-control" placeholder="Insira os nomes um por linha"></textarea>
            </div>
            <button type="submit" class="btn btn-primary btn-submit">Enviar</button>
        </form>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
