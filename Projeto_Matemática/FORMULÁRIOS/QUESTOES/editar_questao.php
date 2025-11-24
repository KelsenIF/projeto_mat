<?php
include_once('../../DASHBOARDS/INCLUDE/SISTEMA_BE/connection.php');

$questao = null;
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql_questao = "SELECT * FROM questoes WHERE id = ?";
    $stmt_questao = $pdo->prepare($sql_questao);
    $stmt_questao->execute([$id]);
    $questao = $stmt_questao->fetch(PDO::FETCH_ASSOC);

    if (!$questao) {
        die("Questão não encontrada.");
    }
} else {
    die("ID da questão não fornecido.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'editar_questao') {
    $id = $_POST['id'];
    $enunciado = $_POST['enunciado'];
    $alt_correta = $_POST['alt_correta'];
    $alt_errada1 = $_POST['alt_errada1'];
    $alt_errada2 = $_POST['alt_errada2'];
    $alt_errada3 = $_POST['alt_errada3'];
    $origem = $_POST['origem'];
    $id_nivel_ensino = $_POST['nivel_de_ensino'];
    $id_escolaridade = $_POST['ano_escolaridade'];
    $id_disciplina = $_POST['disciplinas'];
    $foto_questao = $_POST['foto_existente'];

    $video_aula_link = !empty($_POST['video_aula_link']) ? $_POST['video_aula_link'] : null;
    $video_questao = !empty($_POST['video_questao']) ? $_POST['video_questao'] : null;
    $material_questao = $_POST['material_existente'];

    $upload_dir = __DIR__ . '/../../uploads/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    if (isset($_FILES['foto_quest']) && $_FILES['foto_quest']['error'] === UPLOAD_ERR_OK) {
        $file_name = uniqid('quest_') . '_' . basename($_FILES['foto_quest']['name']);
        $file_path = $upload_dir . $file_name;

        if (move_uploaded_file($_FILES['foto_quest']['tmp_name'], $file_path)) {
            if (!empty($foto_questao) && strpos($foto_questao, '../../uploads/') === 0) {
                $old_file_name = basename($foto_questao);
                $old_file_path = $upload_dir . $old_file_name;
                if (file_exists($old_file_path)) {
                    unlink($old_file_path);
                }
            }
            $foto_questao = '../../uploads/' . $file_name;
        } else {
            die("Erro ao fazer o upload da nova imagem da questão.");
        }
    }
    
    if (isset($_FILES['material_file']) && $_FILES['material_file']['error'] === UPLOAD_ERR_OK) {
        $file_name = uniqid('material_') . '_' . basename($_FILES['material_file']['name']);
        $file_path = $upload_dir . $file_name;

        if (move_uploaded_file($_FILES['material_file']['tmp_name'], $file_path)) {
            if (!empty($material_questao) && strpos($material_questao, '../../uploads/') === 0) {
                 $old_file_name = basename($material_questao);
                 $old_file_path = $upload_dir . $old_file_name;
                 if (file_exists($old_file_path)) {
                     unlink($old_file_path);
                 }
            }
            $material_questao = '../../uploads/' . $file_name; 
        } else {
            die("Erro ao fazer o upload do novo material de apoio.");
        }
    }
    
    
    $sql_update = "UPDATE questoes SET enunciado = ?, foto_questao = ?, video_aula_link = ?, video_questao = ?, material_questao = ?, alt_correta = ?, alt_incorreta1 = ?, alt_incorreta2 = ?, alt_incorreta3 = ?, origem = ?, id_nivel_ensino = ?, id_escolaridade = ?, id_disciplina = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql_update);
    $stmt->execute([
        $enunciado,
        $foto_questao,
        $video_aula_link,    
        $video_questao,      
        $material_questao,   
        $alt_correta,
        $alt_errada1,
        $alt_errada2,
        $alt_errada3,
        $origem,
        $id_nivel_ensino,
        $id_escolaridade,
        $id_disciplina,
        $id
    ]);

    if ($stmt->rowCount()) {
        echo "<script>alert('Questão atualizada com sucesso!'); window.location.href = 'questoes_em_analise.php';</script>";
    } else {
        echo "<script>alert('Nenhuma alteração foi feita.');window.location.href = '../../../projeto_matematica/dashboards/index.php';</script></script>";
    }
}

$sql_ensino = "SELECT * FROM niveis_ensino ORDER BY id DESC";
$ensino = $pdo->prepare($sql_ensino);
$ensino->execute();
$niveis_ensino = $ensino->fetchAll(PDO::FETCH_ASSOC);

