<?php
include_once('../../Dashboards/Include/connection.php');

// Verifies if the 'id' parameter is present in the URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID da questão não fornecido ou inválido.");
}

$id_questao = $_GET['id'];

// ATENÇÃO: Incluindo o novo campo video_aula_link no SELECT
$sql = "SELECT q.*, ae.nome_escolaridade, d.disciplina, ne.nivel_ensino 
        FROM questoes q
        JOIN anos_escolaridades ae ON q.id_escolaridade = ae.id
        JOIN disciplinas d ON q.id_disciplina = d.id
        JOIN niveis_ensino ne ON q.id_nivel_ensino = ne.id
        WHERE q.id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id_questao]);
$questao = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$questao) {
    die("Questão não encontrada.");
}

// Create an array of alternatives, including the correct one
$alternativas = [
    'a' => $questao['alt_correta'],
    'b' => $questao['alt_incorreta1'],
    'c' => $questao['alt_incorreta2'],
    'd' => $questao['alt_incorreta3']
];

// Shuffle the alternatives to randomize their order
$keys = array_keys($alternativas);
shuffle($keys);
$shuffled_alternativas = [];
foreach ($keys as $key) {
    $shuffled_alternativas[$key] = $alternativas[$key];
}

// Store the correct answer key in a JavaScript-accessible variable
$resposta_correta = array_search($questao['alt_correta'], $alternativas);
?>

<?php
require('../../../Projeto_Matemática(2)/Dashboards/Include/access_restriction.php');
?>
<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Visualizar Questão</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../../Include/style.css">
    <link rel="stylesheet" type="text/css" href="../../Dashboards/dashboard.css">
    <style>
        .alternative-item {
            cursor: pointer;
        }
        .correct {
            background-color: #28a745 !important;
            color: white;
        }
        .incorrect {
            background-color: #dc3545 !important;
            color: white;
        }
        .selected {
            border: 2px solid #007bff;
        }
        /* Estilo customizado para abas no card-header com cor */
        .card-header .nav-link {
            color: white; /* Cor do texto das abas */
        }
        .card-header .nav-link.active {
            color: #0d6efd; /* Cor do texto da aba ativa (pode ser ajustada) */
            background-color: white; /* Fundo branco para aba ativa */
            border-bottom-color: white;
        }
        /* Garantir que o conteúdo do link seja visível e clicável */
        .btn-outline-primary {
            word-break: break-all;
            text-align: left;
            white-space: normal;
        }
    </style>
