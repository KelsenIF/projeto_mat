<?php
// 0. INÍCIO DA SESSÃO E CONEXÃO

// 🚨 CORREÇÃO: Inicia a sessão (Essencial para usar $_SESSION)
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// 1. INCLUSÕES
// Inclui a conexão PDO.
include_once('../../Include/connection.php');

// 2. DEFINIR O ID DO ALUNO A SER EDITADO A PARTIR DA SESSÃO
// 💡 Usamos 'user_id' que você definiu no login.
$aluno_id = $_SESSION['user_id'] ?? null; 


// 3. VERIFICAÇÃO DE ID E SESSÃO
if (!$aluno_id || !is_numeric($aluno_id)) {
    // Redireciona para o login se a sessão for inválida ou o ID não for numérico
    $_SESSION['erro_login'] = "Acesso negado. Sessão expirada ou inválida.";
    header('Location: /User_Registration/login.php'); // Ajuste este caminho se necessário
    exit();
}

// Variáveis de inicialização
$aluno = null;
$instituicoes = [];
$turmas = [];
// Array de Perguntas - USANDO O SEU ARRAY DE STRINGS
$perguntas_seguranca = [
    "Qual o nome do seu primeiro animal de estimação?",
    "Qual o nome da rua onde você nasceu?",
    "Qual o seu livro ou filme favorito de infância?",
    "Qual o nome do meio da sua mãe?",
    "Qual a sua comida favorita?",
];


try {
    // --- CONSULTAS PARA POPULAR OS SELECTS (Opções) ---
    $stmt_instituicoes = $pdo->query("SELECT Código, Nome FROM escolas ORDER BY Nome ASC");
    $instituicoes = $stmt_instituicoes->fetchAll(PDO::FETCH_ASSOC);

    $stmt_turmas = $pdo->query("SELECT id, nome FROM turmas ORDER BY nome ASC");
    $turmas = $stmt_turmas->fetchAll(PDO::FETCH_ASSOC);
    
    // ❌ REMOVEMOS A CONSULTA: $stmt_perguntas = $pdo->query("SELECT id, pergunta FROM perguntas_seguranca ORDER BY id ASC");
    // Usamos o array fixo $perguntas_seguranca definido acima.


    // --- CARREGAMENTO DOS DADOS DO ALUNO A SER EDITADO (Usando o ID da sessão) ---
    $stmt_aluno = $pdo->prepare("SELECT * FROM cadastros WHERE id = :id");
    $stmt_aluno->bindParam(':id', $aluno_id, PDO::PARAM_INT);
    $stmt_aluno->execute();
    $aluno = $stmt_aluno->fetch(PDO::FETCH_ASSOC);

    if (!$aluno) {
        // Redireciona se o ID da sessão não for encontrado no banco (erro crítico)
        $_SESSION['erro_login'] = "Erro: Dados do usuário não encontrados no sistema.";
        header('Location: /User_Registration/login.php'); // Ajuste este caminho se necessário
        exit();
    }
    
} catch (PDOException $e) {
    die("Erro ao carregar dados: " . $e->getMessage());
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar - Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body>
    <nav class="navbar sticky-bottom bg-dark">
        <div class=" container-fluid">
            <a class="navbar-brand text-light" href="#">EDITAR CADASTRO </a>
        </div>
    </nav>

    <div class="container mt-5">
        <form class="row g-3" method="POST" action="edit_registration_process.php" enctype="multipart/form-data">
            
            <input type="hidden" name="aluno_id" value="<?php echo htmlspecialchars($aluno['id']); ?>">
            
            <div class="mb-3">
                <label for="inputArquivoImagem" class="form-label">Atualizar foto de perfil:</label>
                <input class="form-control" type="file" id="inputArquivoImagem" name="imagem_upload" accept="image/*"/>
            </div>
            
            <div class="col-md-6">
                <label for="inputMatricula" class="form-label">Matrícula</label>
                <input type="text" class="form-control" id="inputMatricula" name="matricula" 
                       value="<?php echo htmlspecialchars($aluno['user']); ?>" required>
            </div>
            
            <div class="col-md-6">
                <label for="inputNome" class="form-label">Nome</label>
                <input type="text" class="form-control" id="inputNome" name="nome" 
                       value="<?php echo htmlspecialchars($aluno['nome']); ?>" required>
            </div>

            <div class="col-md-6">
                <label for="inputPerguntaSeguranca" class="form-label">Pergunta de segurança:</label>
                <select id="inputPerguntaSeguranca" name="pergunta_seguranca" class="form-select" required>
                    <option value="">Selecione uma pergunta...</option>
                    <?php 
                    // 🚨 CORREÇÃO: Itera sobre o array de strings
                    // Assumimos que o campo no banco 'pergunta_seguranca' guarda a STRING inteira
                    foreach ($perguntas_seguranca as $pergunta): 
                    ?>
                        <option value="<?php echo htmlspecialchars($pergunta); ?>" 
                            <?php echo ($aluno['pergunta_seguranca'] === $pergunta) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($pergunta); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="col-md-6">
                <label for="inputRespostaSeguranca" class="form-label">Resposta de segurança:</label>
                <input type="text" class="form-control" id="inputRespostaSeguranca" name="resposta_seguranca" 
                       value="" placeholder="Deixe em branco para não alterar">
            </div>
            
            <div class="col-md-6">
                <label for="inputInstituicao" class="form-label">Instituição:</label>
                <select id="inputInstituicao" name="instituicao_codigo" class="form-select" required>
                    <option value="">Selecione a Instituição...</option>
                    <?php foreach ($instituicoes as $instituicao): ?>
                        <option value="<?php echo htmlspecialchars($instituicao['Código']); ?>" 
                            <?php echo ($aluno['instituicao'] == $instituicao['Código']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($instituicao['Nome']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="col-md-6">
                <label for="inputTurma" class="form-label">Turma:</label>
                <select id="inputTurma" name="turma_id" class="form-select" required>
                    <option value="">Selecione a Turma...</option>
                    <?php foreach ($turmas as $turma): ?>
                        <option value="<?php echo htmlspecialchars($turma['id']); ?>" 
                            <?php echo ($aluno['turma'] == $turma['id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($turma['nome']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="col-12 d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Salvar alterações</button>
            </div>
        </form>
    </div>
</body>

</html>