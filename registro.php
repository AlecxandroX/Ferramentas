<?php
include('conexao.php');

$NOK = false;
$existeConexao = false;

if (isset($_POST['email']) && isset($_POST['senha']) && isset($_POST['nome']) && isset($_POST['permissao'])) {

    $existeConexao = true;

    $email = $conexao->real_escape_string($_POST['email']);
    $senha = $conexao->real_escape_string($_POST['senha']);
    $nome  = $conexao->real_escape_string($_POST['nome']);
    $permissao = $conexao->real_escape_string($_POST['permissao']);

    // Verificar se o nome de usuário já está cadastrado
    $verifica_nome = "SELECT * FROM usuarios WHERE nome = '$nome'";
    $resultado_nome = $conexao->query($verifica_nome);

    if ($resultado_nome->num_rows > 0) {
        // Nome de usuário já cadastrado, exibir mensagem de erro
        $NOK = true;
        echo "Este nome de usuário já está cadastrado. Escolha outro.";
    } else {
        // Nome de usuário não cadastrado, realizar a inserção
        // Criando uma Query de inserção
        $sql_code = "INSERT INTO usuarios (email, senha, nome, permissao) VALUES ('$email', '$senha', '$nome', '$permissao')";

        // Executando a Query de inserção
        $sql_query = $conexao->query($sql_code) or die("Falha na execução do código sql" . $conexao->error);

        if ($sql_query) {
            // Inserção bem-sucedida, redirecionar para a página de sucesso
            header("Location: index.php");
            exit;
        } else {
            $NOK = true;
            // Exibir mensagem de falha ao inserir
            echo "Falha ao inserir dados no banco de dados";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-Br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Links Ionicons (Icones)-->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js" defer></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js" defer></script>

    <!-- Link CSS index.css -->

    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-image: url('pexels-field-engineer-442152.jpg');
            background-size: cover;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        section {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
        }

        .form-caixa {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            padding: 20px;
            width: 300px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
            transition: transform 0.3s ease-in-out;
        }

        .form-caixa:hover {
            transform: scale(1.05);
        }

        .form-value {
            text-align: center;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        h2 {
            margin-bottom: 20px;
            color: #333;
        }

        .input-caixa {
            position: relative;
            margin-bottom: 20px;
            transition: transform 0.2s ease-in-out;
        }

        .input-caixa:hover {
            transform: scale(1.05);
        }

        ion-icon {
            position: absolute;
            top: 50%;
            left: 10px;
            transform: translateY(-50%);
            color: #555;
        }

        input {
            width: calc(100% - 30px);
            padding: 10px;
            padding-left: 30px;
            border: 1px solid #ccc;
            border-radius: 5px;
            outline: none;
            transition: border-color 0.3s ease-in-out;
        }

        input:focus {
            border-color: #4CAF50;
        }

        label {
            position: absolute;
            top: 50%;
            left: 45px;
            transform: translateY(-50%);
            color: #777;
            transition: color 0.3s ease-in-out;
        }

        .input-caixa:hover label {
            color: #4CAF50;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out;
        }

        button:hover {
            background-color: #45a049;
        }

        .error-message {
            color: red;
            text-align: center;
            margin-top: 10px;
        }

        .registrar {
            margin-top: 20px;
            color: #555;
            text-align: center;
        }

        .registrar a {
            color: #4CAF50;
            text-decoration: none;
            transition: color 0.3s ease-in-out;
        }

        .registrar a:hover {
            color: #45a049;
        }
    </style>

    <title>Página Registro</title>
</head>
<body>
    
<section>
        <div class="form-caixa">
            <div class="form-value">
                <form action="" method="POST">
                    <h2>Registrar</h2>
                    <p>Certifique-se de verificar a existência de um usuário no sistema antes de registrar um novo.</p>

                    <!-- Input Nome -->
                    <div class="input-caixa">
                        <ion-icon name="person-outline"></ion-icon>
                        <input type="text" name="nome" placeholder="Nome de Usuário" required>
                        <label for="nome"></label>
                    </div>

                    <!-- Input E-mail -->
                    <div class="input-caixa">
                        <ion-icon name="mail-outline"></ion-icon>
                        <input type="email" name="email" placeholder="Email" required>
                        <label for="email"></label>
                    </div>

                    <!-- Input Senha -->
                    <div class="input-caixa">
                        <ion-icon name="lock-closed-outline"></ion-icon>
                        <input type="password" name="senha" placeholder="Senha" required>
                        <label for="senha"></label>
                    </div>

                    <!-- Input Permissao -->
                    <div class="input-caixa">
                        <ion-icon name="shield-checkmark-outline"></ion-icon>
                        <select name="permissao" required>
                            <option value="admin">Admin</option>
                            <option value="usuario_comum" selected>Usuário Comum</option>
                        </select>
                        <label for="permissao"></label>
                    </div>

                    <!-- Botão enviar -->
                    <button type="submit">Registrar</button>

                    <!-- Validando os campos inseridos -->
                    <?php
                    if ($NOK == true) {
                        echo '<p class="error-message">Falha no Registro! Não foram inseridos registros no banco de dados</p>';
                    }
                    ?>

                </form>
            </div>
        </div>
    </section>
    
</body>
</html>
