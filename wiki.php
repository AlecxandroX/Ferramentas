<?php
    include 'conexao.php'; // Include de conexao com o Banco de dados
    include 'protect.php'; // Include utilizado para não deixar o usuário entrar nas páginas sem utilizar o login
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload WIKI - Dark Theme</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to an external stylesheet for better organization -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #000;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        form {
            background-color: #333;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0px 0px 20px rgba(255, 255, 255, 0.2);
            max-width: 600px;
            width: 100%;
        }

        h1 {
            color: #fff;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #fff;
        }

        input[type="text"],
        input[type="file"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #666;
            border-radius: 5px;
            color: #000;
            background-color: #fff;
            transition: border 0.3s;
            box-sizing: border-box;
        }

        input[type="file"] {
            background-color: #333;
            color: #fff;
            border: 1px solid #555;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            padding: 12px 24px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s;
            display: inline-block;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        /* Hover effect */
        input[type="text"]:hover,
        input[type="file"]:hover,
        input[type="submit"]:hover {
            box-shadow: 0px 0px 12px rgba(255, 255, 255, 0.3);
        }
    </style>
</head>

<body>
    <div>
        <h1>Upload de arquivos para WIKI</h1>
        <form action="process_upload.php" method="post" enctype="multipart/form-data">
            <label for="topic">Tópico:</label>
            <input type="text" name="topic" id="topic" required>

            <label for="filename">Nome do Arquivo:</label>
            <input type="text" name="filename" id="filename" required>

            <label for="pdf">Selecione o PDF:</label>
            <input type="file" name="pdf" id="pdf" accept=".pdf" required>

            <input type="submit" value="Enviar">
        </form>
    </div>
</body>

</html>
