
let cepValido = false; 

function limparCamposEndereco() {
    document.getElementById('rua').value = '';
    document.getElementById('bairro').value = '';
    document.getElementById('cidade').value = '';
    document.getElementById('estado').value = '';
}

function exibirStatus(mensagem, tipo = 'info') {
    const statusDiv = document.getElementById('mensagem-status');
    statusDiv.textContent = mensagem;
    statusDiv.className = (tipo === 'sucesso') ? 'sucesso' : (tipo === 'erro' ? 'erro' : '');
}

async function validarCepEPreencher() {
    cepValido = false; 
    exibirStatus('');  
    
    const cepInput = document.getElementById('cep');
    const cep = cepInput.value.replace(/\D/g, '');

    if (cep.length !== 8) {
        if (cep.length > 0) exibirStatus("O CEP deve ter 8 dígitos.", 'erro');
        limparCamposEndereco();
        return;
    }

    exibirStatus('... Buscando endereço ...');
    const url = `https://viacep.com.br/ws/${cep}/json/`;

    try {
        const response = await fetch(url);
        const dados = await response.json();

        if (dados.erro === true || !response.ok) {
            exibirStatus("CEP não encontrado ou inválido na base de dados.", 'erro');
            limparCamposEndereco(); 
            return; 
        }

       
        exibirStatus(''); 
        
        document.getElementById('rua').value = dados.logradouro ?? '';
        document.getElementById('bairro').value = dados.bairro ?? '';
        document.getElementById('cidade').value = dados.localidade ?? '';
        document.getElementById('estado').value = dados.uf ?? ''; 

        cepValido = true;
        document.getElementById('numero').focus(); 
        
    } catch (error) {
        console.error("Erro fatal ao buscar o CEP:", error);
        exibirStatus("Erro de conexão. Verifique sua internet e tente novamente.", 'erro');
        limparCamposEndereco();
    }
}