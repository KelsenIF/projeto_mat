<?php
include_once('../../DASHBOARDS/include/connection.php');

// ADICIONE ESTAS DUAS LINHAS PARA GARANTIR QUE O SIDEBAR FUNCIONE COM NÍVEIS DE ACESSO.
session_start();
$nivel_acesso = $_SESSION['nivel_de_acesso'] ?? 0;

$sql = "SELECT questoes.*, disciplinas.disciplina FROM questoes INNER JOIN disciplinas ON questoes.id_disciplina = disciplinas.id WHERE questoes.id_situacao = 1 ORDER BY questoes.id DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$questoes = $stmt->fetchAll(PDO::FETCH_ASSOC);
$questoes_ativo = true;

// --- INÍCIO DA MUDANÇA PARA BREADCRUMBS ---
$breadcrumbs = [
       ['url' => '../../DASHBOARDS/ALUNOS/index.php', 'title' => 'Dashboard'],
    ['url' => '../../DASHBOARDS/ALUNOS/index.php', 'title' => 'Questões'],
    ['url' => 'questoes_aprovadas.php', 'title' => 'Aprovadas']
];
// --- FIM DA MUDANÇA PARA BREADCRUMBS ---
?>

<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Questões Aprovadas</title>
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
    </style>
</head>

<body>
    <?php
    include_once('../../DASHBOARDS/COMPONENTES/navbar.php');
    ?>

    <div class="container-fluid">
        <div class="row">
            <?php
            include_once('../../DASHBOARDS/COMPONENTES/sidebar.php');
            include_once('../../DASHBOARDS/COMPONENTES/svg.php');
            ?>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mx-auto">
                <?php include_once('../../DASHBOARDS/COMPONENTES/breadcrumbs.php'); ?>
                <div class="pt-3 pb-2 mb-3">
                    <h1 class="h2">Questões Aprovadas</h1>
                </div>

                <table id="questoesTable" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Enunciado</th>
                            <th>Origem</th>
                            <th>Disciplina</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($questoes as $questao) : ?>
                            <tr>
                                <td><?php echo htmlspecialchars($questao['id']); ?></td>
                                <td><?php echo htmlspecialchars(mb_substr($questao['enunciado'], 0, 50)) . (mb_strlen($questao['enunciado']) > 50 ? '...' : ''); ?></td>
                                <td><?php echo htmlspecialchars($questao['origem']); ?></td>
                                <td><?php echo htmlspecialchars($questao['disciplina']); ?></td>
                                <td>
                                    <a href="editar_questao.php?id=<?php echo $questao['id']; ?>"
                                        class="btn btn-warning btn-sm">Editar</a>
                                    <a href="excluir_questao.php?id=<?php echo $questao['id']; ?>"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Tem certeza que deseja excluir esta questao?');">Excluir</a>
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