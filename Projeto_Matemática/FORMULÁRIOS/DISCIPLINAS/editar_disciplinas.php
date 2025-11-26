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
    <title><?= $titulo_pagina ?></title>
</head>

<body>
    
    <h1>Edição de Disciplina</h1>
    
    <form action="proc_disciplinas.php" method="POST">
        
        <input type="hidden" name="id" value="<?= htmlspecialchars($disciplina['id']) ?>">

        <div>
            <label for="disciplina">Nome da Disciplina:</label>
            <input 
                type="text" 
                id="disciplina" 
                name="disciplina"
                value="<?= htmlspecialchars($disciplina['disciplina']); ?>" 
                required
                placeholder="Ex: Função Afim">
        </div>

        <br>

        <fieldset>
            <legend>Série de Aplicação</legend>

            <div>
                <input type="radio" id="serie_6" name="id_escolaridade" value="1" required
                       <?= $id_escolaridade == 1 ? 'checked' : '' ?>>
                <label for="serie_6">6º Ano (Ens. Fund.)</label>
            </div>
            <div>
                <input type="radio" id="serie_7" name="id_escolaridade" value="2"
                       <?= $id_escolaridade == 2 ? 'checked' : '' ?>>
                <label for="serie_7">7º Ano (Ens. Fund.)</label>
            </div>
            <div>
                <input type="radio" id="serie_8" name="id_escolaridade" value="3"
                       <?= $id_escolaridade == 3 ? 'checked' : '' ?>>
                <label for="serie_8">8º Ano (Ens. Fund.)</label>
            </div>
            <div>
                <input type="radio" id="serie_9" name="id_escolaridade" value="4"
                       <?= $id_escolaridade == 4 ? 'checked' : '' ?>>
                <label for="serie_9">9º Ano (Ens. Fund.)</label>
            </div>

            <hr>

            <div>
                <input type="radio" id="serie_1" name="id_escolaridade" value="5"
                       <?= $id_escolaridade == 5 ? 'checked' : '' ?>>
                <label for="serie_1">1º Ano (Ens. Médio)</label>
            </div>
            <div>
                <input type="radio" id="serie_2" name="id_escolaridade" value="6"
                       <?= $id_escolaridade == 6 ? 'checked' : '' ?>>
                <label for="serie_2">2º Ano (Ens. Médio)</label>
            </div>
            <div>
                <input type="radio" id="serie_3" name="id_escolaridade" value="7"
                       <?= $id_escolaridade == 7 ? 'checked' : '' ?>>
                <label for="serie_3">3º Ano (Ens. Médio)</label>
            </div>
        </fieldset>

        <input type="hidden" id="action" name="action" value="EDITAR">
        <button type="submit">Salvar Alterações</button>
    </form>
</body>

</html>