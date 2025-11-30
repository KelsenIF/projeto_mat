<?php
include_once('../../DASHBOARDS/include/connection.php');

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
    $enunciado = $_POST['enunciado']; // O valor virá do campo hidden agora
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

    // Lógica para upload e remoção de arquivos existentes
    // Ajuste o caminho de upload para a estrutura correta.
    // Presumindo que o upload é para '.../uploads/' do root do projeto.
    $upload_dir = __DIR__ . '/uploads/'; 
    
    // --- Lógica para Imagem ---
    if (isset($_FILES['foto_quest']) && $_FILES['foto_quest']['error'] === UPLOAD_ERR_OK) {
        $foto_upload_dir = __DIR__ . '/uploads/foto_questao/';
        if (!is_dir($foto_upload_dir)) {
            mkdir($foto_upload_dir, 0777, true);
        }
        
        $file_name = uniqid('img_') . '_' . basename($_FILES['foto_quest']['name']);
        $file_path = $foto_upload_dir . $file_name;

        if (move_uploaded_file($_FILES['foto_quest']['tmp_name'], $file_path)) {
            // Remove a foto antiga se existir
            if (!empty($foto_questao) && file_exists(__DIR__ . '/' . $foto_questao)) {
                // ATENÇÃO: Verifique o caminho real de remoção
                // O caminho no banco é 'uploads/foto_questao/nome_do_arquivo', mas o arquivo pode estar
                // em uma pasta acima de onde 'editar_questao.php' está.
                // Aqui estamos assumindo que o caminho é relativo à pasta onde 'editar_questao.php' está.
                // Se sua estrutura de pastas é:
                // projeto_matematica/
                //   - questoes/
                //     - editar_questao.php
                //     - uploads/
                //        - foto_questao/
                // A linha abaixo está correta:
                unlink(__DIR__ . '/' . $foto_questao);
            }
            // Caminho relativo para o banco de dados (ajustado para a nova estrutura de pastas)
            $foto_questao = 'uploads/foto_questao/' . $file_name;
        } else {
            die("Erro ao fazer o upload da nova imagem da questão.");
        }
    }
    
    // --- Lógica para Material ---
    if (isset($_FILES['material_file']) && $_FILES['material_file']['error'] === UPLOAD_ERR_OK) {
        $material_upload_dir = __DIR__ . '/uploads/material_questao/';
        if (!is_dir($material_upload_dir)) {
            mkdir($material_upload_dir, 0777, true);
        }
        
        $file_name = uniqid('material_') . '_' . basename($_FILES['material_file']['name']);
        $file_path = $material_upload_dir . $file_name;

        if (move_uploaded_file($_FILES['material_file']['tmp_name'], $file_path)) {
            // Remove o material antigo se existir
            if (!empty($material_questao) && file_exists(__DIR__ . '/' . $material_questao)) {
                 // ATENÇÃO: Verifique o caminho real de remoção
                 unlink(__DIR__ . '/' . $material_questao);
            }
            // Caminho relativo para o banco de dados (ajustado para a nova estrutura de pastas)
            $material_questao = 'uploads/material_questao/' . $file_name; 
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
        // Redireciona para onde o usuário esperava após a edição
        echo "<script>alert('Questão atualizada com sucesso!'); window.location.href = 'questoes_em_analise.php';</script>";
    } else {
        echo "<script>alert('Nenhuma alteração foi feita.');window.location.href = 'questoes_em_analise.php';</script></script>";
    }
}

// Busca todos os dados para preencher os dropdowns
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

