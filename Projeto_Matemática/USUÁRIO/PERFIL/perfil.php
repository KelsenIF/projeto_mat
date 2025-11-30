<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once('../../DASHBOARDS/include/connection.php');


if (!isset($_SESSION['id_usuario'])) {
    // Adiciona redirecionamento caso o ID não esteja na sessão
    header("Location: ../../USUARIO/LOGIN/login.php?erro=sessao_invalida");
    exit;
}


$log_id = $_SESSION['id_usuario'];

try {
    // A consulta SQL que puxa o nome da escola e o nome da turma foi mantida
    $sql = "
        SELECT 
            p.nome, 
            p.email, 
            p.foto_perfil, 
            p.cpf,
            e.nome_escola AS nome_instituicao,       /* Puxa o nome da escola */
            t.nome_turma AS nome_turma_completo,     /* Puxa o nome da turma */
            p.senha, 
            p.nivel_de_acesso, 
            
            e.cod_inep AS codigo_instituicao,   
            e.cidade AS municipio_escola,      
            l.id AS id_acesso,
            l.cargo                      
        FROM 
            pessoas p
        LEFT JOIN 
            escolas e ON p.nome_escola = e.cod_inep
        LEFT JOIN 
            turmas t ON p.nome_turma = t.id         
        LEFT JOIN 
            logs l ON p.nivel_de_acesso = l.id
        WHERE 
            p.id = :id_usuario
    ";

    if (!isset($pdo) || !$pdo) {
        throw new Exception("Erro de conexão com o banco de dados.");
    }

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_usuario', $log_id, PDO::PARAM_INT);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$usuario) {
        throw new Exception("Usuário não encontrado.");
    }
    
    // ====================================================================
    // LÓGICA PARA EXIBIR A FOTO DE PERFIL (CORRIGIDA)
    // ====================================================================
    $foto_perfil_db = $usuario['foto_perfil'] ?? '';
    
    // O caminho relativo para sair da pasta atual (ex: USUARIO/PERFIL/) e chegar na raiz do projeto.
    $caminho_base_relativo = '../../'; 
    
    // 1. Define o caminho padrão como fallback
    $caminho_foto_exibicao = $caminho_base_relativo . 'assets/default.png'; 

    // 2. Se houver um caminho no DB, verifica se o arquivo existe
    if (!empty($foto_perfil_db)) {
        // Caminho físico (para a função file_exists)
        // __DIR__ é a pasta atual (USUARIO/PERFIL)
        $caminho_fisico = __DIR__ . '/../../' . $foto_perfil_db; 
        
        // Caminho para o navegador (URL)
        $caminho_url = $caminho_base_relativo . $foto_perfil_db;
        
        // Verifica se o arquivo existe no disco ANTES de tentar carregá-lo
        if (file_exists($caminho_fisico)) {
            $caminho_foto_exibicao = $caminho_url;
        } 
        // Se não existir, a variável $caminho_foto_exibicao mantém o caminho padrão.
    }
    // ====================================================================
    // FIM DA LÓGICA DA FOTO
    // ====================================================================


} catch (Exception $e) {
    // Em produção, você pode querer logar o erro em vez de exibi-lo
    // die("Erro: " . $e->getMessage()); 
    $error_message = "Erro ao carregar dados do perfil: " . $e->getMessage();
}

