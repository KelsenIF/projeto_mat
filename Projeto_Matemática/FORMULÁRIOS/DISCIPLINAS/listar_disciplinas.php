<?php
require_once('../../DASHBOARDS/INCLUDE/SISTEMA_BE/connection.php');

$sql_disciplina = "
    SELECT 
        d.id, 
        d.disciplina, 
        ae.nome_escolaridade AS nome_escolaridade 
    FROM 
        disciplinas d
    JOIN 
        anos_escolaridades ae ON d.id_escolaridade = ae.id
    ORDER BY 
        d.id DESC
";

$disciplina = $pdo->prepare($sql_disciplina);
$disciplina->execute();


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LISTAR - DISCIPLINAS</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.min.css">
    
</head>

<body>
    <section class="container">
        <h2 class="my-4">Disciplinas Cadastradas</h2>
        
        <table class="table table-striped table-bordered" id="minhaTabela">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>DISCIPLINA</th>
                    <th>ESCOLARIDADE</th>
                    <th>AÇÕES</th>
                </tr>
            </thead>
            <tbody>

                <?php
                while ($disc = $disciplina->fetch(PDO::FETCH_ASSOC)) { 
                ?>

                    <tr>
                        <td><?php echo htmlspecialchars($disc['id']); ?></td>
                        <td><?php echo htmlspecialchars($disc['disciplina']); ?></td>
                        <td><?php echo htmlspecialchars($disc['nome_escolaridade']); ?></td>
                        <td>
                            <a class="btn btn-primary btn-sm"
                                href="<?php echo 'editar_disciplinas.php?id=' . $disc['id']; ?>">Editar</a>
                            <a class="btn btn-danger btn-sm"
                                href="<?php echo 'deletar_disciplinas.php?id=' . $disc['id']; ?>">Excluir</a>
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