$sql_escolaridade = "SELECT id, nome_escolaridade, id_nivel_ensino FROM anos_escolaridades ORDER BY id DESC";
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
    <title>Editar - Questão</title>
    <link rel="stylesheet" href="../../Include/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2kXJd5bSg9k35JpI5fI0dG3v9T3P5p4dC3b5sF55E+J3V9O9T3V5b5v5" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <div class="container mt-5">
        <div class="card shadow-lg p-4">
            <h1 class="text-center mb-4">Editar Questão</h1>
            <hr>
            <form class="needs-validation" action="#" method="POST" enctype="multipart/form-data" novalidate>
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($questao['id']); ?>">
                <input type="hidden" name="foto_existente" value="<?php echo htmlspecialchars($questao['foto_questao'] ?? ''); ?>">
                <input type="hidden" name="material_existente" value="<?php echo htmlspecialchars($questao['material_questao'] ?? ''); ?>">
                <input type="hidden" name="action" value="editar_questao">

                <div class="mb-3">
                    <label for="enunciado" class="form-label">ENUNCIADO:</label>
                    <textarea class="form-control" id="enunciado" name="enunciado" rows="4" required><?php echo htmlspecialchars($questao['enunciado']); ?></textarea>
                    <div class="invalid-feedback">
                        Por favor, insira o enunciado da questão.
                    </div>
                </div>

                <div class="mb-3">
                    <label for="foto_quest" class="form-label">Imagem da questão</label>
                    <?php if (!empty($questao['foto_questao'])): ?>
                        <div class="mb-2">
                            <img src="<?php echo htmlspecialchars($questao['foto_questao']); ?>" alt="Imagem da questao" class="img-fluid rounded" style="max-height: 200px;">
                            <p class="mt-2 text-muted"><small>Imagem atual. Para manter, não selecione um novo arquivo.</small></p>
                        </div>
                    <?php endif; ?>
                    <input class="form-control" type="file" id="foto_quest" name="foto_quest" accept="image/*">
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="alt_correta" class="form-label">Alternativa Correta</label>
                        <input type="text" class="form-control" id="alt_correta" name="alt_correta" value="<?php echo htmlspecialchars($questao['alt_correta']); ?>" required>
                        <div class="invalid-feedback">
                            Campo obrigatório.
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="alt_errada1" class="form-label">Alternativa Errada 1</label>
                        <input type="text" class="form-control" id="alt_errada1" name="alt_errada1" value="<?php echo htmlspecialchars($questao['alt_incorreta1']); ?>" required>
                        <div class="invalid-feedback">
                            Campo obrigatório.
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="alt_errada2" class="form-label">Alternativa Errada 2</label>
                        <input type="text" class="form-control" id="alt_errada2" name="alt_errada2" value="<?php echo htmlspecialchars($questao['alt_incorreta2']); ?>" required>
                        <div class="invalid-feedback">
                            Campo obrigatório.
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="alt_errada3" class="form-label">Alternativa Errada 3</label>
                        <input type="text" class="form-control" id="alt_errada3" name="alt_errada3" value="<?php echo htmlspecialchars($questao['alt_incorreta3']); ?>" required>
                        <div class="invalid-feedback">
                            Campo obrigatório.
                        </div>
                    </div>
                </div>

                <hr class="mt-4 mb-4">
                <h5 class="mb-3">Links e Arquivos de Mídia</h5>
                
                <div class="mb-3">
                    <label for="video_aula_link" class="form-label">Link da Vídeo Aula (Conteúdo)</label>
                    <input type="url" class="form-control" id="video_aula_link" name="video_aula_link" value="<?php echo htmlspecialchars($questao['video_aula_link'] ?? ''); ?>" placeholder="Ex: https://www.youtube.com/watch?v=...">
                    <small class="form-text text-muted">Este link será salvo no campo `video_aula_link`.</small>
                </div>
                
                <div class="mb-3">
                    <label for="video_questao" class="form-label">Link do Vídeo de Resolução da Questão</label>
                    <input type="url" class="form-control" id="video_questao" name="video_questao" value="<?php echo htmlspecialchars($questao['video_questao'] ?? ''); ?>" placeholder="Ex: https://www.youtube.com/watch?v=...">
                    <small class="form-text text-muted">Este link será salvo no campo `video_questao`.</small>
                </div>

                <div class="mb-3">
                    <label for="material_file" class="form-label">Upload do Material de Apoio (PDF, Docs, etc.)</label>
                    <?php if (!empty($questao['material_questao'])): ?>
                        <?php 
                            $material_path = htmlspecialchars($questao['material_questao']);
                            $file_name = basename($material_path);
                        ?>
                        <div class="alert alert-info py-2 my-2">
                            Material atual: <a href="<?php echo $material_path; ?>" target="_blank"><?php echo $file_name; ?></a>. Selecione um novo arquivo abaixo para substituir.
                        </div>
                    <?php endif; ?>
                    <input class="form-control" type="file" id="material_file" name="material_file" accept=".pdf,.doc,.docx,.txt">
                    <small class="form-text text-muted">O arquivo será salvo no servidor e o caminho no campo `material_questao`.</small>
                </div>

                <hr class="mt-4 mb-4">

                <div class="mb-3">
                    <label for="origem" class="form-label">Origem</label>
                    <input type="text" class="form-control" id="origem" name="origem" value="<?php echo htmlspecialchars($questao['origem']); ?>" required>
                    <div class="invalid-feedback">
                        Por favor, insira a origem da questão.
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="nivel_de_ensino" class="form-label">Nível de Ensino:</label>
                        <select id="nivel_de_ensino" name="nivel_de_ensino" class="form-select" required>
                            <option value="">Selecione um nível</option>
                            <?php foreach ($niveis_ensino as $nivel): ?>
                                <option value="<?php echo htmlspecialchars($nivel['id']); ?>" <?php echo ($nivel['id'] == $questao['id_nivel_ensino']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($nivel['nivel_ensino']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback">
                            Selecione um nível de ensino.
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="ano_escolaridade" class="form-label">Ano de Escolaridade:</label>
                        <select id="ano_escolaridade" name="ano_escolaridade" class="form-select" required>
                            <option value="">Selecione um ano</option>
                            <?php foreach ($escolaridades as $escolaridade_item): ?>
                                <option value="<?php echo htmlspecialchars($escolaridade_item['id']); ?>" <?php echo ($escolaridade_item['id'] == $questao['id_escolaridade']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($escolaridade_item['nome_escolaridade']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback">
                            Selecione um ano de escolaridade.
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="disciplinas" class="form-label">Disciplina:</label>
                        <select id="disciplinas" name="disciplinas" class="form-select" required>
                            <option value="">Selecione uma disciplina</option>
                            <?php foreach ($disciplinas as $disciplina_item): ?>
                                <option value="<?php echo htmlspecialchars($disciplina_item['id']); ?>" <?php echo ($disciplina_item['id'] == $questao['id_disciplina']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($disciplina_item['disciplina']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback">
                            Selecione uma disciplina.
                        </div>
                    </div>
                </div>

                <div class="d-grid mt-4" href="../../DASHBOARDS/ALUNOS/index.php" >
                    <button name="action" value="editar_questao" type="submit"class="btn btn-primary btn-lg">
                        <i class="fas fa-save"></i> SALVAR ALTERAÇÕES
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
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
            const selectedEscolaridadeId = <?php echo $questao['id_escolaridade']; ?>;

            anoEscolaridadeSelect.innerHTML = '<option value="">Selecione um ano</option>';

            if (!isNaN(nivelId)) {
                const escolaridadesFiltradas = escolaridadesData.filter(
                    (escolaridade) => escolaridade.id_nivel_ensino == nivelId
                );
                escolaridadesFiltradas.forEach((escolaridade) => {
                    const option = document.createElement('option');
                    option.value = escolaridade.id;
                    option.textContent = escolaridade.nome_escolaridade;
                    if (escolaridade.id == selectedEscolaridadeId) {
                        option.selected = true;
                    }
                    anoEscolaridadeSelect.appendChild(option);
                });
            }
        }

        function atualizarDisciplinas() {
            const escolaridadeId = parseInt(anoEscolaridadeSelect.value, 10);
            const selectedDisciplinaId = <?php echo $questao['id_disciplina']; ?>;
            disciplinasSelect.innerHTML = '<option value="">Selecione uma disciplina</option>';

            if (!isNaN(escolaridadeId)) {
                const disciplinasFiltradas = disciplinasData.filter(
                    (disciplina) => disciplina.id_escolaridade == escolaridadeId
                );
                disciplinasFiltradas.forEach((disciplina) => {
                    const option = document.createElement('option');
                    option.value = disciplina.id;
                    option.textContent = disciplina.disciplina;
                    if (disciplina.id == selectedDisciplinaId) {
                        option.selected = true;
                    }
                    disciplinasSelect.appendChild(option);
                });
            }
        }
        
        window.onload = function() {
            atualizarAnosEscolaridade();
            atualizarDisciplinas();
        };

        nivelEnsinoSelect.addEventListener('change', () => {
             atualizarAnosEscolaridade();
             disciplinasSelect.innerHTML = '<option value="">Selecione uma disciplina</option>';
        });
        anoEscolaridadeSelect.addEventListener('change', atualizarDisciplinas);
    </script>
</body>
</html>