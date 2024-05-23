<?php
    include 'conexao.php'; // Include de conexao com o Banco de dados
    include 'protect.php'; // Include utilizado para não deixar o usuário entrar nas páginas sem utilizar o login

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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exibição de Usuários</title>
    <style>
      body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #1e1e1e; /* Cor de fundo do corpo */
            color: #fff; /* Cor do texto */
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #2b2b2b; /* Cor de fundo do contêiner */
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5); /* Sombra suave */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            color: #fff; /* Cor do texto da tabela */
        }

        th, td {
            border: 1px solid #444; /* Cor da borda */
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #333; /* Cor de fundo do cabeçalho */
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #333; /* Cor de fundo de linhas pares */
        }

        tr:hover {
            background-color: #444; /* Cor de fundo ao passar o mouse sobre uma linha */
        }

        .error {
            color: red;
            font-weight: bold;
        }

        img {
            max-width: 100px;
            max-height: 100px;
            border-radius: 50%;
            border: 2px solid #444; /* Cor da borda das imagens */
        }

        @media screen and (max-width: 600px) {
            table {
                font-size: 14px; /* Reduz o tamanho da fonte em dispositivos menores */
            }
        }
    </style>
</head>
<body>

<?php
            // Detalhes da conexão com o banco de dados
            $server = 'ws4.altcloud.net.br';
            $usuario = 'ggnet_nocsz';
            $senha = 'ae7$6bPiLz/gp#iF';
            $base = 'ggnet_nocsz';

            // Conexão com o banco de dados
            $conn = new mysqli($server, $usuario, $senha, $base);

            // Verifica a conexão
            if ($conn->connect_error) {
                die("Erro na conexão: " . $conn->connect_error);
            }

            // Consulta SQL para obter os dados da tabela usuarios
            $sql = "SELECT id, nome, senha, email, foto FROM usuarios";
            $result = $conn->query($sql);

            // Exibir os dados em uma tabela HTML
            if ($result->num_rows > 0) {
                echo "<table border='1'>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Senha</th>
                            <th>Email</th>
                        </tr>";

                while ($row = $result->fetch_assoc()) {
                    // Adicione a seguinte condição para ignorar o usuário com o ID 83
                    if ($row["id"] != 83) {
                        echo "<tr>
                                <td>" . $row["id"] . "</td>
                                <td>" . $row["nome"] . "</td>
                                <td>" . $row["senha"] . "</td>
                                <td>" . $row["email"] . "</td>
                            </tr>";
                    }
                }

                echo "</table>";
            } else {
                echo "Nenhum resultado encontrado.";
            }

            // Fechar a conexão
            $conn->close();
?>
</body>
</html>

<?php
            // Fechar a conexão com o banco de dados
            $conn->close();
        } else {
            echo 'Você não tem permissão para acessar essa pagina!';
        }
    } else {
        echo 'Erro na consulta ao banco de dados: ' . $conn->error;
    }
?>
