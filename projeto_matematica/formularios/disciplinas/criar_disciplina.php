<?php
include_once('../../Include/connection.php');

$sql_ensino = "SELECT * FROM niveis_ensino ORDER BY id DESC";
$ensino = $pdo->prepare($sql_ensino);
$ensino->execute();

$sql_escolaridade = "SELECT * FROM anos_escolaridades ORDER BY id DESC";
$escolaridade = $pdo->prepare($sql_escolaridade);
$escolaridade->execute();

?>

<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Criar - Disciplina</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body>
    <form class="#" action="#" method="POST">
        <div class="#">
            <label for="nivel_de_ensino" class="#">nivel de ensino:</label>
            <select id="nivel_de_ensino" name="nivel_de_ensino" class="#" required>
                <?php
                while ($ensinoW = $ensino->fetch(PDO::FETCH_ASSOC)) { ?>
                    <option value="<?php echo $ensinoW['id'] ?>"><?php echo $ensinoW['nivel_ensino'] ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="#">
            <label for="ano_escolaridade" class="#">Ano de escolaridade:</label>
            <select id="ano_escolaridade" name="ano_escolaridade" class="#" required>
                <!-- É preciso um JavaScript aqui, mas não sei como fazê-lo -->
                <?php
                while ($escolaridadeW = $escolaridade->fetch(PDO::FETCH_ASSOC)) { ?>
                    <option value="<?php echo $escolaridadeW['id'] ?>"><?php echo $escolaridadeW['nome_escolaridade'] ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="#">
           <label for="disciplinas" class="#">disciplina:</label>
            <input class="#" type="text" id="disciplinas" name="disciplinas">
        </div>

        <div>
            <button name="action" value="criar_disciplina" type="submit">CRIAR</button>
        </div>
    </form>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>

</html>