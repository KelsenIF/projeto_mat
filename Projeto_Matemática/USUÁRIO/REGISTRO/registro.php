<?php

require_once('../../DASHBOARDS/include/connection.php');

$sql_escola = "SELECT * FROM escolas ORDER BY id DESC";
$stmt = $pdo->prepare($sql_escola); 
$stmt->execute();
$escolas = $stmt->fetchAll(PDO::FETCH_ASSOC);


if (!isset($escolas)) {
    $escolas = []; 
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REGISTRO</title>
</head>

<body>
    <form class="#" action="proc_registro.php" method="POST" enctype="multipart/form-data">

        <fieldset>

            <legend>Informações pessoais:</legend>
            <div class="">
                <label for="foto_perfil">Foto de perfil:</label>
                <input type="file" id="foto_perfil" name="foto_perfil" accept="image/*" required />
            </div>
            <div class="#">
                <label for="cpf">CPF:</label>
                <input type="text" id="cpf" name="cpf" placeholder="000.000.000-00" required maxlength="14" />
                <span id="cpfFeedback" style="display: block; font-size: 0.9em; margin-top: 5px;"></span>
            </div>
            <div class="#">
                <label for="nome">Nome Completo:</label>
                <input type="text" id="nome" name="nome" placeholder="NOME COMPLETO" required />
            </div>
            <div class="#">
                <label for="email">Insira seu e-mail:</label>
                <input type="text" id="email" name="email" placeholder="EMAIL" required />
            </div>
        </fieldset>

        <fieldset>
            <legend>Senha:</legend>
            <div class="#">
                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="senha" placeholder="senha" required>
            </div>
            <div class="#">
                <label for="conf_senha">Confirmar Senha:</label>
                <input type="password" id="conf_senha" name="conf_senha" placeholder="Confirmar senha" required>
            </div>
        </fieldset>

        <fieldset>
            <legend>Instituição e Turma:</legend>
            <div class="">
                <select id="nome_escola" name="nome_escola" required>
                    <option value="">Selecione uma instituição de ensino...</option>
                    <?php foreach ($escolas as $item) { ?>
                        <option value="<?php echo $item['cod_inep'] ?>">
                            <?php echo $item['nome_escola'] ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div class="">
                <select class="" id="turma" name="turma" required disabled>
                    <option value="">Selecione uma turma...</option>
                </select>
            </div>
        </fieldset>

        <div class="">
            <button type="submit" class="">CADASTRAR</button>
            <input hidden name="nivel_de_acesso" value="0">
        </div>
        <div class="#">
            <a class="text-decoration-none" href="../LOGIN/login.php">FAZER LOGIN</a>
        </div>
        <div class="#">
            <a class="text-decoration-none" href="login.php">CADASTRAR ESCOLA</a>
        </div>
    </form>
    <script>
        
        function aplicarMascaraCPF(event) {
            let input = event.target;
            let value = input.value.replace(/\D/g, ''); 
            

            if (value.length > 11) {
                value = value.substring(0, 11);
            }

 
            if (value.length > 9) {
                value = value.replace(/^(\d{3})(\d{3})(\d{3})(\d{2})$/, '$1.$2.$3-$4');
            } else if (value.length > 6) {
                value = value.replace(/^(\d{3})(\d{3})(\d{3})$/, '$1.$2.$3');
            } else if (value.length > 3) {
                value = value.replace(/^(\d{3})(\d{3})$/, '$1.$2');
            } else if (value.length > 0) {
                value = value.replace(/^(\d{3})$/, '$1');
            }

            input.value = value;
        }

        function validarCPF(cpf) {
            cpf = cpf.replace(/[^\d]/g, ""); 

            if (cpf.length !== 11 || /^(\d)\1+$/.test(cpf)) return false;

            let soma = 0;
            let resto;
            let i;
            let digito;

           
            for (i = 1; i <= 9; i++) {
                soma = soma + parseInt(cpf.substring(i - 1, i)) * (11 - i);
            }
            resto = (soma * 10) % 11;
            digito = (resto === 10 || resto === 11) ? 0 : resto;
            if (digito !== parseInt(cpf.substring(9, 10))) return false;

            soma = 0;

        
            for (i = 1; i <= 10; i++) {
                soma = soma + parseInt(cpf.substring(i - 1, i)) * (12 - i);
            }
            resto = (soma * 10) % 11;
            digito = (resto === 10 || resto === 11) ? 0 : resto;
            if (digito !== parseInt(cpf.substring(10, 11))) return false;

            return true; 
        }

        

        document.addEventListener('DOMContentLoaded', function () {
            const escolaSelect = document.getElementById('nome_escola');
            const turmaSelect = document.getElementById('turma');
            const cpfInput = document.getElementById('cpf');
            const cpfFeedback = document.getElementById('cpfFeedback');

            
            cpfInput.addEventListener('input', aplicarMascaraCPF);

            cpfInput.addEventListener('blur', function() {
                const cpf = cpfInput.value;
                
                
                cpfFeedback.textContent = '';
                cpfFeedback.style.color = '';

               
                if (cpf.length === 14) { 
                    if (validarCPF(cpf)) {
                        cpfFeedback.textContent = '✅ CPF Válido!';
                        cpfFeedback.style.color = 'green';
                    } else {
                        cpfFeedback.textContent = '❌ CPF Inválido. Por favor, verifique.';
                        cpfFeedback.style.color = 'red';
                        cpfInput.focus(); 
                    }
                } else if (cpf.length > 0 && cpf.length < 14) {
                    cpfFeedback.textContent = 'O CPF deve estar completo (11 dígitos).';
                    cpfFeedback.style.color = 'orange';
                }
            });


            escolaSelect.addEventListener('change', function () {
                const cod_inep = this.value;

                turmaSelect.innerHTML = '<option value="">Carregando turmas...</option>';
                turmaSelect.disabled = true;

                if (cod_inep === "") {
                    turmaSelect.innerHTML = '<option value="">Selecione uma turma...</option>';
                    return;
                }

                fetch('get_turmas.php?cod_inep=' + cod_inep)
                    .then(response => response.json())
                    .then(data => {
                        turmaSelect.innerHTML = '<option value="">Selecione uma turma...</option>';

                        if (data.length > 0) {
                            data.forEach(turma => {
                                const option = document.createElement('option');
                                option.value = turma.id;
                                option.textContent = turma.nome;
                                turmaSelect.appendChild(option);
                            });
                            turmaSelect.disabled = false;
                        } else {
                            turmaSelect.innerHTML = '<option value="">Nenhuma turma encontrada para esta instituição.</option>';
                        }
                    })
                    .catch(error => {
                        console.error('Erro ao buscar turmas:', error);
                        turmaSelect.innerHTML = '<option value="">Erro ao carregar turmas.</option>';
                    });
            });
        });
    </script>
</body>
</html>