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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
        /* Variáveis de cor (Sincronizadas com o dashboard) */
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

        h2 {
            color: var(--neon-magenta);
            text-shadow: 0 0 5px var(--neon-magenta);
            margin-bottom: 25px;
            letter-spacing: 1.5px;
        }

        /* Container de Login e Registro */
        .form-neon {
            background-color: var(--dark-bg-area);
            padding: 40px;
            border-radius: 8px;
            border: 1px solid var(--neon-blue);
            box-shadow: var(--shadow-intensity) var(--neon-blue),
                0 0 20px rgba(255, 0, 255, 0.2);
            width: 100%;
            max-width: 600px; /* Mais largo para o formulário de registro */
        }

        /* Fieldset (apenas no registro) */
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
            width: inherit; /* Auto-ajuste de largura */
            padding: 0 10px; /* Espaçamento interno */
            border-bottom: none;
            font-size: 1.1em;
            margin-bottom: 0; /* Remove a margem padrão */
        }

        label {
            color: var(--text-color);
            margin-bottom: 5px;
            display: block;
            font-weight: bold;
        }

        /* Estilo para Inputs e Selects */
        .form-control,
        select.form-control,
        input[type="file"] {
            background-color: var(--item-bg) !important;
            border: 1px solid var(--neon-blue) !important;
            color: var(--neon-blue) !important;
            box-shadow: 0 0 3px rgba(0, 255, 255, 0.5) !important;
            transition: all 0.2s;
            width: 100%; /* Garante que os selects e inputs ocupem todo o espaço */
            padding: 0.375rem 0.75rem; /* Padrão Bootstrap */
            height: auto; /* Altura automática */
        }

        .form-control::placeholder {
            color: rgba(0, 255, 255, 0.5) !important;
        }

        .form-control:focus {
            background-color: var(--dark-bg-area) !important;
            border-color: var(--neon-magenta) !important;
            box-shadow: 0 0 8px var(--neon-magenta) !important;
        }

        /* Corrigir a cor do texto do input file */
        input[type="file"] {
            color: var(--text-color) !important;
        }

        /* Botão Neon */
        .btn-neon {
            --btn-color: var(--neon-magenta);
            background: transparent;
            color: var(--btn-color);
            border: 1px solid var(--btn-color);
            padding: 10px 20px;
            border-radius: 5px;
            box-shadow: 0 0 5px var(--btn-color);
            transition: all 0.3s;
            width: 100%;
            margin-top: 10px;
        }

        .btn-neon:hover {
            background: var(--btn-color);
            color: var(--dark-bg-area);
            box-shadow: 0 0 15px var(--btn-color);
        }

        /* Links */
        .link-neon {
            color: var(--neon-blue) !important;
            text-shadow: 0 0 5px rgba(0, 255, 255, 0.4);
            text-decoration: none;
            font-weight: bold;
            transition: text-shadow 0.2s;
        }

        .link-neon:hover {
            color: var(--neon-magenta) !important;
            text-shadow: 0 0 8px var(--neon-magenta);
        }

        /* Estilo para o feedback de CPF */
        #cpfFeedback {
            font-weight: bold;
        }

        /* Container de links no footer */
        .link-container {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <form class="form-neon" action="proc_registro.php" method="POST" enctype="multipart/form-data">
        <h2 class="text-center">CADASTRO</h2>

        <fieldset class="fieldset-neon">

            <legend>Informações pessoais:</legend>
            <div class="mb-3">
                <label for="foto_perfil">Foto de perfil:</label>
                <input type="file" class="form-control" id="foto_perfil" name="foto_perfil" accept="image/*" />
            </div>
            <div class="mb-3">
                <label for="cpf">CPF:</label>
                <input type="text" class="form-control" id="cpf" name="cpf" placeholder="000.000.000-00" required maxlength="14" />
                <span id="cpfFeedback" style="display: block; font-size: 0.9em; margin-top: 5px;"></span>
            </div>
            <div class="mb-3">
                <label for="nome">Nome Completo:</label>
                <input type="text" class="form-control" id="nome" name="nome" placeholder="NOME COMPLETO" required />
            </div>
            <div class="mb-3">
                <label for="email">Insira seu e-mail:</label>
                <input type="text" class="form-control" id="email" name="email" placeholder="EMAIL" required />
            </div>
        </fieldset>

        <fieldset class="fieldset-neon">
            <legend>Senha:</legend>
            <div class="mb-3">
                <label for="senha">Senha:</label>
                <input type="password" class="form-control" id="senha" name="senha" placeholder="senha" required>
            </div>
            <div class="mb-3">
                <label for="conf_senha">Confirmar Senha:</label>
                <input type="password" class="form-control" id="conf_senha" name="conf_senha" placeholder="Confirmar senha" required>
            </div>
        </fieldset>

        <fieldset class="fieldset-neon">
            <legend>Instituição e Turma:</legend>
            <div class="mb-3">
                <label for="nome_escola">Instituição:</label>
                <select class="form-control" id="nome_escola" name="nome_escola" required>
                    <option value="">Selecione uma instituição de ensino...</option>
                    <?php foreach ($escolas as $item) { ?>
                        <option value="<?php echo $item['cod_inep'] ?>">
                            <?php echo $item['nome_escola'] ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="turma">Turma:</label>
                <select class="form-control" id="turma" name="turma" required disabled>
                    <option value="">Selecione uma turma...</option>
                </select>
            </div>
        </fieldset>

        <div class="d-grid gap-2">
            <button type="submit" class="btn-neon">CADASTRAR</button>
            <input hidden name="nivel_de_acesso" value="0">
        </div>

        <div class="link-container">
            <a class="link-neon" href="../LOGIN/login.php">FAZER LOGIN</a>
            <a class="link-neon" href="login.php">CADASTRAR ESCOLA</a>
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

            cpfInput.addEventListener('blur', function () {
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