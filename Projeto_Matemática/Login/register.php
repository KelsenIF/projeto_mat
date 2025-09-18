<?php
include_once('../Include/connection.php');

$sql_institute = "SELECT * FROM escolas ORDER BY id DESC";
$institute = $pdo->prepare($sql_institute);
$institute->execute();
$institutes = $institute->fetchAll(PDO::FETCH_ASSOC);

$sql_escolaridade = "SELECT id, nome_escolaridade, id_nível_ensino FROM anos_escolaridades ORDER BY id DESC";
$escolaridade = $pdo->prepare($sql_escolaridade);
$escolaridade->execute();
$escolaridades = $escolaridade->fetchAll(PDO::FETCH_ASSOC);

$sql_disciplina = "SELECT id, disciplina, id_escolaridade FROM disciplinas ORDER BY id DESC";
$disciplina = $pdo->prepare($sql_disciplina);
$disciplina->execute();
$disciplinas = $disciplina->fetchAll(PDO::FETCH_ASSOC);
?>

<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CADASTRO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-lg p-4">
                    <h1 class="card-title text-center mb-4">CADASTRO</h1>
                    <form action="register_process.php" method="POST">
                        <div class="row g-3 mb-3">
                            <div class="col-sm-6">
                                <input type="text" id="user" name="user" class="form-control" placeholder="Matrícula"
                                    required>
                            </div>
                            <div class="col-sm-6">
                                <input type="text" id="name" name="name" class="form-control" placeholder="Nome"
                                    required>
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-sm-6">
                                <input type="password" id="password" name="password" class="form-control"
                                    placeholder="Senha" required>
                            </div>
                            <div class="col-sm-6">
                                <input type="password" id="password-confirm" name="password-confirm"
                                    class="form-control" placeholder="Confirmar senha" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <select id="institution" name="institution" class="form-select" required>
                                <option value="">Selecione uma instituição de ensino...</option>
                                <?php foreach ($institutes as $institute) { ?>
                                    <option value="<?php echo $institute['id'] ?>">
                                        <?php echo $institute['Nome'] ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <select id="class" name="class" class="form-select" required>
                                <option value="">Selecione uma turma...</option>
                                <?php foreach ($escolaridades as $escolaridadeW) { ?>
                                    <option value="<?php echo $escolaridadeW['id'] ?>">
                                        <?php echo $escolaridadeW['nome_escolaridade'] ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">CADASTRAR</button>
                        </div>

                        <div class="d-flex justify-content-center mt-3">
                            <a class="text-decoration-none" href="login.php">FAZER LOGIN</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"