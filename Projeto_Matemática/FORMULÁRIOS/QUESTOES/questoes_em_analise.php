<?php
include_once('../../DASHBOARDS/INCLUDE/SISTEMA_BE/connection.php');

$sql = "SELECT questoes.*, disciplinas.disciplina FROM questoes INNER JOIN disciplinas ON questoes.id_disciplina = disciplinas.id WHERE questoes.id_situacao = 2 ORDER BY questoes.id DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$questoes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Questões em Análise</title>
    <link rel="stylesheet" href="../../Include/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
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
    </style>

</head>

<body>
    <div class="container-fluid">

        <div class="row">
            <?php
            include_once('../../DASHBOARDS/COMPONENTES/svg.php');
            include_once('../../DASHBOARDS/COMPONENTES/navbar.php');
            include_once('../../DASHBOARDS/COMPONENTES/sidebar.php');
            ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div
                    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Questões em Análise</h1>
                </div>
                <table id="questoesTable" class="display">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Enunciado</th>
                            <th>Origem</th>
                            <th>Assunto</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($questoes as $questao): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($questao['id']); ?></td>
                                <td><?php echo htmlspecialchars($questao['enunciado']); ?></td>
                                <td><?php echo htmlspecialchars($questao['origem']); ?></td>
                                <td><?php echo htmlspecialchars($questao['disciplina']); ?></td>
                                <td>
                                    <a href="editar_questao.php?id=<?php echo $questao['id']; ?>"
                                        class="btn btn-warning btn-sm">Editar</a>
                                    <a href="excluir_questao.php?id=<?php echo $questao['id']; ?>"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Tem certeza que deseja excluir esta questao?');">Excluir</a>
                                    <a href="aprovar_questao.php?id=<?php echo $questao['id']; ?>"
                                        class="btn btn-success btn-sm">Aprovar</a>
                                    <a href="negar_questao.php?id=<?php echo $questao['id']; ?>"
                                        class="btn btn-secondary btn-sm">Negar</a>
                                    <a href="visualizar_questao.php?id=<?php echo $questao['id']; ?>"
                                        class="btn btn-secondary btn-sm">View</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </main>
        </div>
    </div>
    <?php
    include_once('../../DASHBOARDS/COMPONENTES/footer.php');
    ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready(function () {
            $('#questoesTable').DataTable();
        });
    </script>
</body>

</html>