// Variáveis para pré-seleção dos dropdowns
$selectedNivelEnsinoId = $questao['id_nivel_ensino'] ?? null;
$selectedEscolaridadeId = $questao['id_escolaridade'] ?? null;
$selectedDisciplinaId = $questao['id_disciplina'] ?? null;
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

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/katex@0.16.4/dist/katex.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/katex@0.16.4/dist/katex.min.js"></script>
    
    <style>
        /* -------------------------------------------------------------------
         * ESTILOS GERAIS PARA O TEMA NEON
         * ------------------------------------------------------------------- */
        :root {
            --bg-dark: #1a1a2e; /* Fundo principal muito escuro, quase preto-azulado */
            --neon-color: #00ffff; /* Cor ciano/azul neon principal */
            --neon-color-alt: #ff00ff; /* Cor magenta/rosa neon alternativa */
            --shadow-intensity: 0 0 10px;
            --transition-speed: 0.3s;
        }

        body {
            background-color: var(--bg-dark);
            color: #f0f0f0; /* Texto principal em cinza claro */
            font-family: 'Consolas', 'Courier New', monospace; /* Fonte com aparência tecnológica */
            margin: 0;
            padding: 0;
        }

        /* Estilo para cards/containers principais */
        .card {
            background-color: #1f1f3a; /* Fundo do card ligeiramente mais claro que o body */
            border: 1px solid var(--neon-color);
            box-shadow: 0 0 20px rgba(0, 255, 255, 0.3); /* Brilho sutil no card */
        }

        /* Títulos e textos de destaque */
        h1, h2, h3, h5, .card-header {
            color: var(--neon-color);
            text-shadow: var(--shadow-intensity) var(--neon-color);
            border-bottom: 2px solid var(--neon-color);
            padding-bottom: 5px;
            margin-bottom: 20px;
            letter-spacing: 1.5px;
        }
        
        /* -------------------------------------------------------------------
         * ESTILO DE BOTÕES
         * ------------------------------------------------------------------- */
        .btn {
            --btn-color: var(--neon-color);
            background: transparent;
            color: var(--btn-color);
            border: 2px solid var(--btn-color);
            padding: 10px 20px;
            margin: 5px;
            border-radius: 5px;
            text-transform: uppercase;
            font-weight: bold;
            cursor: pointer;
            box-shadow: var(--shadow-intensity) var(--btn-color);
            transition: background var(--transition-speed), box-shadow var(--transition-speed), color var(--transition-speed);
        }

        .btn:hover:not(:disabled) {
            background: var(--btn-color);
            color: var(--bg-dark); /* Texto escuro no hover */
            box-shadow: 0 0 20px var(--btn-color), 0 0 40px var(--btn-color);
        }

        /* Botão de edição (btn-primary) */
        .btn-primary { 
            --btn-color: var(--neon-color-alt); /* Usando a cor alternativa para destaque */
            color: var(--btn-color);
            border-color: var(--btn-color);
            box-shadow: var(--shadow-intensity) var(--btn-color);
        }
        .btn-primary:hover:not(:disabled) {
            background: var(--btn-color);
            color: var(--bg-dark);
            box-shadow: 0 0 20px var(--btn-color), 0 0 40px var(--btn-color);
        }

        /* Botão de remoção de foto/material */
        .btn-danger {
            --btn-color: #ff3c3c;
            color: var(--btn-color);
            border-color: var(--btn-color);
            box-shadow: 0 0 5px rgba(255, 60, 60, 0.5);
        }
        .btn-danger:hover {
            background: var(--btn-color);
            color: var(--bg-dark);
            box-shadow: 0 0 20px var(--btn-color), 0 0 40px var(--btn-color);
        }

        /* -------------------------------------------------------------------
         * ESTILO DE INPUTS E TEXTAREAS
         * ------------------------------------------------------------------- */
        .form-control, textarea, .form-select {
            background-color: #1a1a2e;
            border: 1px solid var(--neon-color);
            color: var(--neon-color);
            padding: 10px;
            border-radius: 5px;
            box-shadow: var(--shadow-intensity) rgba(0, 255, 255, 0.3);
            transition: border-color var(--transition-speed), box-shadow var(--transition-speed);
        }

        .form-control:focus, textarea:focus, .form-select:focus {
            outline: none;
            border-color: var(--neon-color-alt);
            box-shadow: 0 0 15px var(--neon-color-alt);
            background-color: #1a1a2e;
            color: var(--neon-color);
        }

        /* Cor do texto nos selects abertos no Chrome */
        .form-select option {
            background: #1f1f3a;
            color: #f0f0f0;
        }
        
        /* Estilo para labels e texto secundário */
        label, small, .alert-info {
            color: var(--neon-color);
            font-weight: bold;
            text-shadow: 0 0 5px rgba(0, 255, 255, 0.5);
            background-color: transparent !important;
            border: none !important;
        }

        /* -------------------------------------------------------------------
         * ESTILO PARA O ENUNCIADO E PREVIEW (KaTeX Editor)
         * ------------------------------------------------------------------- */
        .editor, #renderedEquation {
            background-color: #1f1f3a !important; /* Fundo escuro para o editor/preview */
            border: 2px dashed var(--neon-color);
            padding: 20px !important;
            border-radius: 10px !important;
            box-shadow: var(--shadow-intensity) var(--neon-color);
            min-height: 100px;
            color: #f0f0f0; /* Texto claro */
            white-space: pre-wrap;
            word-wrap: break-word;
        }

        /* Estilo para a barra de ferramentas do KaTeX */
        .toolbar {
            background-color: #1f1f3a !important;
            border: 1px solid var(--neon-color) !important;
            border-radius: 8px !important;
            display: flex;
            flex-wrap: wrap;
            padding: 8px;
            margin-bottom: 15px;
            gap: 12px;
        }

        .toolbar-section {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            padding: 4px 10px;
            border-right: 1px solid #4a4a6b !important;
        }
        .toolbar-section:last-child {
            border-right: none !important;
        }

        .section-title {
            font-size: 13px;
            font-weight: bold;
            margin-bottom: 6px;
            color: var(--neon-color) !important;
            text-shadow: 0 0 5px rgba(0, 255, 255, 0.5);
        }

        .toolbar-section button {
            background-color: #2b2b40 !important;
            border: 1px solid var(--neon-color) !important;
            color: var(--neon-color) !important;
            padding: 4px 8px;
            font-size: 14px;
            border-radius: 4px;
            margin-bottom: 4px;
            cursor: pointer;
            min-width: 40px;
            transition: all 0.2s ease;
            box-shadow: 0 0 5px rgba(0, 255, 255, 0.3);
        }

        .toolbar-section button:hover {
            background-color: var(--neon-color) !important;
            color: var(--bg-dark) !important;
            box-shadow: 0 0 10px var(--neon-color);
        }
        
    </style>
    </head>