</head>
<body>
<?php
include_once('../../../Projeto_Matemática(2)/Dashboards/Alunos/include/svg.php');
?>
    
    <div class="container-fluid">
        <div class="row">
            <?php
            include('../../../Projeto_Matemática(2)/Dashboards/Alunos/include/sidebar.php')
            ?>
        </div>
    </div>
    
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="pt-3 pb-2 mb-3">
                    </div>

                <div class="card shadow-lg mb-4">
                    <div class="card-header text-bg-primary">
                        <ul class="nav nav-tabs card-header-tabs mt-2" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="question-tab" data-bs-toggle="tab" data-bs-target="#question" type="button" role="tab" aria-controls="question" aria-selected="true">Questão</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="materials-tab" data-bs-toggle="tab" data-bs-target="#materials" type="button" role="tab" aria-controls="materials" aria-selected="false">Detalhes da Questão</button>
                            </li>
                            
                            <li class="nav-item d-none" role="presentation" id="video-tab-nav">
                                <button class="nav-link" id="video-link-tab" data-bs-toggle="tab" data-bs-target="#video-tab-pane" type="button" role="tab" aria-controls="video-tab-pane" aria-selected="false">Resolução</button>
                            </li>
                            
                            <li class="nav-item d-none" role="presentation" id="pdf-tab-nav">
                                <button class="nav-link" id="material-link-tab" data-bs-toggle="tab" data-bs-target="#material-tab-pane" type="button" role="tab" aria-controls="material-tab-pane" aria-selected="false">PDF</button>
                            </li>
                        </ul>
                    </div>
                    
                    <div class="card-body">
                        <div class="tab-content pt-2" id="myTabContent">
                            <div class="tab-pane fade show active" id="question" role="tabpanel" aria-labelledby="question-tab">
                                <p class="card-text"><?php echo nl2br(htmlspecialchars($questao['enunciado'])); ?></p>
                                
                                <?php if (!empty($questao['foto_questao'])): ?>
                                    <div class="mb-3">
                                        <h6>Imagem da Questão:</h6>
                                        <img src="<?php echo htmlspecialchars($questao['foto_questao']); ?>" class="img-fluid rounded shadow-sm" alt="Imagem da Questão">
                                    </div>
                                <?php endif; ?>

                                <hr>
                                <h6>Escolha uma alternativa e clique em confirmar:</h6>
                                <ul class="list-group">
                                    <?php foreach ($shuffled_alternativas as $key => $alt): ?>
                                        <li class="list-group-item alternative-item" data-answer="<?php echo $key; ?>">
                                            <?php echo htmlspecialchars($alt); ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>

                                <div class="mt-4 d-flex justify-content-between">
                                    <button id="confirmBtn" class="btn btn-primary" disabled>Confirmar</button>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="materials" role="tabpanel" aria-labelledby="materials-tab">
                                
                                <div class="mb-4 p-3 border rounded">
                                    <h6>Vídeo Aula de Conteúdo:</h6>
                                    <?php if (!empty($questao['video_aula_link'])): ?>
                                        <p>Assista o vídeo de conteúdo antes de responder:</p>
                                        <div class="d-grid">
                                            <a href="<?php echo htmlspecialchars($questao['video_aula_link']); ?>" target="_blank" class="text-decoration-none btn btn-outline-success btn-block">
                                                <i class="fas fa-video me-2"></i> Acessar Vídeo Aula
                                            </a>
                                        </div>
                                    <?php else: ?>
                                        <p class="text-muted mb-0">Não há vídeo aula de conteúdo cadastrada para esta questão.</p>
                                    <?php endif; ?>
                                </div>
                                <hr>
                                
                                <p><strong>Origem:</strong> <?php echo htmlspecialchars($questao['origem']); ?></p>
                                <p><strong>Nível de Ensino:</strong> <?php echo htmlspecialchars($questao['nivel_ensino']); ?></p>
                                <p><strong>Ano Escolar:</strong> <?php echo htmlspecialchars($questao['nome_escolaridade']); ?></p>
                                <p><strong>Assunto:</strong> <?php echo htmlspecialchars($questao['disciplina']); ?></p>

                                <?php if (!empty($questao['video_questao']) || !empty($questao['material_questao'])): ?>
                                    <div class="alert alert-info mt-3" role="alert">
                                        O **Vídeo de Resolução** e o **Material de Apoio (PDF)** serão liberados nas abas **Resolução** e **PDF** após a confirmação da sua resposta.
                                    </div>
                                <?php endif; ?>

                                <div class="mt-4">
                                    <a href="javascript:history.back()" class="btn btn-secondary">Voltar</a>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="video-tab-pane" role="tabpanel" aria-labelledby="video-link-tab">
                                <div class="mb-3">
                                    <h6>Vídeo de Resolução da Questão:</h6>
                                    <?php if (!empty($questao['video_questao'])): ?>
                                        <p>Clique no botão abaixo para acessar o vídeo que explica a solução:</p>
                                        <div class="d-grid">
                                            <a href="<?php echo htmlspecialchars($questao['video_questao']); ?>" target="_blank" class="text-decoration-none btn btn-outline-primary btn-block">
                                                <i class="fas fa-play-circle me-2"></i> <?php echo htmlspecialchars($questao['video_questao']); ?>
                                            </a>
                                        </div>
                                    <?php else: ?>
                                        <div class="alert alert-warning" role="alert">
                                            Link do Vídeo de Resolução não disponível para esta questão.
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="material-tab-pane" role="tabpanel" aria-labelledby="material-link-tab">
                                <div class="mb-3">
                                    <h6>Material de Apoio (PDF, Docs, etc.):</h6>
                                    <?php if (!empty($questao['material_questao'])): ?>
                                        <p>Clique no botão abaixo para acessar o material de apoio:</p>
                                        <?php 
                                            // Assume que o material_questao agora é o caminho de um arquivo (upload)
                                            $material_link = htmlspecialchars($questao['material_questao']);
                                            $file_name = basename($questao['material_questao']);
                                        ?>
                                        <div class="d-grid">
                                            <a href="<?php echo $material_link; ?>" target="_blank" class="text-decoration-none btn btn-outline-primary btn-block">
                                                <i class="fas fa-file-pdf me-2"></i> Baixar Arquivo: <?php echo $file_name; ?>
                                            </a>
                                        </div>
                                    <?php else: ?>
                                        <div class="alert alert-warning" role="alert">
                                            Material de Apoio (PDF/Outros) não disponível para esta questão.
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </main>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            const correctAnswer = '<?php echo $resposta_correta; ?>';
            let selectedAnswer = null;

            // Handle the click event on the alternatives
            $('.alternative-item').on('click', function() {
                // Remove the 'selected' class from all alternatives
                $('.alternative-item').removeClass('selected');
                
                // Add the 'selected' class to the clicked alternative
                $(this).addClass('selected');
                
                // Store the selected answer and enable the button
                selectedAnswer = $(this).data('answer');
                $('#confirmBtn').prop('disabled', false);
            });

            // Handle the click event on the "Confirm" button
            $('#confirmBtn').on('click', function() {
                // DESABILITA O BOTÃO E AS ALTERNATIVAS
                $('#confirmBtn').prop('disabled', true);
                $('.alternative-item').off('click');
                
                // MOSTRA CORREÇÃO
                $('.alternative-item').each(function() {
                    const currentAnswer = $(this).data('answer');
                    
                    if (currentAnswer === correctAnswer) {
                        $(this).addClass('correct');
                    } else if (currentAnswer === selectedAnswer) {
                        $(this).addClass('incorrect');
                    }
                });

                // NOVO: Exibir as novas abas (Resolução e PDF) após a confirmação
                // Remove a classe 'd-none' para mostrar as abas
                $('#video-tab-nav').removeClass('d-none');
                $('#pdf-tab-nav').removeClass('d-none');
            });
        });
    </script>
</body>
</html>