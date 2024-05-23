<?php
    date_default_timezone_set('America/Sao_Paulo');
    include 'conexao.php';

// Verifique se o formulário foi submetido
if (!isset($_POST['protocolo']) || !isset($_POST['dataHora'])) {
    
    

    // Obtenha os valores dos campos do formulário
    $protocolo = $_POST["protocolo"];
    $dataHora = $_POST["dataHora"];

    // Use declaração preparada para evitar injeção SQL
    $stmt = $conexao->prepare("SELECT *, TIME_FORMAT(dataHora, '%H:%i') as data_hora_sem_segundos FROM agendamentos");
    $stmt->execute();
    $result = $stmt->get_result();

    $dataAtual = date('Y-m-d H:i');

    while ($row = $result->fetch_assoc()) {
        $dataFinal = $row['data_hora_sem_segundos'];

        if ($dataFinal === $dataAtual) {
            // Notificar aqui
            $descricao = $row['protocolo'];
            echo 
            //codigo script ele enviar a notificação do win
            "<script>
                if (!('Notification' in window)) {
                    alert('Este navegador não suporta notificações.');
                } else if (Notification.permission === 'granted') {
                    var notification = new Notification('Protocolo: $descricao', {
                        body: 'Data e horário: $dataFinal está sendo chamado! Verifique.',
                        icon: 'icone.png'
                    });

                    setTimeout(function () {
                        notification.close();
                    }, 60000); // Fecha a notificação após 1 minuto (60000 milissegundos).
                } else if (Notification.permission !== 'denied') {
                    Notification.requestPermission(function (permission) {
                        if (permission === 'granted') {
                            var notification = new Notification('Protocolo: $descricao', {
                                body: 'Data e horário: $dataFinal está sendo chamado! Verifique.',
                                icon: 'icone.png'
                            });

                            /*setTimeout(function () {
                                notification.close();
                            }, 60000); // Fecha a notificação após 1 minuto (60000 milissegundos). */
                        }
                    });
                }
            </script>";
        }
    }

    // Feche a conexão com o banco de dados
    $conexao->close();
} else {
    echo "TEVE REQUISIÇÃO";
}
?>
