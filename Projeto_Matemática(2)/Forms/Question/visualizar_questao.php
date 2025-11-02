<?php
include_once('../../Dashboards/Include/connection.php');

// Verifies if the 'id' parameter is present in the URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID da questão não fornecido ou inválido.");
}

$id_questao = $_GET['id'];

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
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <?php
            // Including the sidebar for consistent navigation
            include_once('../../Dashboards/include/sidebar.php');
            include_once('../../Dashboards/include/svg.php');
            ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Visualizar Questão</h1>
                </div>

                
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="question-tab" data-bs-toggle="tab" data-bs-target="#question" type="button" role="tab" aria-controls="question" aria-selected="true">Questão</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="materials-tab" data-bs-toggle="tab" data-bs-target="#materials" type="button" role="tab" aria-controls="materials" aria-selected="false">Detalhes da Questão</button>
                            </li>
                        </ul>
                        <div class="tab-content pt-4" id="myTabContent">
                            <div class="tab-pane fade show active" id="question" role="tabpanel" aria-labelledby="question-tab">
                                <h5 class="card-title">Enunciado:</h5>
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
                                <?php if (!empty($questao['video_questao'])): ?>
                                    <div class="mb-3">
                                        <h6>Vídeo da Questão:</h6>
                                        <a href="<?php echo htmlspecialchars($questao['video_questao']); ?>" target="_blank" class="text-decoration-none"><?php echo htmlspecialchars($questao['video_questao']); ?></a>
                                    </div>
                                <?php endif; ?>

                                <?php if (!empty($questao['material_questao'])): ?>
                                    <div class="mb-3">
                                        <h6>Material de Apoio:</h6>
                                        <a href="<?php echo htmlspecialchars($questao['material_questao']); ?>" target="_blank" class="text-decoration-none"><?php echo htmlspecialchars($questao['material_questao']); ?></a>
                                    </div>
                                <?php endif; ?>

                                <hr>
                                <p><strong>Origem:</strong> <?php echo htmlspecialchars($questao['origem']); ?></p>
                                <p><strong>Nível de Ensino:</strong> <?php echo htmlspecialchars($questao['nivel_ensino']); ?></p>
                                <p><strong>Ano Escolar:</strong> <?php echo htmlspecialchars($questao['nome_escolaridade']); ?></p>
                                <p><strong>Assunto:</strong> <?php echo htmlspecialchars($questao['disciplina']); ?></p>

                                <div class="mt-4">
                                    <a href="javascript:history.back()" class="btn btn-secondary">Voltar</a>
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
                // Disable the button and the alternatives after confirmation
                $('#confirmBtn').prop('disabled', true);
                $('.alternative-item').off('click');
                
                // Iterate through all alternatives to apply the colors
                $('.alternative-item').each(function() {
                    const currentAnswer = $(this).data('answer');
                    
                    if (currentAnswer === correctAnswer) {
                        // Correct answer turns green
                        $(this).addClass('correct');
                    } else if (currentAnswer === selectedAnswer) {
                        // The user's selected (incorrect) answer turns red
                        $(this).addClass('incorrect');
                    }
                });
            });
        });
    </script>
</body>
</html>