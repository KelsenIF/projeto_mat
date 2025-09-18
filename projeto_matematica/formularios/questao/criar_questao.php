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
        echo "<script>alert('questao criada com sucesso e enviada para análise!'); window.location.href = '../../Dashboards/index.php';</script>";
    } else {
        echo "<script>alert('Erro ao criar a questao.');</script>";
    }
}

// Consultas para popular os dropdowns do formulário (nivel de ensino, escolaridade, disciplinas)
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
    <title>Criar - questao</title>
    <link rel="stylesheet" href="../../Include/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body>
    <form class="#" action="#" method="POST" enctype="multipart/form-data">

        <div class="#">
            <label for="enunciado" class="#">ENUNCIADO:</label>
            <textarea class="#" id="enunciado" name="enunciado" rows="4" required></textarea>
        </div>

        <div class="mb-3">
            <label for="foto_quest" class="#">Imagem da questao</label>
            <input class="#" type="file" id="foto_quest" name="foto_quest" accept="image/*">
        </div>

        <div class="#">
            <label for="alt_correta" class="#">Alternativa Correta</label>
            <input type="text" class="#" id="alt_correta" name="alt_correta" required>
        </div>

        <div class="#">
            <label for="alt_errada1" class="#">Alternativa Errada 1</label>
            <input type="text" class="#" id="alt_errada1" name="alt_errada1" required>

            <label for="alt_errada2" class="#">Alternativa Errada 2</label>
            <input type="text" class="#" id="alt_errada2" name="alt_errada2" required>

            <label for="alt_errada3" class="#">Alternativa Errada 3</label>
            <input type="text" class="#" id="alt_errada3" name="alt_errada3" required>
        </div>

        <div class="#">
            <label for="origem" class="#">Origem</label>
            <input type="text" class="#" id="origem" name="origem" required>
        </div>

        <div class="#">
            <label for="nivel_de_ensino" class="#">nivel de ensino:</label>
            <select id="nivel_de_ensino" name="nivel_de_ensino" class="#" required>
                <option value="">Selecione um nivel de ensino</option>
                <?php foreach ($niveis_ensino as $ensinoW) { ?>
                    <option value="<?php echo $ensinoW['id'] ?>"><?php echo $ensinoW['nivel_ensino'] ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="#">
            <label for="ano_escolaridade" class="#">Ano de escolaridade:</label>
            <select id="ano_escolaridade" name="ano_escolaridade" class="#" required>
                <option value="">Selecione um ano de escolaridade</option>
            </select>
        </div>

        <div class="#">
            <label for="disciplinas" class="#">disciplina:</label>
            <select id="disciplinas" name="disciplinas" class="#" required>
                <option value="">Selecione uma disciplina</option>
            </select>
        </div>

        <div>
            <button name="action" value="criar_questao" type="submit">CRIAR</button>
        </div>

    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>

    <script>
        const escolaridadesData = <?php echo json_encode($escolaridades); ?>;
        const disciplinasData = <?php echo json_encode($disciplinas); ?>;

        const nivelEnsinoSelect = document.getElementById('nivel_de_ensino');
        const anoEscolaridadeSelect = document.getElementById('ano_escolaridade');
        const disciplinasSelect = document.getElementById('disciplinas');

        function atualizarAnosEscolaridade() {
            const nivelId = parseInt(nivelEnsinoSelect.value, 10);
            anoEscolaridadeSelect.innerHTML = '<option value="">Selecione um ano de escolaridade</option>';
            disciplinasSelect.innerHTML = '<option value="">Selecione uma disciplina</option>';

            if (!isNaN(nivelId)) {
                const escolaridadesFiltradas = escolaridadesData.filter(
                    (escolaridade) => escolaridade.id_nivel_ensino === nivelId
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
                    (disciplina) => disciplina.id_escolaridade === escolaridadeId
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