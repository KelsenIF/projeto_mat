<?php

include_once('../Dashboards/Include/connection.php');

$sql_institute = "SELECT * FROM escolas ORDER BY id DESC";
$institute = $pdo->prepare($sql_institute);
$institute->execute();
$institutes = $institute->fetchAll(PDO::FETCH_ASSOC);


$perguntas_seguranca = [
    "Qual o nome do seu primeiro animal de estimação?",
    "Qual o nome da rua onde você nasceu?",
    "Qual o seu livro ou filme favorito de infância?",
    "Qual o nome do meio da sua mãe?",
    "Qual a sua comida favorita?",
];
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Recuperar acesso</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-lg p-4">
                    <div class="card-body">
                        <h1 class="card-title text-center mb-4">Recuperar Acesso</h1>
                        <p class="text-center text-muted mb-4">Preencha os campos abaixo para iniciar a recuperação da
                            sua senha.</p>

                        <form action="recover_access_process.php" method="POST">

                            <div class="mb-3">
                                <label for="user" class="form-label">Matrícula</label>
                                <input type="text" id="user" name="user" class="form-control"
                                    placeholder="Digite sua matrícula" required>
                            </div>

                            <div class="mb-3">
                                <label for="institution" class="form-label">Instituição de Ensino</label>
                                <select id="institution" name="institution" class="form-select" required>
                                    <option value="" disabled selected>Selecione uma instituição...</option>
                                    <?php foreach ($institutes as $institute) { ?>
                                        <option value="<?php echo htmlspecialchars($institute['Código']) ?>">
                                            <?php echo htmlspecialchars($institute['Nome']) ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="row mb-4">
                                <div class="col-12 mb-3">
                                    <label for="security_question" class="form-label">Pergunta de Segurança</label>
                                    <select id="security_question" name="security_question" class="form-select"
                                        required>
                                        <option value="" disabled selected>Selecione uma pergunta...</option>
                                        <?php foreach ($perguntas_seguranca as $pergunta) { ?>
                                            <option value="<?php echo htmlspecialchars($pergunta) ?>">
                                                <?php echo htmlspecialchars($pergunta) ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="col-12">
                                    <label for="security_answer" class="form-label">Resposta de Segurança</label>
                                    <input type="text" id="security_answer" name="security_answer" class="form-control"
                                        placeholder="Sua resposta:" required>
                                </div>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg">Recuperar Acesso</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
        </script>
</body>

</html>