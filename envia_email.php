<?php
// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Dados do formulário
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // Conexão com o banco de dados
    $servername = "ws4.altcloud.net.br";
    $username = "ggnet_nocsz";
    $password = "ae7$6bPiLz/gp#iF";
    $dbname = "ggnet_nocsz";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verifica a conexão
    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }

    // Consulta SQL para obter todos os e-mails e nomes
    $sql = "SELECT email, nome FROM clientes";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Loop através dos resultados
        while($row = $result->fetch_assoc()) {
            $to = $row['email'];
            $name = $row['nome'];
            
            // Substitui os marcadores na mensagem pelo nome do cliente
            $message_personalized = str_replace("{nome}", $name, $message);
            
            // Cabeçalhos do e-mail
            $headers = "From: alecxxavier*@gmail.com\r\n";
            $headers .= "alecxxavier*@gmail.com\r\n";
            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

            // Envia o e-mail
            if (mail($to, $subject, $message_personalized, $headers)) {
                echo 'E-mail enviado com sucesso para ' . $to . '<br>';
            } else {
                echo 'Erro ao enviar e-mail para ' . $to . '<br>';
            }
        }
    } else {
        echo "Nenhum cliente encontrado.";
    }

    // Fecha a conexão
    $conn->close();

    echo "Todos os e-mails foram enviados.";
}
?>
