<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once('../../DASHBOARDS/INCLUDE/SISTEMA_BE/connection.php');


if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../LOGIN/login.php");
    exit;
}


$log_id = $_SESSION['id_usuario'];

try {

    $sql = "
        SELECT 
            p.nome, 
            p.email, 
            p.foto_perfil, 
            p.cpf,
            p.nome_escola AS nome_instituicao, -- 💡 Alterado para nome_instituicao no HTML
            p.nome_turma AS turma,             -- 💡 Alterado para turma no HTML
            p.senha, 
            p.nivel_de_acesso, 
            
            e.cod_inep AS codigo_instituicao,   -- 💡 Alias para código
            e.cidade AS municipio_escola,      -- 💡 Alias para município
            l.id AS id_acesso,
            l.cargo                      -- 💡 Seleciona o tipo_acesso da tabela logs (ou similar)
        FROM 
            pessoas p
        LEFT JOIN 
            escolas e ON p.nome_escola = e.cod_inep
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

} catch (PDOException $e) {
    error_log("Erro ao buscar dados do perfil: " . $e->getMessage());
    $error_message = "Não foi possível carregar as informações do perfil. Detalhes técnicos registrados.";
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="../../DASHBOARDS/ALUNOS/dashboard.css" rel="stylesheet" />
    

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

        .b-example-divider {
            width: 100%;
            height: 3rem;
            background-color: #0000001a;
            border: solid rgba(0, 0, 0, 0.15);
            border-width: 1px 0;
            box-shadow:
                inset 0 0.5em 1.5em #0000001a,
                inset 0 0.125em 0.5em #00000026;
        }

        .b-example-vr {
            flex-shrink: 0;
            width: 1.5rem;
            height: 100vh;
        }

        .bi {
            vertical-align: -0.125em;
            fill: currentColor;
        }

        .nav-scroller {
            position: relative;
            z-index: 2;
            height: 2.75rem;
            overflow-y: hidden;
        }

        .nav-scroller .nav {
            display: flex;
            flex-wrap: nowrap;
            padding-bottom: 1rem;
            margin-top: -1px;
            overflow-x: auto;
            text-align: center;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
        }

        .btn-bd-primary {
            --bd-violet-bg: #712cf9;
            --bd-violet-rgb: 112.520718, 44.062154, 249.437846;
            --bs-btn-font-weight: 600;
            --bs-btn-color: var(--bs-white);
            --bs-btn-bg: var(--bd-violet-bg);
            --bs-btn-border-color: var(--bd-violet-bg);
            --bs-btn-hover-color: var(--bs-white);
            --bs-btn-hover-bg: #6528e0;
            --bs-btn-hover-border-color: #6528e0;
            --bs-btn-focus-shadow-rgb: var(--bd-violet-rgb);
            --bs-btn-active-color: var(--bs-btn-hover-color);
            --bs-btn-active-bg: #5a23c8;
            --bs-btn-active-border-color: #5a23c8;
        }

        .bd-mode-toggle {
            z-index: 1500;
        }

        .bd-mode-toggle .bi {
            width: 1em;
            height: 1em;
        }

        .bd-mode-toggle .dropdown-menu .active .bi {
            display: block !important;
        }

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
            include('../../DASHBOARDS/COMPONENTES/svg.php');
            include('../../DASHBOARDS/COMPONENTES/navbar.php');
            include('../../DASHBOARDS/COMPONENTES/sidebar.php');
            ?>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div
                    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
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
                                <img src="/Projeto_Matemática(2)/User_Registration/<?php echo htmlspecialchars($usuario['foto_perfil']); ?>"
                                    alt="Foto de Perfil" class="profile-img">
                            </div>
                            <h3 class="mb-3"><?php echo htmlspecialchars($usuario['nome']); ?></h3>
                            <p class="text-muted">
                                <?php echo htmlspecialchars($usuario['tipo_acesso'] ?? 'Tipo de Acesso não definido'); ?>
                            </p>
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
                                    Identificação de Usuário (CPF):
                                    <span><?php echo htmlspecialchars($usuario['cpf'] ?? 'N/A'); ?></span>
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
                                    <span><?php echo htmlspecialchars($usuario['nome_instituicao'] ?? 'Não informado'); ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Código da Instituição:
                                    <span><?php echo htmlspecialchars($usuario['codigo_instituicao'] ?? 'Não informado'); ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Município:
                                    <span><?php echo htmlspecialchars($usuario['municipio_escola'] ?? 'Não informado'); ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Turma:
                                    <span><?php echo htmlspecialchars($usuario['turma'] ?? 'Não informado'); ?></span>
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