<body>
    <div class="container mt-5">
        <div class="card shadow-lg p-4">
            <h1 class="text-center mb-4">Editar Questão #<?php echo htmlspecialchars($questao['id']); ?></h1>
            <hr>
            <form class="needs-validation" action="#" method="POST" enctype="multipart/form-data" novalidate onsubmit="return validateAndSubmit(event)">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($questao['id']); ?>">
                <input type="hidden" name="foto_existente" value="<?php echo htmlspecialchars($questao['foto_questao'] ?? ''); ?>">
                <input type="hidden" name="material_existente" value="<?php echo htmlspecialchars($questao['material_questao'] ?? ''); ?>">
                <input type="hidden" name="action" value="editar_questao">

                <div class="mb-3">
                    <label for="equationInput" class="form-label">ENUNCIADO:</label>
                    
                    <div class="toolbar">
                        <div class="toolbar-section">
                            <div class="section-title">Operações</div>
                            <button type="button" onclick="insertKatex('+', '+')">+</button>
                            <button type="button" onclick="insertKatex('-', '-')">−</button>
                            <button type="button" onclick="insertKatex('=', '=')">=</button>
                            <button type="button" onclick="insertKatex('\\cdot', '\\cdot')">·</button>
                            <button type="button" onclick="insertKatex('\\times', '\\times')">×</button>
                            <button type="button" onclick="insertKatex('\\div', '\\div')">÷</button>
                            <button type="button" onclick="insertKatex('\\dfrac{a}{b}', 'a')">Fração</button>
                        </div>
                
                        <div class="toolbar-section">
                            <div class="section-title">Funções</div>
                            <button type="button" onclick="insertKatex('\\sqrt{}', '')">Raiz</button>
                            <button type="button" onclick="insertKatex('^{}', '')">Expoente</button>
                            <button type="button" onclick="insertKatex('\\log_{}{}', 'a')">log</button>
                            <button type="button" onclick="insertKatex('\\sin', '\\sin')">sin</button>
                            <button type="button" onclick="insertKatex('\\cos', '\\cos')">cos</button>
                            <button type="button" onclick="insertKatex('\\tan', '\\tan')">tan</button>
                        </div>
                
                        <div class="toolbar-section">
                            <div class="section-title">Conjuntos</div>
                            <button type="button" onclick="insertKatex('\\mathbb{N}', '\\mathbb{N}')">ℕ</button>
                            <button type="button" onclick="insertKatex('\\mathbb{Z}', '\\mathbb{Z}')">ℤ</button>
                            <button type="button" onclick="insertKatex('\\mathbb{Q}', '\\mathbb{Q}')">ℚ</button>
                            <button type="button" onclick="insertKatex('\\mathbb{R}', '\\mathbb{R}')">ℝ</button>
                            <button type="button" onclick="insertKatex('\\mathbb{C}', '\\mathbb{C}')">ℂ</button>
                        </div>
                
                        <div class="toolbar-section">
                            <div class="section-title">Símbolos</div>
                            <button type="button" onclick="insertKatex('\\pi', '\\pi')">π</button>
                            <button type="button" onclick="insertKatex('\\in', '\\in')">∈</button>
                            <button type="button" onclick="insertKatex('\\notin', '\\notin')">∉</button>
                            <button type="button" onclick="insertKatex('\\subset', '\\subset')">⊂</button>
                            <button type="button" onclick="insertKatex('\\subseteq', '\\subseteq')">⊆</button>
                            <button type="button" onclick="insertKatex('\\cup', '\\cup')">∪</button>
                            <button type="button" onclick="insertKatex('\\cap', '\\cap')">∩</button>
                            <button type="button" onclick="insertKatex('\\\\', '\\\\')">Quebra de linha</button>
                        </div>
                
                        <div class="toolbar-section">
                            <div class="section-title">Matrizes</div>
                            <button type="button" onclick="insertKatex('\\begin{bmatrix} a & b \\\\ c & d \\end{bmatrix}', 'a')">2×2</button>
                            <button type="button" onclick="insertKatex('\\begin{pmatrix} a & b & c \\\\ d & e & f \\end{pmatrix}', 'a')">2×3</button>
                        </div>
                        
                        <div class="toolbar-section">
                            <div class="section-title">Sistemas</div>
                            <button type="button" onclick="insertKatex('\\begin{cases} x + y = 2 \\\\ 2x - y = 3 \\end{cases}', 'x + y = 2')">Sistema</button>
                        </div>

                        <div class="toolbar-section">
                            <div class="section-title">Visualizar</div>
                            <button type="button" onclick="renderEquation()">Renderizar</button>
                        </div>
                    </div>

                    <div contenteditable="true" id="equationInput" class="editor" data-placeholder="Escreva, neste campo, o enunciado..."><?php echo htmlspecialchars($questao['enunciado'] ?? ''); ?></div>
                    <input type="hidden" name="enunciado" id="enunciado">
                    <div class="invalid-feedback">
                        Por favor, insira o enunciado da questão.
                    </div>
                </div>

                <div id="renderedEquation" class="alert alert-secondary mt-3" style="min-height: 50px;">
                    Pré-visualização do Enunciado
                </div>

                <hr>
                
                <h5 class="mb-3">Mídia e Arquivos de Apoio</h5>

                <div class="mb-3">
                    <label for="foto_quest" class="form-label">Imagem da questão (opcional)</label>
                    <?php if (!empty($questao['foto_questao'])): ?>
                        <?php $foto_path = htmlspecialchars($questao['foto_questao']); $file_name = basename($foto_path); ?>
                        <div class="alert alert-info py-2 my-2"> Imagem atual: <a href="<?php echo $foto_path; ?>" target="_blank" class="text-white"><?php echo $file_name; ?></a> </div>
                    <?php endif; ?>
                    <input class="form-control" type="file" id="foto_quest" name="foto_quest" accept="image/*">
                </div>
                
                <div class="mb-3">
                    <label for="video_aula_link" class="form-label">Link da Vídeo Aula (Conteúdo)</label>
                    <input type="url" class="form-control" id="video_aula_link" name="video_aula_link" value="<?php echo htmlspecialchars($questao['video_aula_link'] ?? ''); ?>" placeholder="Ex: https://www.youtube.com/watch?v=...">
                </div>
                
                <div class="mb-3">
                    <label for="video_questao" class="form-label">Link do Vídeo de Resolução da Questão</label>
                    <input type="url" class="form-control" id="video_questao" name="video_questao" value="<?php echo htmlspecialchars($questao['video_questao'] ?? ''); ?>" placeholder="Ex: https://www.youtube.com/watch?v=...">
                </div>
                
                <div class="mb-3">
                    <label for="material_file" class="form-label">Material de Apoio (PDF, Docs, etc.)</label>
                    <?php if (!empty($questao['material_questao'])): ?>
                        <?php $material_path = htmlspecialchars($questao['material_questao']); $file_name = basename($material_path); ?>
                        <div class="alert alert-info py-2 my-2"> Material atual: <a href="<?php echo $material_path; ?>" target="_blank" class="text-white"><?php echo $file_name; ?></a>. Selecione um novo arquivo abaixo para substituir. </div>
                    <?php endif; ?>
                    <input class="form-control" type="file" id="material_file" name="material_file" accept=".pdf,.doc,.docx,.txt">
                    <small class="form-text text-muted">O arquivo será salvo no servidor e o caminho no campo `material_questao`.</small>
                </div>
                
                <hr class="mt-4 mb-4">
                
                <h5 class="mb-3">Alternativas</h5>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="alt_correta" class="form-label">Alternativa Correta</label>
                        <input type="text" class="form-control" id="alt_correta" name="alt_correta" value="<?php echo htmlspecialchars($questao['alt_correta'] ?? ''); ?>" required>
                        <div class="invalid-feedback"> Campo obrigatório. </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="alt_errada1" class="form-label">Alternativa Incorreta 1</label>
                        <input type="text" class="form-control" id="alt_errada1" name="alt_errada1" value="<?php echo htmlspecialchars($questao['alt_incorreta1'] ?? ''); ?>" required>
                        <div class="invalid-feedback"> Campo obrigatório. </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="alt_errada2" class="form-label">Alternativa Incorreta 2</label>
                        <input type="text" class="form-control" id="alt_errada2" name="alt_errada2" value="<?php echo htmlspecialchars($questao['alt_incorreta2'] ?? ''); ?>" required>
                        <div class="invalid-feedback"> Campo obrigatório. </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="alt_errada3" class="form-label">Alternativa Incorreta 3</label>
                        <input type="text" class="form-control" id="alt_errada3" name="alt_errada3" value="<?php echo htmlspecialchars($questao['alt_incorreta3'] ?? ''); ?>" required>
                        <div class="invalid-feedback"> Campo obrigatório. </div>
                    </div>
                </div>

                <hr>
                
                <h5 class="mb-3">Classificação</h5>

                <div class="mb-3">
                    <label for="origem" class="form-label">Origem</label>
                    <input type="text" class="form-control" id="origem" name="origem" value="<?php echo htmlspecialchars($questao['origem'] ?? ''); ?>">
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="nivel_de_ensino" class="form-label">Nível de Ensino:</label>
                        <select id="nivel_de_ensino" name="nivel_de_ensino" class="form-select" required>
                            <option value="">Selecione um nível</option>
                            <?php foreach ($niveis_ensino as $ensinoW) { ?>
                            <option value="<?php echo htmlspecialchars($ensinoW['id']); ?>" <?php echo ($selectedNivelEnsinoId == $ensinoW['id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($ensinoW['nivel_ensino']); ?></option>
                            <?php } ?>
                        </select>
                        <div class="invalid-feedback"> Selecione um nível de ensino. </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="ano_escolaridade" class="form-label">Ano de Escolaridade:</label>
                        <select id="ano_escolaridade" name="ano_escolaridade" class="form-select" required>
                            <option value="">Selecione um ano</option>
                            </select>
                        <div class="invalid-feedback"> Selecione um ano de escolaridade. </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="disciplinas" class="form-label">Disciplina:</label>
                        <select id="disciplinas" name="disciplinas" class="form-select" required>
                            <option value="">Selecione uma disciplina</option>
                            </select>
                        <div class="invalid-feedback"> Selecione uma disciplina. </div>
                    </div>
                </div>
                
                <div class="d-grid mt-4">
                    <button name="action" value="editar_questao" type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-edit"></i> ATUALIZAR
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        // Lógica de validação do Bootstrap
        (() => {
            'use strict'
            const forms = document.querySelectorAll('.needs-validation')
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    // A validação principal é feita no validateAndSubmit, este bloco só adiciona a classe.
                    if (!form.checkValidity()) {
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
        })()

        // 🔑 INTEGRAÇÃO KATEX: Funções de KaTeX e Submissão
        // Estas funções gerenciam a inserção de comandos KaTeX no editor (div contenteditable)
        function insertKatex(codeToInsert, cursorPlaceholder) {
            const editor = document.getElementById("equationInput");
            editor.focus();

            const selection = window.getSelection();
            if (!selection.rangeCount) {
                document.execCommand('insertText', false, codeToInsert);
                return;
            }

            const range = selection.getRangeAt(0);
            document.execCommand('insertText', false, codeToInsert);

            if (cursorPlaceholder && codeToInsert.includes(cursorPlaceholder)) {
                const placeholderIndex = codeToInsert.indexOf(cursorPlaceholder);
                const currentText = editor.innerText;
                const offset = currentText.length - (codeToInsert.length - placeholderIndex);

                let charCount = 0;
                let foundStart = false;
                const newRange = document.createRange();
                newRange.setStart(editor, 0); 
                newRange.collapse(true);

                function traverseNodes(node) {
                    if (node.nodeType === 3) { // TEXT_NODE
                        if (charCount + node.length >= offset && !foundStart) {
                            newRange.setStart(node, offset - charCount);
                            newRange.collapse(true);
                            foundStart = true;
                        }
                        charCount += node.length;
                    } else if (node.nodeType === 1) { // ELEMENT_NODE
                        for (let i = 0; i < node.childNodes.length; i++) {
                            if (foundStart) break;
                            traverseNodes(node.childNodes[i]);
                        }
                    }
                }

                traverseNodes(editor);
                
                if (foundStart) {
                    selection.removeAllRanges();
                    selection.addRange(newRange);
                }
            }
            renderEquation();
        }

        // Renderiza o conteúdo do editor KaTeX para a área de pré-visualização
        function renderEquation() {
            const input = document.getElementById("equationInput").innerText;
            const output = document.getElementById("renderedEquation");
            
            // Tratamento: remove quebras de linha/espaços excessivos e substitui por KaTeX-compatible
            let content = input.trim();
            content = content.replace(/\n/g, '\\\\').replace(/ {2,}/g, '\\;');

            if (content === "") {
                output.innerHTML = "Pré-visualização do Enunciado";
                return;
            }

            try {
                katex.render(content, output, {
                    throwOnError: false,
                    displayMode: true
                });
            } catch (err) {
                // Em caso de erro, exibe o código bruto
                output.innerHTML = "<span style='color: #ff3c3c;'>Erro ao renderizar (código KaTeX inválido). Exibindo código bruto:</span><br>" + content;
                console.error(err);
            }
        }

        // Validação final e preparação do dado para submissão
        function validateAndSubmit(event) {
            const editor = document.getElementById("equationInput");
            const hiddenEnunciado = document.getElementById("enunciado");
            const form = event.target;

            // 1. Validar se o editor está vazio
            const editorText = editor.innerText.trim();
            if (editorText === "") {
                editor.style.borderColor = 'red';
                event.preventDefault();
                event.stopPropagation();
                return false;
            } else {
                editor.style.borderColor = ''; // Volta à cor padrão
            }

            // 2. Copiar o conteúdo do editor para o campo hidden
            // Remove quebras de linha/espaços excessivos, pois o banco deve armazenar uma string limpa.
            hiddenEnunciado.value = editorText.replace(/\n/g, ' ').replace(/ {2,}/g, ' '); 

            // 3. Continuar com a validação do Bootstrap
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
                return false;
            }
            return true;
        }

        // 🔑 Lógica de dependência dos dropdowns
        const escolaridadesData = <?php echo json_encode($escolaridades); ?>;
        const disciplinasData = <?php echo json_encode($disciplinas); ?>;
        const nivelEnsinoSelect = document.getElementById('nivel_de_ensino');
        const anoEscolaridadeSelect = document.getElementById('ano_escolaridade');
        const disciplinasSelect = document.getElementById('disciplinas');

        // Valores pré-selecionados do PHP
        const selectedEscolaridadeId = '<?php echo $selectedEscolaridadeId; ?>';
        const selectedDisciplinaId = '<?php echo $selectedDisciplinaId; ?>';

        function atualizarAnosEscolaridade(initialLoad = false) {
            const nivelId = parseInt(nivelEnsinoSelect.value, 10);
            
            // Se não for o carregamento inicial, limpa o ano de escolaridade
            if (!initialLoad) {
                anoEscolaridadeSelect.innerHTML = '<option value="">Selecione um ano</option>';
            }

            if (!isNaN(nivelId)) {
                const escolaridadesFiltradas = escolaridadesData.filter(
                    (escolaridade) => escolaridade.id_nivel_ensino == nivelId
                );
                escolaridadesFiltradas.forEach((escolaridade) => {
                    const option = document.createElement('option');
                    option.value = escolaridade.id;
                    option.textContent = escolaridade.nome_escolaridade;
                    // Mantém a opção selecionada na primeira carga
                    if (initialLoad && escolaridade.id == selectedEscolaridadeId) {
                        option.selected = true;
                    }
                    anoEscolaridadeSelect.appendChild(option);
                });
            }
            
            // Se for a carga inicial e o ID de escolaridade estiver preenchido, atualiza as disciplinas
            if (initialLoad && selectedEscolaridadeId) {
                atualizarDisciplinas(true);
            } else if (!initialLoad) {
                 // Se mudou o nível de ensino, limpa as disciplinas (caso não tenha sido limpo no listener)
                 disciplinasSelect.innerHTML = '<option value="">Selecione uma disciplina</option>';
            }
        }

        function atualizarDisciplinas(initialLoad = false) {
            const escolaridadeId = parseInt(anoEscolaridadeSelect.value, 10);
            
            // Se não for o carregamento inicial, limpa a seleção
            if (!initialLoad) {
                disciplinasSelect.innerHTML = '<option value="">Selecione uma disciplina</option>';
            }

            if (!isNaN(escolaridadeId)) {
                const disciplinasFiltradas = disciplinasData.filter(
                    (disciplina) => disciplina.id_escolaridade == escolaridadeId
                );
                disciplinasFiltradas.forEach((disciplina) => {
                    const option = document.createElement('option');
                    option.value = disciplina.id;
                    option.textContent = disciplina.disciplina;
                    // Mantém a opção selecionada na primeira carga
                    if (initialLoad && disciplina.id == selectedDisciplinaId) {
                        option.selected = true;
                    }
                    disciplinasSelect.appendChild(option);
                });
            }
        }
        
        window.onload = function() {
            // Garante que o KaTeX está pronto antes de tentar renderizar
            if (typeof katex !== 'undefined') {
                renderEquation();
            } else {
                // Se o KaTeX ainda não carregou, tenta novamente após um pequeno atraso
                setTimeout(renderEquation, 500);
            }
            
            // Carrega os dropdowns na inicialização, usando o 'true' para pré-selecionar os valores do PHP
            atualizarAnosEscolaridade(true);
        };

        nivelEnsinoSelect.addEventListener('change', () => {
             // Ao mudar o Nível de Ensino, recarrega Anos e limpa Disciplinas
             atualizarAnosEscolaridade();
        });
        
        anoEscolaridadeSelect.addEventListener('change', atualizarDisciplinas);
    </script>
</body>
</html>