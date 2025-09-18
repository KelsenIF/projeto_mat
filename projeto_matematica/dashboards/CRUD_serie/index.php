<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>INDEX</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
</head>

<body>
    <?php
    include_once('../../Include/connection.php');

    try {
        $stmt = $pdo->query("SELECT id, ensino, periodo FROM serie ORDER BY id ASC");
        $serie = $stmt->fetchAll();
    } catch (PDOException $e) {
        die("Erro ao buscar questões: " . $e->getMessage());
    }
    ?>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Relatório - Séries</h4> <a href="create.php" class="btn btn-primary">ADICIONAR</a>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>ENSINO</th>
                                    <th>PERÍODO</th>
                                    <th>AÇÕES</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php if (count($serie) > 0): ?>
                                    <?php foreach ($serie as $q): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($q['id']) ?></td>
                                            <td><?= htmlspecialchars(substr($q['ensino'], 0, 100)) ?>...</td>
                                            <td><?= htmlspecialchars($q['periodo']) ?></td>
                                            <td>
                                                <a href="edit.php?id=<?= $q['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
                                                <a href="delete.php?id=<?= $q['id'] ?>"
                                                    class="btn btn-sm btn-danger">Excluir</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="text-center">Nenhum cadastro.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
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