<?php
session_start(); // Inicie a sessão se ainda não tiver sido iniciada

// Verifique se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Conecte-se ao banco de dados (substitua com suas credenciais)
    $servername = "ws4.altcloud.net.br";
    $username = "ggnet_nocsz";
    $password = "ae7$6bPiLz/gp#iF";
    $dbname = "ggnet_nocsz";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verifique a conexão com o banco de dados
    if ($conn->connect_error) {
        die("Falha na conexão com o banco de dados: " . $conn->connect_error);
    }

    // Obtenha os valores dos campos do formulário
    $protocolo = $_POST["protocolo"];
    $dataHora = $_POST["dataHora"];
    $usuario = $_POST["usuario"]; // Adicionado campo para armazenar o usuário

    // Insira os dados na tabela "agendamentos"
    $sql = "INSERT INTO agendamentos (dataHora, protocolo, usuario) VALUES ('$dataHora', '$protocolo', '$usuario')";

    if ($conn->query($sql) === TRUE) {
        echo "Agendamento realizado com sucesso!";
    } else {
        echo "Erro ao agendar: " . $conn->error;
    }

    // Verifique se o usuário está agendando
    if ($_SESSION['usuario'] === $usuario) {
        //ADICIONADO TESTE PARA VALIDAR
        //Verificando caso exista o Registro no banco de dados e retornando o Alert caso seja do mesmo horário
        //Utilizado desta maneira para poder trazer o campo data_hora sem os segundos
        $sql2 = "SELECT *, TIME_FORMAT(dataHora, '%H:%i') as data_hora_sem_segundos FROM agendamentos";
        $consulta  = mysqli_query($conn, $sql2);

        $dataAtual = date('Y-m-d ');
        $dataAtualHoje = date('Y-m-d H:i');

        foreach($consulta as $consultas) {
            $dataFinal = $dataAtual . $consultas['data_hora_sem_segundos'];
            $descricao = $consultas['protocolo'];

            echo "Data atual hoje: $dataAtualHoje <br> Data Final: $dataFinal <br>";

            if($dataFinal == $dataAtualHoje) {
                echo "<script>var notificou = true; alert('O protocolo: $descricao Data e horario: $dataFinal está sendo chamado! verifique')</script>";
                header('Location: agendadosSZ.php');
            } else {
                echo "<script>var notificou = false </script>";
                header('Location: agendadosSZ.php');
            }
        }
    } else {
        // Se o usuário não estiver correto, redirecione para a página de login ou faça algo apropriado
        echo "Erro: Usuário incorreto!";
        header('Location: agendadosSZ.php');
    }

    // Feche a conexão com o banco de dados
    $conn->close();
}
?>
