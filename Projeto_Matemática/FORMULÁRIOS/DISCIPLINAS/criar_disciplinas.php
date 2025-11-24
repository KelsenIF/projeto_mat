<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRIAR - DISCIPLINA</title>
</head>

<body>
    <form action="proc_disciplinas.php" method="POST">

        <div>
            <label for="disciplina">Nome da Disciplina:</label>
            <input type="text" id="disciplina" name="disciplina" required placeholder="Ex: Função Afim">
        </div>

        <br>

        <fieldset>
            <legend>Série de Aplicação</legend>

            <div>
                <input type="radio" id="serie_6" name="id_escolaridade" value="1" required>
                <label for="serie_6">6º Ano (Ens. Fund.)</label>
            </div>
            <div>
                <input type="radio" id="serie_7" name="id_escolaridade" value="2">
                <label for="serie_7">7º Ano (Ens. Fund.)</label>
            </div>
            <div>
                <input type="radio" id="serie_8" name="id_escolaridade" value="3">
                <label for="serie_8">8º Ano (Ens. Fund.)</label>
            </div>
            <div>
                <input type="radio" id="serie_9" name="id_escolaridade" value="4">
                <label for="serie_9">9º Ano (Ens. Fund.)</label>
            </div>

            <hr>

            <div>
                <input type="radio" id="serie_1" name="id_escolaridade" value="5">
                <label for="serie_1">1º Ano (Ens. Médio)</label>
            </div>
            <div>
                <input type="radio" id="serie_2" name="id_escolaridade" value="6">
                <label for="serie_2">2º Ano (Ens. Médio)</label>
            </div>
            <div>
                <input type="radio" id="serie_3" name="id_escolaridade" value="7">
                <label for="serie_3">3º Ano (Ens. Médio)</label>
            </div>
        </fieldset>

        <input type="hidden" id="action" name="action" value="CRIAR">
        <button type="submit">Cadastrar Disciplina</button>
    </form>
</body>

</html>