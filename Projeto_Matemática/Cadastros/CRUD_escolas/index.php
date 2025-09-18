<?php
include '../include/connection.php';

// Mensagens de sucesso
$mensagem = '';
if (isset($_GET['sucesso'])) {
    $mensagem = "Escola atualizada com sucesso!";
} elseif (isset($_GET['excluido'])) {
    $mensagem = "Escola excluída com sucesso!";
}

// Filtro de busca
$busca = $_GET['busca'] ?? '';
$sql = "SELECT * FROM escola WHERE deleted = 0";

if (!empty($busca)) {
    $sql .= " AND (nome LIKE :busca OR id_moderador LIKE :busca)";
}

$sql .= " ORDER BY id DESC";

try {
    $stmt = $pdo->prepare($sql);
    if (!empty($busca)) {
        $filtro = "%$busca%";
        $stmt->bindParam(':busca', $filtro);
    }
    $stmt->execute();
    $escolas = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro: " . $e->getMessage());
}
?>

<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title>Relatório de Escolas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
          crossorigin="anonymous">
    <style>
        .tabela-scroll {
            max-height: 60vh;
            overflow-y: auto;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-dark bg-dark fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Relatório de Escolas</a>
    </div>
</nav>

<div class="container mt-5 pt-5">
    <?php if (!empty($mensagem)): ?>
        <div class="alert alert-success text-center"><?= $mensagem ?></div>
    <?php endif; ?>

    <form class="mb-3 d-flex" method="get">
        <input type="text" name="busca" class="form-control me-2" placeholder="Buscar por nome ou moderador..." value="<?= htmlspecialchars($busca) ?>">
        <button class="btn btn-outline-primary" type="submit">Buscar</button>
    </form>

    <div class="tabela-scroll">
        <table class="table table-bordered table-hover align-middle text-center">
            <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>ID Moderador</th>
                <th>Ações</th>
            </tr>
            </thead>
            <tbody>
            <?php if ($escolas): ?>
                <?php foreach ($escolas as $escola): ?>
                    <tr>
                        <td><?= $escola['id'] ?></td>
                        <td><?= htmlspecialchars($escola['nome']) ?></td>
                        <td><?= $escola['id_moderador'] ?></td>
                        <td>
                            <a href="edit.php?id=<?= $escola['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
                            <a href="delete.php?id=<?= $escola['id'] ?>" class="btn btn-sm btn-danger"
                               onclick="return confirm('Tem certeza que deseja excluir esta escola?');">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="4">Nenhuma escola encontrada.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="mt-4 d-flex gap-3">
        <a href="create.php" class="btn btn-primary">Cadastrar Nova Escola</a>
        <a href="../index.php" class="btn btn-secondary">Voltar ao Dashboard</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
</body>
</html>
