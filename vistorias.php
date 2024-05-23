<!DOCTYPE html>
<html>
<head>
    <title>Vistoria</title>
    <link rel="stylesheet" href="vistorias.css">
</head>
<body>
    <h1>Vistoria</h1>
    <form action="processar_vistoria.php" method="post">
        <label for="data">Data:</label>
        <input type="date" name="data" required><br>

        <label for="protocolo">Protocolo:</label>
        <input type="text" name="protocolo" required><br>

        <label for="os">Nº O.S:</label>
        <input type="text" name="os" required><br>

        <label for="tecnico">Técnico:</label>
       

<input type="text" id="searchInput" placeholder="Buscar técnico">

<select name="tecnico" id="technicianSelect">
    <!-- Default option -->
    <option value="">Selecione um técnico</option>
</select>

<script>
    var selectElement = document.getElementById("technicianSelect");
    var searchInput = document.getElementById("searchInput");

    function populateTechnicians() {
        var apiUrl = "https://api.multifoco.app/v1/dashboard/serviceOrders/byTechnician";
        var apiToken = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMCIsImlzcyI6Imh0dHBzOi8vcm9ib3QubXVsdGlmb2NvLmFwcCJ9.ZnQGgfTibqzR1tZUx3X7_uVdgCqfYO5k6ybIUT2txHc";

        fetch(apiUrl, {
            headers: {
                'Authorization': 'Bearer ' + apiToken
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Clear existing options
                selectElement.innerHTML = "<option value=''>Selecione um técnico</option>";

                // Fill the select with technician names
                data.items.forEach(function(item) {
                    var option = document.createElement("option");
                    option.value = item.name; // Use the name of the technician
                    option.text = "Técnico: " + item.name; // Display the name
                    selectElement.add(option);
                });

                // Adicione um evento de input ao campo de busca
                searchInput.addEventListener("input", function() {
                    filterTechnicians();
                });
            } else {
                console.error("Erro ao obter dados da API.");
            }
        })
        .catch(error => {
            console.error("Erro de rede:", error);
        });
    }

    function filterTechnicians() {
        var searchTerm = searchInput.value.toLowerCase();

        Array.from(selectElement.options).forEach(function(option) {
            var optionText = option.text.toLowerCase();
            var isSelectedOption = option.selected;

            // Verifique se a opção contém o termo de pesquisa e se não está já selecionada
            if (optionText.includes(searchTerm) && !isSelectedOption) {
                option.style.display = ""; // Exibe a opção
            } else {
                option.style.display = "none"; // Oculta a opção
            }
        });
    }

    // Call the function to populate the select
    populateTechnicians();
</script>


<label for="cidade">Cidade:</label>
    <select name="cidade" id="cidade" required>
        <option value="">Selecione uma regional</option>
        <option value="CDR">CDR</option>
        <option value="CNI">CNI</option>
        <option value="VDA">VDA</option>
        <option value="RSL">RSL</option>
        <option value="PUN">PUN</option>
        <option value="IRI">IRI</option>
            
            

    </select><br>

    <label for="qualidade">Qualidade das Fotos Anexadas?</label>
    <select name="qualidade" required>
        <option value="sim">Boa</option>
        <option value="nao">Ilegível</option>
    </select><br>

    <label for="fotos_anexadas">Todas as fotos foram inseridas?</label>
    <select name="fotos_anexadas" required>
        <option value="sim">Sim</option>
        <option value="nao">Não</option>
    </select><br>

    <label for="dificuldade_resolvida">Dificuldade do Cliente foi resolvida?</label>
    <select name="dificuldade_resolvida" required>
        <option value="sim">Sim</option>
        <option value="nao">Não</option>
    </select><br>

    <label for="assinatura_os">Quem abriu o chamado assinou a O.S?</label>
    <select name="assinatura_os" required>
        <option value="sim">Sim</option>
        <option value="nao">Não</option>
    </select><br>

    <label for="configuracoes_ok">Configurações do roteador, DNS, versão estão OK?</label>
    <select name="configuracoes_ok" required>
        <option value="sim">Sim</option>
        <option value="nao">Não</option>
    </select><br>

    <label for="observacao">Procedimento incorreto:</label>
<select name="observacao" id="observacao" required>
    <option value="Nenhum">Nenhum</option>
    <option value="Sem DNS na WAN">Sem DNS na WAN</option>
    <option value="Sem DNS na LAN">Sem DNS na LAN</option>
    <option value="Sem DNS na LAN e WAN">Sem DNS na LAN e WAN</option>
    <option value="Ipv6 desabilitado">Ipv6 desabilitado</option>
    <option value="Fechamento da OS incorreto">Fechamento da OS incorreto</option>
    <option value="Abertura da OS incorret">Abertura da OS incorreta</option>
    <option value="Gerencia do roteador não configurada">Gerencia do roteador não configurada</option>
    <option value="Tipo da abertura da OS">Tipo da abertura da OS</option>
    <option value="Faltou foto">Faltou foto</option>
    <optgroup label="Opções Adicionais">
        <option value="Faltou foto do roteador">Foto do roteador</option>
        <option value="Faltou foto do MAC do roteador">Foto do MAC do roteador</option>
        <option value="Faltou foto da ONU">Foto da ONU</option>
        <option value="Faltou foto do MAC da ONU">Foto do MAC da ONU</option>
        <option value="Faltou foto do Teste de Banda">Foto do Teste de Banda</option>
        <option value="Faltou foto da Caixa">Foto da Caixa</option>
        <option value="Faltou foto do sinal da caixa">Foto do sinal da caixa</option>
        <option value="Faltou foto do sinal do client">Foto do sinal do cliente</option>
        <option value="Faltou foto da ancoragem">Foto da ancoragem</option>
        <option value="Faltou foto da Casa Externa do Cliente">Foto da Casa Externa do Cliente</option>
        <option value="Faltou foto local Instalação (interna no cliente)">Local Instalação (interna no cliente)</option>
    </optgroup>
    

</select>




    <label for="atendimento_concluido">O Atendimento foi documentado corretamente?</label>
    <select name="atendimento_concluido" required>
        <option value="sim">Sim</option>
        <option value="nao">Não</option>
    </select><br>

    <input type="submit" value="Enviar">
    <span></span>
    <div class="botoes">
    <a href="relatorio_vistoria.php" class="button">Relatórios</a>
            <a href="atendimento_incorretos.php" class="button">OSs Incorretas</a>
            
            <a href="ranking_tecnico.php" class="button">Grafico por tecnicos</a>
        </div>

</form>

</body>
</html>
