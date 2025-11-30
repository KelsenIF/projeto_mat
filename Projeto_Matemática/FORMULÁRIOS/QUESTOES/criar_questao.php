<?php
include_once('../../DASHBOARDS/include/connection.php');


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'criar_questao') {

    $enunciado = $_POST['enunciado']; // O valor virá do campo hidden agora
    $alt_correta = $_POST['alt_correta'];
    $alt_errada1 = $_POST['alt_errada1'];
    $alt_errada2 = $_POST['alt_errada2'];
    $alt_errada3 = $_POST['alt_errada3'];
    $origem = $_POST['origem'];
    $id_nivel_ensino = $_POST['nivel_de_ensino'];
    $id_escolaridade = $_POST['ano_escolaridade'];
    $id_disciplina = $_POST['disciplinas'];
    $foto_questao = '';
    $material_questao = null;
    $id_situacao = 2;

    $video_aula_link = !empty($_POST['video_aula_link']) ? $_POST['video_aula_link'] : null;
    $video_questao = !empty($_POST['video_questao']) ? $_POST['video_questao'] : null;

    // 🔑 CORREÇÃO 1: Definição dos Diretórios Físicos
    // __DIR__ garante que o path comece na pasta onde este script está.
    $base_dir = __DIR__ . '/uploads/';
    $foto_upload_dir = $base_dir . 'foto_questao/';
    $material_upload_dir = $base_dir . 'material_questao/';

    // 🔑 CORREÇÃO 2: Criação de Diretórios (incluindo subpastas)
    if (!is_dir($foto_upload_dir)) {
        mkdir($foto_upload_dir, 0777, true);
    }
    if (!is_dir($material_upload_dir)) {
        mkdir($material_upload_dir, 0777, true);
    }

    // ---------------------------------------------------
    // UPLOAD DA FOTO
    // ---------------------------------------------------
    if (isset($_FILES['foto_quest']) && $_FILES['foto_quest']['error'] === UPLOAD_ERR_OK) {
        $file_name = uniqid('img_') . '_' . basename($_FILES['foto_quest']['name']);
        // 🔑 CORREÇÃO 3: Uso do caminho da subpasta correta
        $file_path = $foto_upload_dir . $file_name;

        if (move_uploaded_file($_FILES['foto_quest']['tmp_name'], $file_path)) {
            // 🔑 CORREÇÃO 4: Caminho web relativo para salvar no banco de dados
            $foto_questao = 'uploads/foto_questao/' . $file_name;
        } else {
            die("Erro ao fazer o upload da imagem da questão.");
        }
    }

    // ---------------------------------------------------
    // UPLOAD DO MATERIAL
    // ---------------------------------------------------
    if (isset($_FILES['material_file']) && $_FILES['material_file']['error'] === UPLOAD_ERR_OK) {
        $file_name = uniqid('material_') . '_' . basename($_FILES['material_file']['name']);
        // 🔑 CORREÇÃO 5: Uso do caminho da subpasta correta
        $file_path = $material_upload_dir . $file_name;

        if (move_uploaded_file($_FILES['material_file']['tmp_name'], $file_path)) {
            // 🔑 CORREÇÃO 6: Caminho web relativo para salvar no banco de dados
            $material_questao = 'uploads/material_questao/' . $file_name;
        } else {
            die("Erro ao fazer o upload do material de apoio.");
        }
    }

    $sql_insert = "INSERT INTO questoes (enunciado, foto_questao, video_aula_link, video_questao, material_questao, alt_correta, alt_incorreta1, alt_incorreta2, alt_incorreta3, origem, id_nivel_ensino, id_escolaridade, id_disciplina, id_situacao) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $pdo->prepare($sql_insert);
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
        $id_situacao
    ]);

    if ($stmt->rowCount()) {
        echo "<script>alert('Questão criada com sucesso e enviada para análise!'); window.location.href = '../../DASHBOARDS/ALUNOS/index.php';</script>";
    } else {
        echo "<script>alert('Erro ao criar a questão.');</script>";
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
    <title>Criar - Questão</title>
    <link rel="stylesheet" href="../../Include/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2kXJd5bSg9k35JpI5fI0dG3v9T3P5p4dC3b5sF55E+J3V9O9T3P5p4dC3b5sF55E+J3V9O9T3V5b5v5"
        crossorigin="anonymous" referrerpolicy="no-referrer" />
        
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

        /* Botão de criação (btn-primary) */
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
        label, small {
            color: var(--neon-color);
            font-weight: bold;
            text-shadow: 0 0 5px rgba(0, 255, 255, 0.5);
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
            <h1 class="text-center mb-4">Criar Questão</h1>
            <hr>
            <form class="needs-validation" action="#" method="POST" enctype="multipart/form-data" novalidate onsubmit="return validateAndSubmit(event)">
                <input type="hidden" name="action" value="criar_questao">

                <div class="mb-3">
                    <label for="equationInput" class="form-label">Enunciado:</label>
                    
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
                    
                    <div contenteditable="true" id="equationInput" class="editor" data-placeholder="Escreva, neste campo, o enunciado..." required></div>
                    <input type="hidden" name="enunciado" id="enunciado">
                    <div class="invalid-feedback">
                        Por favor, insira o enunciado da questão.
                    </div>
                </div>

                <div id="renderedEquation" class="alert alert-secondary mt-3">
                    Pré-visualização do Enunciado
                </div>
                
                <hr>
                
                <h5 class="mb-3">Mídia e Arquivos de Apoio</h5>
                
                <div class="mb-3">
                    <label for="foto_quest" class="form-label">Imagem da questão (opcional)</label>
                    <input class="form-control" type="file" id="foto_quest" name="foto_quest" accept="image/*">
                </div>
                
                <div class="mb-3">
                    <label for="video_aula_link" class="form-label">Link da Vídeo Aula (Conteúdo)</label>
                    <input type="url" class="form-control" id="video_aula_link" name="video_aula_link" placeholder="Ex: https://www.youtube.com/watch?v=...">
                </div>
                
                <div class="mb-3">
                    <label for="video_questao" class="form-label">Link do Vídeo de Resolução da Questão</label>
                    <input type="url" class="form-control" id="video_questao" name="video_questao" placeholder="Ex: https://www.youtube.com/watch?v=...">
                </div>
                
                <div class="mb-3">
                    <label for="material_file" class="form-label">Material de Apoio (PDF, Docs, etc.)</label>
                    <input class="form-control" type="file" id="material_file" name="material_file" accept=".pdf,.doc,.docx,.txt">
                </div>
                
                <hr>

                <h5 class="mb-3">Alternativas</h5>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="alt_correta" class="form-label">Alternativa Correta</label>
                        <input type="text" class="form-control" id="alt_correta" name="alt_correta" required>
                        <div class="invalid-feedback">
                            Campo obrigatório.
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="alt_errada1" class="form-label">Alternativa Incorreta 1</label>
                        <input type="text" class="form-control" id="alt_errada1" name="alt_errada1" required>
                        <div class="invalid-feedback">
                            Campo obrigatório.
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="alt_errada2" class="form-label">Alternativa Incorreta 2</label>
                        <input type="text" class="form-control" id="alt_errada2" name="alt_errada2" required>
                        <div class="invalid-feedback">
                            Campo obrigatório.
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="alt_errada3" class="form-label">Alternativa Incorreta 3</label>
                        <input type="text" class="form-control" id="alt_errada3" name="alt_errada3" required>
                        <div class="invalid-feedback">
                            Campo obrigatório.
                        </div>
                    </div>
                </div>
                
                <hr>

                <h5 class="mb-3">Classificação</h5>

                <div class="mb-3">
                    <label for="origem" class="form-label">Origem</label>
                    <input type="text" class="form-control" id="origem" name="origem">
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="nivel_de_ensino" class="form-label">Nível de Ensino:</label>
                        <select id="nivel_de_ensino" name="nivel_de_ensino" class="form-select" required>
                            <option value="">Selecione um nível</option>
                            <?php foreach ($niveis_ensino as $ensinoW) { ?>
                            <option value="<?php echo htmlspecialchars($ensinoW['id']); ?>">
                                <?php echo htmlspecialchars($ensinoW['nivel_ensino']); ?></option>
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
        function insertKatex(codeToInsert, cursorPlaceholder) {
            const editor = document.getElementById("equationInput");
            editor.focus();

            const selection = window.getSelection();
            if (!selection.rangeCount) {
                document.execCommand('insertText', false, codeToInsert);
                return;
            }

            const range = selection.getRangeAt(0);

            // Tenta inserir o código KaTeX (que é texto para o div contenteditable)
            document.execCommand('insertText', false, codeToInsert);

            // Lógica para posicionar o cursor, se houver um placeholder
            if (cursorPlaceholder && codeToInsert.includes(cursorPlaceholder)) {
                // Calcula a posição de onde o cursor deve parar
                const placeholderIndex = codeToInsert.indexOf(cursorPlaceholder);
                
                // O texto que foi inserido é 'codeToInsert', mas como o document.execCommand
                // não nos dá o Range, precisamos calcular a posição no editor.innerText
                // A posição do cursor (em caracteres a partir do início do div) é:
                // (Comprimento total do texto do editor APÓS a inserção) - (Comprimento do texto após o placeholder)
                const currentText = editor.innerText;
                const offset = currentText.length - (codeToInsert.length - placeholderIndex);

                let charCount = 0;
                let foundStart = false;
                const newRange = document.createRange();
                newRange.setStart(editor, 0); // Começa no início do editor
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
                
                // Se encontramos a posição, definimos a seleção
                if (foundStart) {
                    selection.removeAllRanges();
                    selection.addRange(newRange);
                }
            }
            renderEquation();
        }

        function renderEquation() {
            const input = document.getElementById("equationInput").innerText;
            const output = document.getElementById("renderedEquation");
            
            // Tratamento: remove quebras de linha/espaços excessivos e substitui por KaTeX-compatible
            // Substitui quebras de linha por \\ (quebra de linha no KaTeX) e múltiplos espaços por \: ou similar
            let content = input.trim();
            content = content.replace(/\n/g, '\\\\').replace(/ {2,}/g, '\\;');

            if (content === "") {
                output.innerHTML = "Pré-visualização do Enunciado";
                return;
            }

            try {
                // Tenta renderizar como displayMode para melhor visualização em bloco
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
                editor.style.borderColor = ''; // Volta à cor padrão (controlada pelo CSS Neon)
            }

            // 2. Copiar o conteúdo do editor para o campo hidden
            // Note: O KaTeX no PHP vai renderizar o que está no banco, não precisa de \\
            hiddenEnunciado.value = editorText.replace(/\n/g, ' ').replace(/ {2,}/g, ' '); 

            // 3. Continuar com a validação do Bootstrap
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
                return false;
            }
            return true;
        }


        // Lógica de dependência dos dropdowns
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
                    const optionValue = disciplina.id;
                    option.value = optionValue;
                    option.textContent = disciplina.disciplina;
                    disciplinasSelect.appendChild(option);
                });
            }
        }

        nivelEnsinoSelect.addEventListener('change', atualizarAnosEscolaridade);
        anoEscolaridadeSelect.addEventListener('change', atualizarDisciplinas);
        
        // Renderiza a pré-visualização ao carregar a página (se houver texto)
        window.onload = function() {
            // Garante que o KaTeX está pronto antes de tentar renderizar
            if (typeof katex !== 'undefined') {
                renderEquation();
            } else {
                // Se o KaTeX ainda não carregou, tenta novamente após um pequeno atraso
                setTimeout(renderEquation, 500);
            }
        };
    </script>
</body>

</html>