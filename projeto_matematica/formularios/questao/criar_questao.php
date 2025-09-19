<?php
// Incluir o arquivo de conexão com o banco de dados
include_once('../../Include/connection.php');

// Início da lógica para processar o formulário quando ele é enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'criar_questao') {
    // Coletar os dados do formulário de forma segura
    $enunciado = $_POST['enunciado'];
    $alt_correta = $_POST['alt_correta'];
    $alt_errada1 = $_POST['alt_errada1'];
    $alt_errada2 = $_POST['alt_errada2'];
    $alt_errada3 = $_POST['alt_errada3'];
    $origem = $_POST['origem'];
    $id_nivel_ensino = $_POST['nivel_de_ensino'];
    $id_escolaridade = $_POST['ano_escolaridade'];
    $id_assunto = $_POST['disciplinas'];
    $foto_questao = ''; // Variável para armazenar o caminho da imagem
    $id_situacao = 2; // Definir a situação como "em análise" para novas questões

    // Lógica para lidar com o upload da imagem
    if (isset($_FILES['foto_quest']) && $_FILES['foto_quest']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = '../../uploads/';
        $file_name = uniqid('quest_') . '_' . basename($_FILES['foto_quest']['name']);
        $file_path = $upload_dir . $file_name;

        // Verificar se o diretório de upload existe; se não, criá-lo
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        // Mover o arquivo temporário para o destino final
        if (move_uploaded_file($_FILES['foto_quest']['tmp_name'], $file_path)) {
            $foto_questao = $file_path;
        } else {
            // Se houver um erro no upload, exiba uma mensagem de erro
            die("Erro ao fazer o upload da imagem.");
        }
    }

    // Preparar e executar a inserção no banco de dados
    $sql_insert = "INSERT INTO questoes (enunciado, foto_questao, alt_correta, alt_incorreta1, alt_incorreta2, alt_incorreta3, origem, id_nivel_ensino, id_escolaridade, id_assunto, id_situacao) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $pdo->prepare($sql_insert);
    $stmt->execute([
        $enunciado,
        $foto_questao,
        $alt_correta,
        $alt_errada1,
        $alt_errada2,
        $alt_errada3,
        $origem,
        $id_nivel_ensino,
        $id_escolaridade,
        $id_assunto,
        $id_situacao
    ]);

    // Verificar se a inserção foi bem-sucedida e exibir uma mensagem
    if ($stmt->rowCount()) {
        echo "<script>alert('Questão criada com sucesso e enviada para análise!'); window.location.href = '../../Dashboards/index.php';</script>";
    } else {
        echo "<script>alert('Erro ao criar a questão.');</script>";
    }
}

// Consultas para popular os dropdowns do formulário (nível de ensino, escolaridade, disciplinas)
$sql_ensino = "SELECT * FROM niveis_ensino ORDER BY id DESC";
$ensino = $pdo->prepare($sql_ensino);
$ensino->execute();
$niveis_ensino = $ensino->fetchAll(PDO::FETCH_ASSOC);

$sql_escolaridade = "SELECT id, nome_escolaridade, id_nivel_ensino FROM anos_escolaridades ORDER BY id DESC";
$escolaridade = $pdo->prepare($sql_escolaridade);
$escolaridade->execute();
$escolaridades = $escolaridade->fetchAll(PDO::FETCH_ASSOC);

$sql_disciplina = "SELECT id, disciplina, id_escolaridade FROM assuntos ORDER BY id DESC";
$disciplina = $pdo->prepare($sql_disciplina);
$disciplina->execute();
$disciplinas = $disciplina->fetchAll(PDO::FETCH_ASSOC);

?>

