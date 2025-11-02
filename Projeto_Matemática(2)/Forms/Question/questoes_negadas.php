<?php
include_once('../../Dashboards/Include/connection.php');

$sql = "SELECT questoes.*, disciplinas.disciplina FROM questoes INNER JOIN disciplinas ON questoes.id_disciplina = disciplinas.id WHERE questoes.id_situacao = 0 ORDER BY questoes.id DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$questoes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Questões Negadas</title>
            <link rel="stylesheet" type="text/css" href="../../Dashboards/dashboard.css">
    <link rel="stylesheet" href="../../include/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
</head>
<body>
     <div class="container-fluid">
        <div class="row">
            
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Questões Negadas</h1>
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
                                    <a href="editar_questao.php?id=<?php echo $questao['id']; ?>" class="btn btn-warning btn-sm">Editar</a>
                                    <a href="excluir_questao.php?id=<?php echo $questao['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir esta questao?');">Excluir</a>
                                    <a href="aprovar_questao.php?id=<?php echo $questao['id']; ?>" class="btn btn-success btn-sm">Aprovar</a>
                                    <a href="../../formularios/questao/visualizar_questao.php?id=<?php echo $questao['id']; ?>"
                                        class="btn btn-secondary btn-sm">View</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </main>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready(function() {
            $('#questoesTable').DataTable();
        });
    </script>
</body>
</html>