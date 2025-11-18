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

                    <form action="register_process.php" method="POST" enctype="multipart/form-data">

                        <div class="mb-3">
                            <label for="inputArquivoImagem" class="form-label">Foto de perfil:</label>
                            <input class="form-control" type="file" id="inputArquivoImagem" name="imagem_upload"
                                accept="image/*" required />
                        </div>

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
                                    <option value="<?php echo $institute['Código'] ?>">
                                        <?php echo $institute['Nome'] ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <select id="class" name="class" class="form-select" required disabled>
                                <option value="">Selecione uma turma...</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <select id="security_question" name="security_question" class="form-select"
                                        required>
                                        <option value="">Selecione uma pergunta...</option>
                                        <?php foreach ($perguntas_seguranca as $pergunta) { ?>
                                            <option value="<?php echo htmlspecialchars($pergunta) ?>">
                                                <?php echo $pergunta ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="col-sm-6">
                                    <input type="text" id="security_answer" name="security_answer" class="form-control"
                                        placeholder="Resposta da Pergunta" required>
                                </div>
                            </div>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        
        document.addEventListener('DOMContentLoaded', function () {
            const institutionSelect = document.getElementById('institution');
            const classSelect = document.getElementById('class');

            institutionSelect.addEventListener('change', function () {
                const instituteId = this.value;

                classSelect.innerHTML = '<option value="">Carregando turmas...</option>';
                classSelect.disabled = true;

                if (instituteId === "") {
                    classSelect.innerHTML = '<option value="">Selecione uma turma...</option>';
                    return;
                }

                fetch('get_classes.php?institute_id=' + instituteId)
                    .then(response => response.json())
                    .then(data => {
                        classSelect.innerHTML = '<option value="">Selecione uma turma...</option>';

                        if (data.length > 0) {
                            data.forEach(turma => {
                                const option = document.createElement('option');
                                option.value = turma.id;
                                option.textContent = turma.nome;
                                classSelect.appendChild(option);
                            });
                            classSelect.disabled = false;
                        } else {
                            classSelect.innerHTML = '<option value="">Nenhuma turma encontrada para esta instituição.</option>';
                        }
                    })
                    .catch(error => {
                        console.error('Erro ao buscar turmas:', error);
                        classSelect.innerHTML = '<option value="">Erro ao carregar turmas.</option>';
                    });
            });
        });
    </script>
</body>

</html>