<?php
include '../include/connection.php';

if (!isset($_GET['id'])) {
    die("ID não informado.");
}

$id = $_GET['id'];

try {
    $stmt = $pdo->prepare("SELECT * FROM escola WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $escola = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$escola) {
        die("Escola não encontrada.");
    }
} catch (PDOException $e) {
    die("Erro: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $id_moderador = $_POST['id_moderador'];

    $stmt = $pdo->prepare("UPDATE escola SET nome = :nome, id_moderador = :id_moderador WHERE id = :id");
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':id_moderador', $id_moderador);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        header("Location: index.php?sucesso=1");
        exit;
    } else {
        echo "Erro ao atualizar.";
    }
}
?>

<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title>Editar Escola</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-dark bg-dark fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Editar Escola</a>
    </div>
</nav>

<div class="container mt-5 pt-5">
    <form method="post">
        <div class="mb-3">
            <label for="nome" class="form-label">Nome da Escola</label>
            <input type="text" class="form-control" id="nome" name="nome" value="<?= htmlspecialchars($escola['nome']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="id_moderador" class="form-label">ID do Moderador</label>
            <input type="number" class="form-control" id="id_moderador" name="id_moderador" value="<?= $escola['id_moderador'] ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
        <a href="index.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

</body>
</html>
