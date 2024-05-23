<!DOCTYPE html>
<html>
<head>
    <title>Ligações perdidas</title>
    <link rel="icon" href="https://static.vecteezy.com/ti/vetor-gratis/p3/4956037-icone-de-chamada-vetor.jpg" type="image/x-icon">
    <style>
        /* Estilo básico para o corpo da página */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #333; /* Fundo escuro */
            color: #fff; /* Texto claro */
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        /* Estilo para o formulário */
        form {
            background-color: #555; /* Fundo mais escuro para o formulário */
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
            padding: 30px;
            width: 400px;
            text-align: center;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            margin-top: 20px;
        }

        /* Estilo para o cabeçalho (título) */
        h1 {
            color: #fff; /* Texto claro */
            font-size: 28px;
            margin-bottom: 20px;
            margin-top: 0;
        }

        /* Estilo para as etiquetas e campos de entrada */
        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
            color: #ccc; /* Texto mais claro */
            font-size: 16px;
        }

        input[type="text"],
        input[type="datetime-local"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #444; /* Borda mais escura */
            border-radius: 5px;
            font-size: 16px;
            background-color: #444; /* Fundo mais escuro para os campos de entrada */
            color: #fff; /* Texto claro */
        }

        /* Estilo para o botão de envio */
        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        /* Animação ao focar nos campos de entrada */
        input:focus {
            border-color: #007bff;
            transition: border-color 0.3s ease;
        }

        /* Estilo para o formulário quando estiver em hover */
        form:hover {
            transform: scale(1.02);
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.3);
        }

        /* Estilo para o botão de relatórios */
        .btn-relatorios {
            margin-top: 20px;
        }
        
        /* Estilo para o botão de relatórios */
        .btn-relatorios {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .btn-relatorios:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1>Ligações Perdidas</h1>
    <form action="processa_ligacoes.php" method="post">
        <label for="campo1">MOTIVO DA PERDIDA?</label>
        <input type="text" name="campo1" id="campo1" required><br>

        <label for="campo2">DNIS</label>
        <input type="text" name= "campo2" id="campo2" required><br>

        <label for="campo3">ESPERA</label>
        <input type="text" name="campo3" id="campo3" required><br>

        <label for="campo4">POSIÇÃO</label>
        <input type="text" name="campo4" id="campo4" required><br>

        <label for="campo5">ORIGINADOR</label>
        <input type="text" name="campo5" id="campo5" required><br>

        <label for="data_hora">Data e Hora:</label>
        <input type="datetime-local" name="data_hora" id="data_hora" required><br>

        <input type="submit" value="Enviar">
    </form>
</body>
</html>
