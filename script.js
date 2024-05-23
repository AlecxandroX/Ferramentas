// Função para realçar o cliente da vez
function destacarClienteDaVez() {
    const fila = document.getElementById('fila');
    const clientes = fila.getElementsByTagName('li');

    for (let i = 0; i < clientes.length; i++) {
        if (clientes[i].classList.contains('cliente-vez')) {
            // Remove a classe 'cliente-vez' do cliente anterior da vez
            clientes[i].classList.remove('cliente-vez');
            i = (i + 1) % clientes.length; // Avança para o próximo cliente na fila
            clientes[i].classList.add('cliente-vez'); // Adiciona a classe 'cliente-vez' ao novo cliente da vez
            break;
        }
    }
}

// Intervalo para chamar a função de destaque a cada 5 segundos (pode ser ajustado)
setInterval(destacarClienteDaVez, 5000);
