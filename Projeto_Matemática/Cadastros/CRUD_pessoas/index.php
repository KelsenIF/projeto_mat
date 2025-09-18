<?php
include '../include/connection.php';

$mensagem = '';
if (isset($_GET['sucesso'])) {
    $mensagem = "Pessoa atualizada com sucesso!";
} elseif (isset($_GET['excluido'])) {
    $mensagem = "Pessoa excluída com sucesso!";
}

$busca = $_GET['busca'] ?? '';
$sql = "SELECT * FROM pessoa WHERE deleted = 0";

if (!empty($busca)) {
    $sql .= " AND (nome LIKE :busca OR email LIKE :busca)";
}

$sql .= " ORDER BY id DESC";

try {
    $stmt = $pdo->prepare($sql);
    if (!empty($busca)) {
        $filtro = "%$busca%";
        $stmt->bindParam(':busca', $filtro);
    }
    $stmt->execute();
    $pessoas = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro: " . $e->getMessage());
}
?>

<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title>Relatório de Pessoas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
          crossorigin="anonymous">
    <style>.tabela-scroll { max-height: 60vh; overflow-y: auto; }</style>
</head>
<body>
<nav class="navbar navbar-dark bg-dark fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Relatório de Pessoas</a>
    </div>
</nav>
<div class="container mt-5 pt-5">
    <?php if (!empty($mensagem)): ?>
        <div class="alert alert-success text-center"><?= $mensagem ?></div>
    <?php endif; ?>

    <form class="mb-3 d-flex" method="get">
        <input type="text" name="busca" class="form-control me-2" placeholder="Buscar por nome ou email..." value="<?= htmlspecialchars($busca) ?>">
        <button class="btn btn-outline-primary" type="submit">Buscar</button>
    </form>

    <div class="tabela-scroll">
        <table class="table table-bordered table-hover align-middle text-center">
            <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>ID Perfil</th>
                <th>ID Turma</th>
                <th>Ações</th>
            </tr>
            </thead>
            <tbody>
            <?php if ($pessoas): ?>
                <?php foreach ($pessoas as $pessoa): ?>
                    <tr>
                        <td><?= $pessoa['id'] ?></td>
                        <td><?= htmlspecialchars($pessoa['nome']) ?></td>
                        <td><?= htmlspecialchars($pessoa['email']) ?></td>
                        <td><?= $pessoa['id_perfil'] ?></td>
                        <td><?= $pessoa['id_turma'] ?></td>
                        <td>
                            <a href="edit.php?id=<?= $pessoa['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
                            <a href="delete.php?id=<?= $pessoa['id'] ?>" class="btn btn-sm btn-danger"
                               onclick="return confirm('Tem certeza que deseja excluir esta pessoa?');">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="6">Nenhuma pessoa encontrada.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="mt-4 d-flex gap-3">
        <a href="create.php" class="btn btn-primary">Cadastrar Nova Pessoa</a>
        <a href="../index.php" class="btn btn-secondary">Voltar ao Dashboard</a>
    </div>
</div>
</body>
</html>
