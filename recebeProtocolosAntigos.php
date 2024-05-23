<?php 
    include 'conexao.php';

    //ATENÇÃO ESSAS INFORMAÇÕES ABAIXO SÃO REFERENTE AO FILTRO DA PÁGINA agendadosSz.php na qual foi feita uma busca com base nesta página
    $respostaWhile = "";
    
    $respostaOk = 'OK';

    $sql    = "SELECT * 
               FROM agendamentos
               WHERE dataHora <= NOW() -- Consulta que retorna todos os chamados que são antigos referente a data atual
              ";

    $busca  = mysqli_query($conexao,$sql);

    while($dados = mysqli_fetch_array($busca)) {
        $idProtocolo  = $dados['id'];
        $protocolo    = $dados['protocolo'];
        $dataHora     = $dados['dataHora'];
        $observacao   = $dados['observacao'];

        $respostaWhile = "$respostaWhile<Registro> 
                                            <idProtocolo>$idProtocolo</idProtocolo>
                                            <protocolo>$protocolo</protocolo>
                                            <dataHora>$dataHora</dataHora>
                                            <observacao>$observacao</observacao>
                                        </Registro>";

        

    }

    $resposta = "<?xml version='1.0' encoding='utf-8' ?>

    <Root><obtemProtocolos TagName='obtemProtocolos'>$respostaWhile</obtemProtocolos></Root>";

    echo $resposta;
    

?>