<?php

require_once('../../DASHBOARDS/include/connection.php');


if (!isset($_GET['id'])) {
    die("ID inválido! Por favor, volte para a lista de disciplinas.");
}

$id = intval($_GET['id']);

$sql_disc = "SELECT * FROM disciplinas WHERE id = :id";
$stmt = $pdo->prepare($sql_disc);
$stmt->bindParam(":id", $id, PDO::PARAM_INT);
$stmt->execute();
$disciplina = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$disciplina) {
    die("Disciplina não encontrada!");
}


$id_escolaridade = $disciplina['id_escolaridade']; 
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EDITAR - DISCIPLINA</title>
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
        h1 {
            color: var(--neon-magenta);
            text-shadow: 0 0 5px var(--neon-magenta);
            margin-bottom: 25px;
            letter-spacing: 1.5px;
            text-align: center;
            font-size: 1.5rem; /* Ajuste o tamanho do h1 para formulário */
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
            max-width: 500px;
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

        /* Estilo para Inputs */
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

        /* Estilo para Radio Buttons */
        .form-check {
            margin-bottom: 8px;
        }
        .form-check-input {
            margin-top: 0.35em;
        }
        .form-check-input:checked {
            background-color: var(--neon-magenta) !important;
            border-color: var(--neon-magenta) !important;
        }

        .form-check-label {
            color: var(--text-color);
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
            margin-top: 20px;
        }

        .btn-neon:hover, .btn-neon:focus {
            background: var(--btn-color);
            color: var(--dark-bg-area);
            box-shadow: 0 0 15px var(--btn-color);
            border-color: var(--btn-color);
        }
    </style>
</head>

<body>
    <form class="form-neon" action="proc_disciplinas.php" method="POST">
        
        <h1>Edição de Disciplina</h1>
        
        <input type="hidden" name="id" value="<?= htmlspecialchars($disciplina['id']) ?>">

        <div class="mb-3">
            <label for="disciplina">Nome da Disciplina:</label>
            <input 
                type="text" 
                class="form-control"
                id="disciplina" 
                name="disciplina"
                value="<?= htmlspecialchars($disciplina['disciplina']); ?>" 
                required
                placeholder="Ex: Função Afim">
        </div>

        <br>

        <fieldset class="fieldset-neon">
            <legend>Série de Aplicação</legend>

            <div class="form-check">
                <input class="form-check-input" type="radio" id="serie_6" name="id_escolaridade" value="1" required
                       <?= $id_escolaridade == 1 ? 'checked' : '' ?>>
                <label class="form-check-label" for="serie_6">6º Ano (Ens. Fund.)</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" id="serie_7" name="id_escolaridade" value="2"
                       <?= $id_escolaridade == 2 ? 'checked' : '' ?>>
                <label class="form-check-label" for="serie_7">7º Ano (Ens. Fund.)</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" id="serie_8" name="id_escolaridade" value="3"
                       <?= $id_escolaridade == 3 ? 'checked' : '' ?>>
                <label class="form-check-label" for="serie_8">8º Ano (Ens. Fund.)</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" id="serie_9" name="id_escolaridade" value="4"
                       <?= $id_escolaridade == 4 ? 'checked' : '' ?>>
                <label class="form-check-label" for="serie_9">9º Ano (Ens. Fund.)</label>
            </div>

            <hr>

            <div class="form-check">
                <input class="form-check-input" type="radio" id="serie_1" name="id_escolaridade" value="5"
                       <?= $id_escolaridade == 5 ? 'checked' : '' ?>>
                <label class="form-check-label" for="serie_1">1º Ano (Ens. Médio)</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" id="serie_2" name="id_escolaridade" value="6"
                       <?= $id_escolaridade == 6 ? 'checked' : '' ?>>
                <label class="form-check-label" for="serie_2">2º Ano (Ens. Médio)</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" id="serie_3" name="id_escolaridade" value="7"
                       <?= $id_escolaridade == 7 ? 'checked' : '' ?>>
                <label class="form-check-label" for="serie_3">3º Ano (Ens. Médio)</label>
            </div>
        </fieldset>

        <div class="d-grid">
            <button type="submit" class="btn-neon">Atualizar Disciplina</button>
        </div>
    </form>
</body>
</html>