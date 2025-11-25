<?php
require_once('../../DASHBOARDS/include/connection.php');

$sql_turma = "
    SELECT 
        t.id, 
        t.nome_turma,
        t.cod_inep,
        e.nome_escola AS nome_escolar 
    FROM 
        turmas t
    JOIN 
        escolas e ON t.cod_inep = e.cod_inep
    ORDER BY 
        t.id DESC
";

$turma = $pdo->prepare($sql_turma);
$turma->execute();


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LISTAR - TURMAS</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.min.css">
    
</head>

<body>
    <section class="container">
        <h2 class="my-4">Turmas Cadastradas</h2>
        
        <table class="table table-striped table-bordered" id="minhaTabela">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>TURMA</th>
                    <th>ESCOLA</th>
                    <th>AÇÕES</th>
                </tr>
            </thead>
            <tbody>

                <?php
                while ($turm = $turma->fetch(PDO::FETCH_ASSOC)) { 
                ?>

                    <tr>
                        <td><?php echo htmlspecialchars($turm['id']); ?></td>
                        <td><?php echo htmlspecialchars($turm['nome_turma']); ?></td>
                        <td><?php echo htmlspecialchars($turm['nome_escolar']); ?></td>
                        <td>
                            <a class="btn btn-primary btn-sm"
                                href="<?php echo 'editar_turmas.php?id=' . $turm['id']; ?>">Editar</a>
                            <a class="btn btn-danger btn-sm"
                                href="<?php echo 'deletar_turmas.php?id=' . $turm['id']; ?>">Excluir</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </section>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#minhaTabela').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/2.0.7/i18n/pt-BR.json"
                },
                "order": [[ 0, "desc" ]]
            });
        });
    </script>

</body>
</html>