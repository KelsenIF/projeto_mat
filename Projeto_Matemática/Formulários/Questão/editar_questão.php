<?php
include_once('../../Include/connection.php');

$questao = null;
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql_questao = "SELECT * FROM questões WHERE id = ?";
    $stmt_questao = $pdo->prepare($sql_questao);
    $stmt_questao->execute([$id]);
    $questao = $stmt_questao->fetch(PDO::FETCH_ASSOC);

    if (!$questao) {
        die("Questão não encontrada.");
    }
} else {
    die("ID da questão não fornecido.");
}

// Lógica para processar o formulário de edição
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'editar_questão') {
    $id = $_POST['id'];
    $enunciado = $_POST['enunciado'];
    $alt_correta = $_POST['alt_correta'];
    $alt_errada1 = $_POST['alt_errada1'];
    $alt_errada2 = $_POST['alt_errada2'];
    $alt_errada3 = $_POST['alt_errada3'];
    $origem = $_POST['origem'];
    $id_nível_ensino = $_POST['nível_de_ensino'];
    $id_escolaridade = $_POST['ano_escolaridade'];
    $id_disciplina = $_POST['disciplinas'];
    $foto_questão = $_POST['foto_existente'];

    // Lógica para lidar com novo upload de imagem
    if (isset($_FILES['foto_quest']) && $_FILES['foto_quest']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = '../../uploads/';
        $file_name = uniqid('quest_') . '_' . basename($_FILES['foto_quest']['name']);
        $file_path = $upload_dir . $file_name;

        if (move_uploaded_file($_FILES['foto_quest']['tmp_name'], $file_path)) {
            // Se houver uma foto antiga, você pode querer excluí-la
            if (!empty($foto_questão) && file_exists($foto_questão)) {
                unlink($foto_questão);
            }
            $foto_questão = $file_path;
        } else {
            die("Erro ao fazer o upload da nova imagem.");
        }
    }

    // Atualizar os dados no banco de dados
    $sql_update = "UPDATE questões SET enunciado = ?, foto_questão = ?, alt_correta = ?, alt_incorreta1 = ?, alt_incorreta2 = ?, alt_incorreta3 = ?, origem = ?, id_nível_ensino = ?, id_escolaridade = ?, id_disciplina = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql_update);
    $stmt->execute([
        $enunciado,
        $foto_questão,
        $alt_correta,
        $alt_errada1,
        $alt_errada2,
        $alt_errada3,
        $origem,
        $id_nível_ensino,
        $id_escolaridade,
        $id_disciplina,
        $id
    ]);

    if ($stmt->rowCount()) {
        echo "<script>alert('Questão atualizada com sucesso!'); window.location.href = 'questoes_em_analise.php';</script>";
    } else {
        echo "<script>alert('Nenhuma alteração foi feita.');</script>";
    }
}