<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Criar - Questão</title>
    <link rel="stylesheet" href="../../Include/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2kXJd5bSg9k35JpI5fI0dG3v9T3P5p4dC3b5sF55E+J3V9O9T3V5b5v5" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <div class="container mt-5">
        <div class="card shadow-lg p-4">
            <h1 class="text-center mb-4">Criar Questão</h1>
            <hr>
            <form class="needs-validation" action="#" method="POST" enctype="multipart/form-data" novalidate>
                <input type="hidden" name="action" value="criar_questao">

                <div class="mb-3">
                    <label for="enunciado" class="form-label">Enunciado:</label>
                    <textarea class="form-control" id="enunciado" name="enunciado" rows="4" required></textarea>
                    <div class="invalid-feedback">
                        Por favor, insira o enunciado da questão.
                    </div>
                </div>

                <div class="mb-3">
                    <label for="foto_quest" class="form-label">Imagem da questão (opcional)</label>
                    <input class="form-control" type="file" id="foto_quest" name="foto_quest" accept="image/*">
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="alt_correta" class="form-label">Alternativa Correta</label>
                        <input type="text" class="form-control" id="alt_correta" name="alt_correta" required>
                        <div class="invalid-feedback">
                            Campo obrigatório.
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="alt_errada1" class="form-label">Alternativa Errada 1</label>
                        <input type="text" class="form-control" id="alt_errada1" name="alt_errada1" required>
                        <div class="invalid-feedback">
                            Campo obrigatório.
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="alt_errada2" class="form-label">Alternativa Errada 2</label>
                        <input type="text" class="form-control" id="alt_errada2" name="alt_errada2" required>
                        <div class="invalid-feedback">
                            Campo obrigatório.
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="alt_errada3" class="form-label">Alternativa Errada 3</label>
                        <input type="text" class="form-control" id="alt_errada3" name="alt_errada3" required>
                        <div class="invalid-feedback">
                            Campo obrigatório.
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="origem" class="form-label">Origem</label>
                    <input type="text" class="form-control" id="origem" name="origem" required>
                    <div class="invalid-feedback">
                        Por favor, insira a origem da questão.
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="nivel_de_ensino" class="form-label">Nível de Ensino:</label>
                        <select id="nivel_de_ensino" name="nivel_de_ensino" class="form-select" required>
                            <option value="">Selecione um nível</option>
                            <?php foreach ($niveis_ensino as $ensinoW) { ?>
                                <option value="<?php echo htmlspecialchars($ensinoW['id']); ?>"><?php echo htmlspecialchars($ensinoW['nivel_ensino']); ?></option>
                            <?php } ?>
                        </select>
                        <div class="invalid-feedback">
                            Selecione um nível de ensino.
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="ano_escolaridade" class="form-label">Ano de Escolaridade:</label>
                        <select id="ano_escolaridade" name="ano_escolaridade" class="form-select" required>
                            <option value="">Selecione um ano</option>
                        </select>
                        <div class="invalid-feedback">
                            Selecione um ano de escolaridade.
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="disciplinas" class="form-label">Disciplina:</label>
                        <select id="disciplinas" name="disciplinas" class="form-select" required>
                            <option value="">Selecione uma disciplina</option>
                        </select>
                        <div class="invalid-feedback">
                            Selecione uma disciplina.
                        </div>
                    </div>
                </div>

                <div class="d-grid mt-4">
                    <button name="action" value="criar_questao" type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-plus-circle"></i> CRIAR
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script>
        // Adicionando a validação de formulário do Bootstrap
        (() => {
            'use strict'
            const forms = document.querySelectorAll('.needs-validation')
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
        })()

        const escolaridadesData = <?php echo json_encode($escolaridades); ?>;
        const disciplinasData = <?php echo json_encode($disciplinas); ?>;

        const nivelEnsinoSelect = document.getElementById('nivel_de_ensino');
        const anoEscolaridadeSelect = document.getElementById('ano_escolaridade');
        const disciplinasSelect = document.getElementById('disciplinas');

        function atualizarAnosEscolaridade() {
            const nivelId = parseInt(nivelEnsinoSelect.value, 10);
            anoEscolaridadeSelect.innerHTML = '<option value="">Selecione um ano</option>';
            disciplinasSelect.innerHTML = '<option value="">Selecione uma disciplina</option>';

            if (!isNaN(nivelId)) {
                const escolaridadesFiltradas = escolaridadesData.filter(
                    (escolaridade) => escolaridade.id_nivel_ensino == nivelId
                );
                escolaridadesFiltradas.forEach((escolaridade) => {
                    const option = document.createElement('option');
                    option.value = escolaridade.id;
                    option.textContent = escolaridade.nome_escolaridade;
                    anoEscolaridadeSelect.appendChild(option);
                });
            }
        }

        function atualizarDisciplinas() {
            const escolaridadeId = parseInt(anoEscolaridadeSelect.value, 10);
            disciplinasSelect.innerHTML = '<option value="">Selecione uma disciplina</option>';

            if (!isNaN(escolaridadeId)) {
                const disciplinasFiltradas = disciplinasData.filter(
                    (disciplina) => disciplina.id_escolaridade == escolaridadeId
                );
                disciplinasFiltradas.forEach((disciplina) => {
                    const option = document.createElement('option');
                    option.value = disciplina.id;
                    option.textContent = disciplina.disciplina;
                    disciplinasSelect.appendChild(option);
                });
            }
        }

        nivelEnsinoSelect.addEventListener('change', atualizarAnosEscolaridade);
        anoEscolaridadeSelect.addEventListener('change', atualizarDisciplinas);
    </script>
</body>

</html>