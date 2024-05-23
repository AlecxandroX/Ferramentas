<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Formulário</title>
<style>
    /* Estilo para o formulário */
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f2f2f2;
    }

    h2 {
        text-align: center;
        margin-top: 20px;
        color: #333;
    }

    .container {
        width: 60%;
        margin: 20px auto;
        padding: 20px;
        border-radius: 10px;
        background-color: #fff;
        box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
    }

    form {
        width: 100%;
    }

    label {
        display: block;
        margin-bottom: 8px;
        color: #555;
    }

    input[type="text"],
    input[type="date"],
    select {
        width: calc(100% - 16px);
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 5px;
        transition: border-color 0.3s ease;
    }

    input[type="submit"] {
        width: 100%;
        padding: 12px;
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    input[type="submit"]:hover {
        background-color: #45a049;
    }

    .btn {
        padding: 12px 24px;
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        text-decoration: none;
        display: inline-block;
    }

    .btn:hover {
        background-color: #45a049;
    }

    /* Animations */
    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    .fadeIn {
        animation-name: fadeIn;
        animation-duration: 1s;
    }
</style>
</head>
<body>

<h2 class="fadeIn">Formulário de Reincidencia</h2>
<div class="container fadeIn">

<form action="salva_reincidencia.php" method="post">
  <label for="nome">Nome:</label>
  <input type="text" id="nome" name="nome" required>

  <label for="protocolo">Protocolo:</label>
  <input type="text" id="protocolo" name="protocolo">

  <label for="data">Data:</label>
  <input type="date" id="data" name="data">

  <label for="dificuldade">Dificuldade Resolvida?</label>
  <select id="dificuldade" name="dificuldade">
    <option value="Sim">Sim</option>
    <option value="Não">Não</option>
    <option value="Sem Reincidencia">Sem Reincidencia</option>
    <option value="Sem Contato">Sem Contato</option>
  </select>

  <label for="encaminhado">Encaminhado para Técnico?</label>
  <select id="encaminhado" name="encaminhado">
    <option value="Sim">Sim</option>
    <option value="Não">Não</option>
    <option value="Sem Reincidencia">Sem Reincidencia</option>
    <option value="Resolvido remotamente">Resolvido remotamente</option>
    <option value="Sem Contato">Sem Contato</option>
  </select>

  <input type="submit" value="Enviar">
  
</form>
<br>
<a href="relatorio_reincidencia.php" class="btn">Relatório</a>
<a href="graficos_reincidencia.php" class="btn">Graficos</a>
</div>

</body>
</html>
