<?php
// 0. INÍCIO DA SESSÃO E CONEXÃO
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// 🚨 ATENÇÃO: Verifique se este caminho está correto para o seu connection.php!
include_once('../../DASHBOARDS/include/connection.php'); 

// 2. DEFINIR O ID DO ALUNO A SER EDITADO A PARTIR DA SESSÃO
$aluno_id = $_SESSION['id_usuario'] ?? null; 

// 3. VERIFICAÇÃO DE ID E SESSÃO (CORREÇÃO APLICADA)
if (!$aluno_id || !is_numeric($aluno_id)) {
    $_SESSION['erro_login'] = "Acesso negado. Sessão expirada ou inválida.";
    // ⚠️ Redireciona APENAS se o ID da sessão não for encontrado
    header('Location: ../LOGIN/login.php'); 
    exit();
}

$aluno = null;
$instituicoes = [];
$turmas = [];
// Lista de perguntas de segurança (mantida no código)
$perguntas_seguranca = [
    "Qual o nome do seu primeiro animal de estimação?",
    "Qual o nome da rua onde você nasceu?",
    "Qual o seu livro ou filme favorito de infância?",
    "Qual o nome do meio da sua mãe?",
    "Qual a sua comida favorita?",
];


try {
    // --- CONSULTAS PARA POPULAR OS SELECTS (Opções) ---
    $stmt_instituicoes = $pdo->query("SELECT cod_inep AS codigo, nome_escola AS nome FROM escolas ORDER BY nome ASC");
    $instituicoes = $stmt_instituicoes->fetchAll(PDO::FETCH_ASSOC);

    $stmt_turmas = $pdo->query("SELECT id, nome_turma AS nome FROM turmas ORDER BY nome ASC");
    $turmas = $stmt_turmas->fetchAll(PDO::FETCH_ASSOC);
    
    // --- CARREGAMENTO DOS DADOS DO ALUNO A SER EDITADO (Ajustado para usar apenas a tabela 'pessoas') ---
    $stmt_aluno = $pdo->prepare("
        SELECT 
            id, 
            email AS matricula, 
            nome,
            nome_escola AS instituicao_codigo, 
            nome_turma AS turma_id,
            foto_perfil
        FROM 
            pessoas
        WHERE 
            id = :id
    ");
    $stmt_aluno->bindParam(':id', $aluno_id, PDO::PARAM_INT);
    $stmt_aluno->execute();
    $aluno = $stmt_aluno->fetch(PDO::FETCH_ASSOC);

    if (!$aluno) {
        $_SESSION['error_message'] = "Erro: Dados do usuário não encontrados no sistema.";
        header('Location: perfil.php'); 
        exit();
    }
    
    // Simula a pergunta de segurança para o formulário
    $aluno['pergunta_seguranca'] = $aluno['pergunta_seguranca'] ?? $perguntas_seguranca[0]; 
    
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
            <a class="navbar-brand text-light" href="perfil.php">EDITAR CADASTRO</a>
        </div>
    </nav>

    <div class="container mt-5">
        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo htmlspecialchars($_SESSION['error_message']); ?>
            </div>
            <?php unset($_SESSION['error_message']); ?>
        <?php endif; ?>

        <form class="row g-3" method="POST" action="editar_perfil_process.php" enctype="multipart/form-data">
            
            <input type="hidden" name="aluno_id" value="<?php echo htmlspecialchars($aluno['id']); ?>">
            
            <div class="mb-3">
                <label for="inputArquivoImagem" class="form-label">Atualizar foto de perfil: 
                    <?php if ($aluno['foto_perfil']): ?>
                        <img src="../../User_Registration/<?php echo htmlspecialchars($aluno['foto_perfil']); ?>" alt="Foto Atual" style="width: 50px; height: 50px; border-radius: 50%;">
                    <?php endif; ?>
                </label>
                <input class="form-control" type="file" id="inputArquivoImagem" name="imagem_upload" accept="image/*"/>
                <small class="form-text text-muted">A foto atual será substituída se um novo arquivo for enviado.</small>
            </div>
            
            <div class="col-md-6">
                <label for="inputMatricula" class="form-label">Matrícula</label>
                <input type="text" class="form-control" id="inputMatricula" name="matricula" 
                       value="<?php echo htmlspecialchars($aluno['matricula']); ?>" required>
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
                    foreach ($perguntas_seguranca as $pergunta): 
                    ?>
                        <option value="<?php echo htmlspecialchars($pergunta); ?>">
                            <?php echo htmlspecialchars($pergunta); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="col-md-6">
                <label for="inputRespostaSeguranca" class="form-label">Resposta de segurança:</label>
                <input type="text" class="form-control" id="inputRespostaSeguranca" name="resposta_seguranca" 
                       value="" placeholder="Preencha apenas se quiser alterar a resposta atual">
            </div>
            
            <div class="col-md-6">
                <label for="inputInstituicao" class="form-label">Instituição:</label>
                <select id="inputInstituicao" name="instituicao_codigo" class="form-select" required>
                    <option value="">Selecione a Instituição...</option>
                    <?php foreach ($instituicoes as $instituicao): ?>
                        <option value="<?php echo htmlspecialchars($instituicao['codigo']); ?>" 
                            <?php echo ($aluno['instituicao_codigo'] == $instituicao['codigo']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($instituicao['nome']); ?>
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
                            <?php echo ($aluno['turma_id'] == $turma['id']) ? 'selected' : ''; ?>>
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
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>