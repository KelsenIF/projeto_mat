<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>INDEX</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
        xintegrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">

    <?php

    include_once('../include/connection.php');


    $id_escola = 1;


    $stmtEscola = $pdo->prepare("SELECT nome FROM escola WHERE deleted = 0 AND id = :id ORDER BY id ASC");
    $stmtEscola->bindParam(':id', $id_escola);
    $stmtEscola->execute();


    $escola_data = $stmtEscola->fetchAll(PDO::FETCH_ASSOC);


    if (!empty($escola_data)) {
        $escola = $escola_data[0];
        $nome_escola = $escola['nome'];
    } else {

        echo "<script>alert('Escola não encontrada!'); window.location.href='../crud escolas/escola_relatorio.php';</script>";
        exit(); // Interrompe a execução do script.
    }
    ?>

</head>

<body>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Relatório - Turmas (<?php echo htmlspecialchars($nome_escola); ?>)</h4>

                        <a href="create.php" class="btn btn-primary">ADICIONAR</a>
                    </div>
                    <div class="card-body">
                        <?php
                        try {

                            $stmtTurmas = $pdo->prepare("SELECT id, ano, id_serie FROM turma WHERE deleted = 0 AND id_escola = :id_escola ORDER BY id ASC");
                            $stmtTurmas->bindParam(':id_escola', $id_escola);
                            $stmtTurmas->execute();
                            $turmas = $stmtTurmas->fetchAll(PDO::FETCH_ASSOC);


                            if (!empty($turmas)) {

                                echo "<table class='table table-bordered table-striped'>";
                                echo "<thead>";
                                echo "<tr><th>ID</th><th>Ano</th><th>Série</th><th>Ações</th></tr>";
                                echo "</thead>";
                                echo "<tbody>";


                                foreach ($turmas as $turma) {
                                    $id = $turma['id'];
                                    $ano = $turma['ano'];
                                    $id_serie = $turma['id_serie'];


                                    $stmtSerie = $pdo->prepare("SELECT ensino, periodo FROM serie WHERE id = :id");
                                    $stmtSerie->bindParam(':id', $id_serie);
                                    $stmtSerie->execute();

                                    $serie_data = $stmtSerie->fetchAll(PDO::FETCH_ASSOC);


                                    if (!empty($serie_data)) {
                                        $serie = $serie_data[0];
                                        $nome_serie = htmlspecialchars($serie['ensino']) . " | " . htmlspecialchars($serie['periodo']);
                                    } else {

                                        $nome_serie = "Série não encontrada";

                                    }


                                    echo "<tr>
                                            <td>" . htmlspecialchars($id) . "</td>
                                            <td>" . htmlspecialchars($ano) . "</td>
                                            <td>" . $nome_serie . "</td>
                                            <td>
                                                <a href='pessoas.php?id=" . htmlspecialchars($id) . "' class='btn btn-sm btn-info me-2'>Alunos</a>
                                                <a href='edit.php?id=" . htmlspecialchars($id) . "' class='btn btn-sm btn-warning me-2'>Editar</a>
                                                <a href='delete.php?id=" . htmlspecialchars($id) . "&escola=" . htmlspecialchars($id_escola) . "' class='btn btn-sm btn-danger' onclick=\"return confirm('Tem certeza que deseja excluir esta turma?');\">Excluir</a>
                                            </td>
                                          </tr>";
                                }

                                echo "</tbody>";
                                echo "</table>";
                            } else {

                                echo "<div class='alert alert-info' role='alert'>Nenhuma turma cadastrada para esta escola.</div>";
                            }

                        } catch (PDOException $e) {

                            echo "<div class='alert alert-danger' role='alert'>Erro ao gerar relatório de turmas: " . htmlspecialchars($e->getMessage()) . "</div>";
                        }
                        ?>


                        <a href="<?php echo "../index.php" ?>" class="btn btn-secondary mt-3">
                            Voltar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO"
        crossorigin="anonymous"></script>
</body>

</html>