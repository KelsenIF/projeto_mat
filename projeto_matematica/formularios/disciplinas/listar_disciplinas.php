<?php
include_once('../../Include/connection.php');

$sql_disciplina = "SELECT * FROM assuntos ORDER BY id DESC";
$disciplina = $pdo->prepare($sql_disciplina);
$disciplina->execute();

$sql_escolaridade = "SELECT * FROM anos_escolaridades ORDER BY id DESC";
$escolaridade = $pdo->prepare($sql_escolaridade);
$escolaridade->execute();
?>


<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Listar - Disciplinas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body>
    <section class="#">
        <table class="table table-striped table-bordered mt-4" id="minhaTabela">
            <thead>
                <tr>
                    <th>Identificador</th>
                    <th>Nome</th>
                    <th>Escolaridade</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>

                <?php

                while ($prod = $disciplina->fetch(PDO::FETCH_ASSOC)) { ?>

                    <tr>
                        <td><?php echo $prod['id'] ?></td>
                        <td><?php echo $prod['disciplina'] ?></td>
                        <td><?php echo $prod['id_escolaridade'] ?></td>
                        <td><a class="btn btn-primary btn-sm"
                                href="<?php echo ("produto_editar.php?id=<?php $prod[id]") ?>">Editar</a>
                        <a class="btn btn-danger btn-sm"
                                href="<?php echo ("produto_excluir.php?id=<?php $prod[id]") ?>">Excluir</a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </section>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>

    <script type="text/javascript">

        $(document).ready(function () {

            $('#minhaTabela').DataTable({

                "language": {

                    "url": "https://cdn.datatables.net/plug-ins/2.3.1/i18n/pt-BR.json"


                },

                paging: true

            });

        });

    </script>
    <script src="https://cdn.datatables.net/2.3.1/js/dataTables.min.js"></script>
</body>

</html>