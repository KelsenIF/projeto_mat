<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CADASTRAR - ESCOLA</title>
</head>

<body>

    <div>
        <div>
            <div>
                <h3>Cadastro - Nova Instituição de Ensino</h3>
                <p>Preencha os dados de forma completa para o registro no sistema.</p>
            </div>
            <div>
                <form class="#" action="proc_escola.php" method="POST">

                    <fieldset>
                        <legend>Dados Principais</legend>
                        <div>
                            <div>
                                <label for="nome_escola">Nome da Escola</label>
                                <input type="text" id="nome_escola" name="nome_escola"
                                    placeholder="ESCOLA ESTADUAL BUENO BRANDÃO" required>
                            </div>
                            <div>
                                <label for="cod_inep">CÓDIGO INEP</label>
                                <input type="text" id="cod_inep" name="cod_inep" placeholder="31000000" required>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset>
                        <legend>Localização</legend>
                        <div>
                            <div>
                                <label for="cep">CEP</label>
                                <input type="text" id="cep" name="cep" maxlength="9" placeholder="37410-000" required>
                            </div>
                            <div>
                                <button type="button" onclick="validarCepEPreencher()">VALIDAR CEP</button>
                            </div>
                            <div>
                                <label for="rua">Rua / Logradouro</label>
                                <input type="text" id="rua" name="rua"
                                    placeholder="Rua Professor Antonio de Oliveira Filho" readonly required>
                            </div>
                        </div>

                        <div>
                            <div>
                                <label for="numero">Nº</label>
                                <input type="text" id="numero" name="numero" placeholder="174" required>
                            </div>
                            <div>
                                <label for="bairro">Bairro</label>
                                <input type="text" id="bairro" name="bairro" placeholder="Centro" readonly required>
                            </div>
                            <div>
                                <label for="cidade">Cidade</label>
                                <input type="text" id="cidade" name="cidade" placeholder="Três Corações" readonly
                                    required>
                            </div>
                            <div>
                                <label for="estado">Estado</label>
                                <input type="text" id="estado" name="estado" maxlength="2" readonly required>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset>
                        <legend>Contato e Classificação</legend>
                        <div>
                            <div>
                                <label for="telefone">Telefone</label>
                                <input type="tel" id="telefone" name="telefone" maxlength="15"
                                    onkeyup="aplicarMascara(this)" placeholder="(35)3231-1009" required>
                            </div>
                            <div>
                                <label for="email">Email</label>
                                <input type="email" id="email" name="email"
                                    placeholder="escola.174386@educacao.mg.gov.br" required>
                            </div>
                        </div>

                        <hr>

                        <div>
                            <div>
                                <label>
                                    Etapas de Ensino Fornecidas:
                                </label>
                                <div>
                                    <div>
                                        <input type="checkbox" id="ensino_fundamental" value="E. Fundamental"
                                            name="etapa_ensino[]">
                                        <label for="ensino_fundamental">Ensino Fundamental</label>
                                    </div>
                                    <div>
                                        <input type="checkbox" id="ensino_medio" value="E. Médio" name="etapa_ensino[]">
                                        <label for="ensino_medio">Ensino Médio</label>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label>
                                    Tipo de Instituição:
                                </label>
                                <div>
                                    <div>
                                        <input type="radio" name="tipo_escola" id="instituicao_publica" value="pública"
                                            required>
                                        <label for="instituicaoPublica">Pública</label>
                                    </div>
                                    <div>
                                        <input type="radio" name="tipo_escola" id="instituicao_privada" value="privada">
                                        <label for="instituicaoPrivada">Privada</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>

                    <div>
                        <button type="reset">Limpar</button>
                        <button type="submit" name="submit">Cadastrar Escola</button>
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
                input.value = valor.replace(/^(\d{2})(\d*)$/, '($1) $2');
            } else if (valor.length > 0) {
                // Apenas o primeiro dígito: (9
                input.value = valor.replace(/^(\d*)$/, '($1');
            }
        }
        </script>
</body>

</html>