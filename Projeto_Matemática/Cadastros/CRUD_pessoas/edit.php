<?php
include '../include/connection.php';

if (!isset($_GET['id'])) {
    die("ID não informado.");
}

$id = $_GET['id'];

try {
    $stmt = $pdo->prepare("SELECT * FROM pessoa WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $pessoa = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$pessoa) {
        die("Pessoa não encontrada.");
    }
} catch (PDOException $e) {
    die("Erro: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $id_perfil = $_POST['id_perfil'];
    $id_turma = $_POST['id_turma'];

    $stmt = $pdo->prepare("UPDATE pessoa SET nome = :nome, email = :email, id_perfil = :id_perfil, id_turma = :id_turma WHERE id = :id");
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':id_perfil', $id_perfil);
    $stmt->bindParam(':id_turma', $id_turma);
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
    <title>Editar Pessoa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-dark bg-dark fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Editar Pessoa</a>
    </div>
</nav>

<div class="container mt-5 pt-5">
    <form method="post">
        <div class="mb-3">
            <label for="nome" class="form-label">Nome</label>
            <input type="text" class="form-control" id="nome" name="nome" value="<?= htmlspecialchars($pessoa['nome']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($pessoa['email']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="id_perfil" class="form-label">ID Perfil</label>
            <input type="number" class="form-control" id="id_perfil" name="id_perfil" value="<?= $pessoa['id_perfil'] ?>" required>
        </div>
        <div class="mb-3">
            <label for="id_turma" class="form-label">ID Turma</label>
            <input type="number" class="form-control" id="id_turma" name="id_turma" value="<?= $pessoa['id_turma'] ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
        <a href="index.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

</body>
</html>
