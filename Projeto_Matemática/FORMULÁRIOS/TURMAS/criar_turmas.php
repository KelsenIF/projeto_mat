<?php
require_once('../../DASHBOARDS/include/connection.php');

// Lógica para buscar as escolas para o select
$sql_escolas = "SELECT cod_inep, nome_escola FROM escolas ORDER BY nome_escola ASC";
$stmt = $pdo->prepare($sql_escolas);
$stmt->execute();
$escolas = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRIAR - TURMA</title>
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
        h2 {
            color: var(--neon-magenta);
            text-shadow: 0 0 5px var(--neon-magenta);
            margin-bottom: 25px;
            letter-spacing: 1.5px;
            text-align: center;
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
        
        label {
            color: var(--text-color);
            margin-bottom: 5px;
            display: block;
            font-weight: bold;
        }

        /* Estilo para Inputs e Selects */
        .form-control, select.form-control {
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
    <form class="form-neon" action="proc_turmas.php" method="POST">
        <h2 class="text-center">Criar Nova Turma</h2>

        <div class="mb-3">
            <label for="nome_turma">Nome da Turma:</label>
            <input type="text" class="form-control" id="nome_turma" name="nome_turma" placeholder="Ex: 8A ou 3º EM Noite" required>
        </div>

        <div class="mb-3">
            <label for="cod_inep">Instituição de Ensino:</label>
            <select class="form-control" id="cod_inep" name="cod_inep" required>
                <option value="">Selecione a Escola...</option>
                <?php foreach ($escolas as $escola) { ?>
                    <option value="<?php echo htmlspecialchars($escola['cod_inep']); ?>">
                        <?php echo htmlspecialchars($escola['nome_escola']); ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="d-grid">
            <button type="submit" class="btn-neon">Cadastrar Turma</button>
        </div>
    </form>
</body>
</html>