$titulo_pagina = "Meu Perfil";
$body_class = "neon-theme";
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu Perfil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="../../DASHBOARDS/ALUNOS/dashboard.css" rel="stylesheet" />
    

   <style>
        /* Variáveis de Cores (Unificadas com visualizar_questao.php) */
        :root {
            --dark-bg: #141421; /* Fundo principal escuro */
            --item-bg: #1a1a2e; /* Fundo dos cards/itens */
            --text-color: #e0e0e0;
            --neon-blue: #00e0ff;
            --bg-black: #000000;
            --neon-magenta: #ff00ff;
            
            /* Cores Neon Mapeadas para Cards (Mantidas para consistência) */
            --neon-success: #00ff73; /* Verde Neon */
            --neon-danger: #ff4d4d;  /* Vermelho Neon */
            --neon-warning: #ffb700; /* Amarelo/Laranja Neon */
        }

        body {
            background-color: var(--dark-bg);
            color: var(--text-color);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* 🔑 Estilo do Sidebar/Layout (Importado de visualizar_questao.php) */
        .sidebar .bi {
            width: 1rem;
            height: 1rem;
            vertical-align: -0.125em;
            pointer-events: none;
            fill: currentColor;
        }

        /* Aplica o estilo de fundo e borda à main para corresponder ao layout */
        main.col-md-9 {
            background-color: var(--dark-bg) !important;
            border-left: 1px solid rgba(255, 255, 255, 0.1);
            min-height: 100vh;
            padding-top: 20px !important;
        }
        
        /* Estilos do Título Principal (Importado de visualizar_questao.php) */
        .h2, h1 {
            color: var(--neon-blue);
            text-shadow: 0 0 5px rgba(0, 224, 255, 0.6);
            font-weight: 700;
            margin-top: 2rem;
            border-bottom: 2px solid var(--neon-blue);
            letter-spacing: 1.5px; 
        }

        /* Estilização do Card/Box de Informações */
        .card {
            background-color: var(--item-bg) !important;
            border: 2px solid transparent !important; 
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.4);
            transition: all 0.3s ease-out;
            border-color: rgba(0, 224, 255, 0.4) !important; /* Borda sutil neon */
        }
        
        .card:hover {
             box-shadow: 0 0 15px var(--neon-blue), 0 0 25px rgba(0, 224, 255, 0.6);
        }
        
        /* Estilos para lista de informações (list-group) */
        .list-group-item {
            background-color: var(--item-bg) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            color: var(--text-color) !important;
            padding-left: 1.5rem; /* Ajuste o padding interno */
            padding-right: 1.5rem;
        }

        /* Destaca as etiquetas (labels) */
        .list-group-item span:first-child {
            color: var(--neon-blue);
            font-weight: 600;
        }

        /* Destaca os valores do lado direito */
        .list-group-item span:last-child {
            color: var(--text-color);
            font-weight: 400;
        }
        
        /* Botões */
        .btn {
            --btn-color: var(--neon-blue);
            background: transparent;
            color: var(--btn-color);
            border: 1px solid var(--btn-color);
            padding: 8px 15px;
            border-radius: 5px;
            box-shadow: 0 0 3px var(--btn-color);
            transition: all 0.2s;
            font-weight: 500;
        }

        .btn:hover:not(:disabled) {
            background: var(--btn-color);
            color: var(--dark-bg);
            box-shadow: 0 0 10px var(--btn-color);
        }
        
        /* NOVO: Estilo para Migalhas de Pão (Breadcrumbs) (Mantido) */
        .breadcrumb {
            --bs-breadcrumb-divider-color: var(--neon-magenta);
            background-color: var(--bg-black) !important;
        }
        .breadcrumb-item a,
        .breadcrumb-item.active {
            color: var(--neon-blue) !important;
            text-shadow: 0 0 3px rgba(0, 255, 255, 0.4);
        }
        .breadcrumb-item.active {
            color: var(--neon-magenta) !important;
            text-shadow: 0 0 3px rgba(255, 0, 255, 0.4);
        }
        
        /* ============== INÍCIO DO CSS PARA A FOTO DE PERFIL ============== */
        .profile-img-container {
            width: 150px; /* Tamanho do container */
            height: 150px;
            margin: 0 auto;
            border-radius: 50%; /* Torna o container redondo */
            overflow: hidden; /* Garante que a imagem cortada não exceda */
            border: 3px solid var(--neon-magenta); /* Borda Neon */
            box-shadow: 0 0 10px var(--neon-magenta), 0 0 20px rgba(255, 0, 255, 0.4);
        }

        .profile-img {
            width: 100%; /* Ocupa 100% do container */
            height: 100%;
            object-fit: cover; /* Garante que a imagem preencha sem distorcer, cortando se necessário */
        }
        /* ============== FIM DO CSS PARA A FOTO DE PERFIL ============== */
        
    </style>
</head>

<body>

    <div class="container-fluid">
        <div class="row">

            <?php
            // Se você quiser que o sidebar e navbar sejam visíveis, 
            // você precisa ter o CSS de layout do dashboard funcionando corretamente.
            include('../../DASHBOARDS/COMPONENTES/svg.php');
            include('../../DASHBOARDS/COMPONENTES/navbar.php');
            include('../../DASHBOARDS/COMPONENTES/sidebar.php');
            ?>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="container-fluid pt-4 px-4">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-chevron p-3 bg-body-tertiary rounded-3">
                            <li class="breadcrumb-item">
                                <a class="link-body-emphasis" href="../../DASHBOARDS/ALUNOS/index.php">
                                    <svg class="bi" width="16" height="16" aria-hidden="true">
                                        <use xlink:href="#house-door-fill"></use>
                                    </svg>
                                    <span class="visually-hidden">Home</span>
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Meu Perfil</li>
                        </ol>
                    </nav>
                </div>
                <div
                    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
               
                </div>

                <?php if (isset($error_message)): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo htmlspecialchars($error_message); ?>
                    </div>
                <?php endif; ?>

                <?php if ($usuario): ?>
                    <div class="row">
                        <div class="col-md-4 text-center">
                           <div class="profile-img-container mb-4">
                                <img src="<?php echo htmlspecialchars($caminho_foto_exibicao); ?>" 
                                    alt="Foto de Perfil" 
                                    class="profile-img">
                            </div>
                            <h3 class="mb-3"><?php echo htmlspecialchars($usuario['nome']); ?></h3>
                            <p class="text-muted">
                                <?php echo htmlspecialchars($usuario['cargo'] ?? 'Tipo de Acesso não definido'); ?>
                            </p>
                            <a href="editar_perfil.php" class="btn btn-primary">
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
                                    Email:
                                    <span><?php echo htmlspecialchars($usuario['email'] ?? 'N/A'); ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Nível de Acesso:
                                    <span><?php echo htmlspecialchars($usuario['cargo'] ?? 'Não informado'); ?></span>
                                </li>
                            </ul>

                            <h4 class="mb-3">Informações Institucionais</h4>
                            <ul class="list-group">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Instituição (Escola):
                                    <span><?php echo htmlspecialchars($usuario['nome_instituicao'] ?? 'Não informado'); ?></span>
                                </li>
                                
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Município:
                                    <span><?php echo htmlspecialchars($usuario['municipio_escola'] ?? 'Não informado'); ?></span>
                                </li>

                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Turma:
                                    <span><?php echo htmlspecialchars($usuario['nome_turma_completo'] ?? 'Não informado'); ?></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                <?php endif; ?>

            </main>
        </div>
    </div>

    <?php
    include('../../DASHBOARDS/COMPONENTES/footer.php');
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>