// Consultas para popular os dropdowns
$sql_ensino = "SELECT * FROM níveis_ensino ORDER BY id DESC";
$ensino = $pdo->prepare($sql_ensino);
$ensino->execute();
$niveis_ensino = $ensino->fetchAll(PDO::FETCH_ASSOC);

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
    <title>Editar - Questão</title>
    <link rel="stylesheet" href="../../Include/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <form class="#" action="#" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($questao['id']); ?>">
        <input type="hidden" name="foto_existente" value="<?php echo htmlspecialchars($questao['foto_questão']); ?>">

        <div class="#">
            <label for="enunciado" class="#">ENUNCIADO:</label>
            <textarea class="#" id="enunciado" name="enunciado" rows="4" required><?php echo htmlspecialchars($questao['enunciado']); ?></textarea>
        </div>

        <div class="mb-3">
            <label for="foto_quest" class="#">Imagem da Questão</label>
            <?php if (!empty($questao['foto_questão'])): ?>
                <img src="<?php echo htmlspecialchars($questao['foto_questão']); ?>" alt="Imagem da Questão" style="max-width: 200px;">
                <p>Para manter a imagem, não selecione um novo arquivo.</p>
            <?php endif; ?>
            <input class="#" type="file" id="foto_quest" name="foto_quest" accept="image/*">
        </div>

        <div class="#">
            <label for="alt_correta" class="#">Alternativa Correta</label>
            <input type="text" class="#" id="alt_correta" name="alt_correta" value="<?php echo htmlspecialchars($questao['alt_correta']); ?>" required>
        </div>

        <div class="#">
            <label for="alt_errada1" class="#">Alternativa Errada 1</label>
            <input type="text" class="#" id="alt_errada1" name="alt_errada1" value="<?php echo htmlspecialchars($questao['alt_incorreta1']); ?>" required>

            <label for="alt_errada2" class="#">Alternativa Errada 2</label>
            <input type="text" class="#" id="alt_errada2" name="alt_errada2" value="<?php echo htmlspecialchars($questao['alt_incorreta2']); ?>" required>

            <label for="alt_errada3" class="#">Alternativa Errada 3</label>
            <input type="text" class="#" id="alt_errada3" name="alt_errada3" value="<?php echo htmlspecialchars($questao['alt_incorreta3']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="origem" class="#">Origem</label>
            <input type="text" class="#" id="origem" name="origem" value="<?php echo htmlspecialchars($questao['origem']); ?>" required>
        </div>

        <div class="#">
            <label for="nível_de_ensino" class="#">Nível de ensino:</label>
            <select id="nível_de_ensino" name="nível_de_ensino" class="#" required>
                <option value="">Selecione um nível de ensino</option>
                <?php foreach ($niveis_ensino as $nivel): ?>
                    <option value="<?php echo $nivel['id']; ?>" <?php echo ($nivel['id'] == $questao['id_nível_ensino']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($nivel['nível_ensino']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="#">
            <label for="ano_escolaridade" class="#">Ano de escolaridade:</label>
            <select id="ano_escolaridade" name="ano_escolaridade" class="#" required>
                <option value="">Selecione um ano de escolaridade</option>
                <?php foreach ($escolaridades as $escolaridade_item): ?>
                    <option value="<?php echo $escolaridade_item['id']; ?>" <?php echo ($escolaridade_item['id'] == $questao['id_escolaridade']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($escolaridade_item['nome_escolaridade']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="#">
            <label for="disciplinas" class="#">disciplina:</label>
            <select id="disciplinas" name="disciplinas" class="#" required>
                <option value="">Selecione uma disciplina</option>
                <?php foreach ($disciplinas as $disciplina_item): ?>
                    <option value="<?php echo $disciplina_item['id']; ?>" <?php echo ($disciplina_item['id'] == $questao['id_disciplina']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($disciplina_item['disciplina']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <button name="action" value="editar_questão" type="submit">SALVAR ALTERAÇÕES</button>
        </div>

    </form>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const escolaridadesData = <?php echo json_encode($escolaridades); ?>;
        const disciplinasData = <?php echo json_encode($disciplinas); ?>;

        const nivelEnsinoSelect = document.getElementById('nível_de_ensino');
        const anoEscolaridadeSelect = document.getElementById('ano_escolaridade');
        const disciplinasSelect = document.getElementById('disciplinas');

        function atualizarAnosEscolaridade() {
            const nivelId = parseInt(nivelEnsinoSelect.value, 10);
            anoEscolaridadeSelect.innerHTML = '<option value="">Selecione um ano de escolaridade</option>';
            disciplinasSelect.innerHTML = '<option value="">Selecione uma disciplina</option>';

            if (!isNaN(nivelId)) {
                const escolaridadesFiltradas = escolaridadesData.filter(
                    (escolaridade) => escolaridade.id_nível_ensino === nivelId
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
        
        // Disparar a atualização na carga da página para pré-selecionar os valores
        window.onload = function() {
            atualizarAnosEscolaridade();
            atualizarDisciplinas();
        };

        nivelEnsinoSelect.addEventListener('change', atualizarAnosEscolaridade);
        anoEscolaridadeSelect.addEventListener('change', atualizarDisciplinas);
    </script>
</body>
</html>