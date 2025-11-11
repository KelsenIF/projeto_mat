<?php
// Inicia a sessão se ainda não estiver iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Inclui o arquivo de conexão
require_once '..\Include\connection.php'; // **VERIFIQUE O CAMINHO**

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../User_Registration/login.php"); 
    exit;
}

// ID do usuário logado (usando o id do cadastro)
$user_id = $_SESSION['user_id'];

// Busca os dados do usuário e informações relacionadas
try {
    // Busca dados da tabela cadastros (c), escolas (e) e acessos (a)
    $sql = "
        SELECT 
            c.nome, 
            c.user, 
            c.foto,
            c.turma,
            c.instituicao,
            c.pergunta_seguranca,
            e.Nome AS nome_escola,
            e.Município AS municipio_escola,
            a.nome AS tipo_acesso
        FROM 
            cadastros c
        LEFT JOIN 
            escolas e ON c.instituicao = e.Código
        LEFT JOIN 
            acessos a ON c.tipo_user = a.id
        WHERE 
            c.id = :id_usuario
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_usuario', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$usuario) {
        throw new Exception("Usuário não encontrado.");
    }

} catch (PDOException $e) {
    error_log("Erro ao buscar dados do perfil: " . $e->getMessage());
    $error_message = "Não foi possível carregar as informações do perfil.";
    $usuario = null;
} catch (Exception $e) {
    $error_message = $e->getMessage();
    $usuario = null;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu Perfil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .profile-img-container {
            width: 150px;
            height: 150px;
            overflow: hidden;
            border-radius: 50%;
            margin: 0 auto 20px auto;
            border: 4px solid #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .profile-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>
</head>

<body>
    
    <div class="container-fluid">
        <div class="row">

            <?php
            // Inclua a barra lateral
            include 'Include/sidebar.php'; // **VERIFIQUE O CAMINHO**
            include 'Include/svg.php'; // **VERIFIQUE O CAMINHO**
            ?>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Meu Perfil</h1>
                </div>

                <?php if (isset($error_message)): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo htmlspecialchars($error_message); ?>
                    </div>
                <?php endif; ?>

                <?php if ($usuario): ?>
                    <div class="row">
                        <div class="col-md-4 text-center">
                            <div class="profile-img-container">
                                <img src="/Projeto_Matemática(2)/User_Registration/<?php echo htmlspecialchars($usuario['foto']); ?>" 
                                     alt="Foto de Perfil" 
                                     class="profile-img">
                            </div>
                            <h3 class="mb-3"><?php echo htmlspecialchars($usuario['nome']); ?></h3>
                            <p class="text-muted"><?php echo htmlspecialchars($usuario['tipo_acesso'] ?? 'Tipo de Acesso não definido'); ?></p>
                            <a href="../../Dashboards/Include/Settings/edit_registration.php" class="btn btn-primary">
                                Editar Perfil
                            </a>
                        </div>
                        <div class="col-md-8">
                            <h4 class="mb-3">Detalhes da Conta</h4>
                            <ul class="list-group mb-4">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Nome Completo:
                                    <span><?php echo htmlspecialchars($usuario['nome']); ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Identificação de Usuário (Matrícula/Login):
                                    <span><?php echo htmlspecialchars($usuario['user']); ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Nível de Acesso:
                                    <span><?php echo htmlspecialchars($usuario['tipo_acesso'] ?? 'Não informado'); ?></span>
                                </li>
                            </ul>

                            <h4 class="mb-3">Informações Institucionais</h4>
                            <ul class="list-group">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Instituição (Escola):
                                    <span><?php echo htmlspecialchars($usuario['nome_escola'] ?? 'Não informado'); ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Código da Instituição:
                                    <span><?php echo htmlspecialchars($usuario['instituicao']); ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Município:
                                    <span><?php echo htmlspecialchars($usuario['municipio_escola'] ?? 'Não informado'); ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Turma:
                                    <span><?php echo htmlspecialchars($usuario['turma']); ?></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                <?php endif; ?>

            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>