<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CADASTRAR - ESCOLA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        /* Variáveis de cor */
        :root {
            --neon-blue: #00ffff;
            --neon-magenta: #ff00ff;
            --dark-bg-main: #141421;
            --dark-bg-area: #1a1a2e;
            --item-bg: #22223a;
            --text-color: #e0e0e0;
            --border-color: rgba(0, 255, 255, 0.1);
            --shadow-intensity: 0 0 10px;
        }

        body {
            background-color: var(--dark-bg-main);
            color: var(--text-color);
            font-family: 'Consolas', 'Courier New', monospace;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }

        /* Estilo de Títulos */
        h3 {
            color: var(--neon-magenta);
            text-shadow: 0 0 5px var(--neon-magenta);
            margin-bottom: 5px;
            letter-spacing: 1.5px;
            text-align: center;
        }

        /* Estilo da descrição */
        p {
            color: var(--neon-blue);
            text-align: center;
            margin-bottom: 25px;
            font-size: 0.9rem;
        }

        /* Estilo do Container Principal (Para Formulários) */
        .form-neon {
            background-color: var(--dark-bg-area);
            padding: 40px;
            border-radius: 8px;
            border: 1px solid var(--neon-blue);
            box-shadow: var(--shadow-intensity) var(--neon-blue),
                0 0 20px rgba(255, 0, 255, 0.2);
            width: 100%;
            max-width: 700px;
        }

        /* Estilo para Fieldsets */
        .fieldset-neon {
            border: 1px solid var(--neon-magenta) !important;
            padding: 20px !important;
            margin-bottom: 20px !important;
            border-radius: 5px;
        }

        .fieldset-neon legend {
            color: var(--neon-magenta);
            text-shadow: 0 0 3px var(--neon-magenta);
            font-weight: bold;
            width: inherit;
            padding: 0 10px;
            border-bottom: none;
            font-size: 1.1em;
            margin-bottom: 0;
        }

        label {
            color: var(--text-color);
            margin-bottom: 5px;
            display: block;
            font-weight: bold;
        }

        /* Estilo para Inputs e Selects */
        .form-control {
            background-color: var(--item-bg) !important;
            border: 1px solid var(--neon-blue) !important;
            color: var(--neon-blue) !important;
            box-shadow: 0 0 3px rgba(0, 255, 255, 0.5) !important;
            transition: all 0.2s;
        }

        .form-control::placeholder {
            color: rgba(0, 255, 255, 0.5) !important;
        }

        .form-control:focus {
            background-color: var(--dark-bg-area) !important;
            border-color: var(--neon-magenta) !important;
            box-shadow: 0 0 8px var(--neon-magenta) !important;
        }

        /* Botão Neon (Ações Principais) */
        .btn-neon {
            --btn-color: var(--neon-magenta);
            background: transparent;
            color: var(--btn-color);
            border: 1px solid var(--btn-color);
            padding: 10px 20px;
            border-radius: 5px;
            box-shadow: 0 0 5px var(--btn-color);
            transition: all 0.3s;
            font-weight: bold;
            width: 100%;
            margin-top: 10px;
        }

        .btn-neon:hover, .btn-neon:focus {
            background: var(--btn-color);
            color: var(--dark-bg-area);
            box-shadow: 0 0 15px var(--btn-color);
            border-color: var(--btn-color);
        }

        /* Estilo para o botão de limpar */
        .btn-reset {
             --btn-color: var(--neon-blue);
            background: transparent;
            color: var(--btn-color);
            border: 1px solid var(--btn-color);
            padding: 10px 20px;
            border-radius: 5px;
            box-shadow: 0 0 5px var(--btn-color);
            transition: all 0.3s;
            font-weight: bold;
            width: 100%;
            margin-top: 10px;
        }
        
        .btn-reset:hover {
            background: var(--btn-color);
            color: var(--dark-bg-area);
            box-shadow: 0 0 15px var(--btn-color);
            border-color: var(--btn-color);
        }
        
        /* Estiliza o div da mensagem de status */
        #mensagem-status {
            margin-top: 15px;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <form class="form-neon" action="proc_escola.php" method="POST">

                    <div>
                        <h3>Cadastro - Nova Instituição de Ensino</h3>
                        <p>Preencha os dados de forma completa para o registro no sistema.</p>
                    </div>

                    <fieldset class="fieldset-neon">
                        <legend>Dados Principais</legend>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nome_escola">Nome da Escola</label>
                                <input type="text" class="form-control" id="nome_escola" name="nome_escola"
                                    placeholder="ESCOLA ESTADUAL BUENO BRANDÃO" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="cod_inep">CÓDIGO INEP</label>
                                <input type="text" class="form-control" id="cod_inep" name="cod_inep" placeholder="31000000" required>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset class="fieldset-neon">
                        <legend>Localização</legend>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="cep">CEP</label>
                                <input type="text" class="form-control" id="cep" name="cep" placeholder="00000-000" required>
                            </div>
                            <div class="col-md-8 mb-3">
                                <label for="endereco">Logradouro / Endereço</label>
                                <input type="text" class="form-control" id="endereco" name="endereco" placeholder="RUA SÃO PAULO" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="numero">Número</label>
                                <input type="text" class="form-control" id="numero" name="numero" placeholder="123" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="bairro">Bairro</label>
                                <input type="text" class="form-control" id="bairro" name="bairro" placeholder="CENTRO" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="cidade">Cidade</label>
                                <input type="text" class="form-control" id="cidade" name="cidade" placeholder="TRÊS CORAÇÕES" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="estado">Estado</label>
                                <input type="text" class="form-control" id="estado" name="estado" placeholder="MG" required>
                            </div>
                            <div class="col-md-8 mb-3">
                                <label for="complemento">Complemento (Opcional)</label>
                                <input type="text" class="form-control" id="complemento" name="complemento" placeholder="Próximo à Praça">
                            </div>
                        </div>
                    </fieldset>

                    <fieldset class="fieldset-neon">
                        <legend>Contato</legend>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="telefone">Telefone</label>
                                <input type="text" class="form-control" id="telefone" name="telefone" placeholder="(00) 00000-0000" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email_escola">E-mail</label>
                                <input type="email" class="form-control" id="email_escola" name="email_escola" placeholder="contato@escola.com.br" required>
                            </div>
                        </div>
                    </fieldset>

                    <div class="d-grid gap-2">
                        <button type="reset" class="btn-reset">Limpar</button>
                        <button type="submit" class="btn-neon" name="submit">Cadastrar Escola</button>
                        <div id="mensagem-status"></div>
                        <input type="hidden" id="status" name="status" value="0" />
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="validar_cep.js"></script> 
    <script>
        function aplicarMascara(input) {
            let valor = input.value.replace(/\D/g, ''); // Remove tudo que não é dígito

            if (valor.length > 11) {
                valor = valor.substring(0, 11); // Limita a 11 dígitos
            }

            // Aplica a máscara: (XX) XXXX-XXXX ou (XX) XXXXX-XXXX
            if (valor.length > 10) {
                // Celular com 9º dígito: (99) 99999-9999
                input.value = valor.replace(/^(\d{2})(\d{5})(\d{4})$/, '($1) $2-$3');
            } else if (valor.length > 6) {
                // Fixo ou celular antigo/sem 9º dígito: (99) 9999-9999
                input.value = valor.replace(/^(\d{2})(\d{4})(\d{4})$/, '($1) $2-$3');
            } else if (valor.length > 2) {
                // Apenas DDD: (99)
                input.value = valor.replace(/^(\d{2})$/, '($1)');
            }

            // Garante que a máscara seja aplicada ao input de telefone
            if (input.id === 'telefone') {
                input.value = input.value;
            }
        }
        
        // Adiciona a máscara de telefone ao carregar a página
        document.getElementById('telefone').addEventListener('input', aplicarMascara);

        // Adiciona máscara para CEP
        document.getElementById('cep').addEventListener('input', function(event) {
            let valor = event.target.value.replace(/\D/g, '');
            if (valor.length > 8) {
                valor = valor.substring(0, 8);
            }
            if (valor.length > 5) {
                event.target.value = valor.replace(/^(\d{5})(\d{3})$/, '$1-$2');
            } else {
                event.target.value = valor;
            }
        });
        
        // Exemplo de como a mensagem de status pode ser estilizada por JS
        // (Seu arquivo proc_escola.php deve definir essa mensagem)
        document.addEventListener('DOMContentLoaded', function() {
            const statusDiv = document.getElementById('mensagem-status');
            if (statusDiv.textContent.includes("sucesso")) {
                statusDiv.style.backgroundColor = 'rgba(0, 255, 0, 0.2)';
                statusDiv.style.border = '1px solid #00ff00';
            } else if (statusDiv.textContent.includes("erro")) {
                statusDiv.style.backgroundColor = 'rgba(255, 0, 0, 0.2)';
                statusDiv.style.border = '1px solid #ff0000';
            }
        });
        
    </script>
</body>
</html>