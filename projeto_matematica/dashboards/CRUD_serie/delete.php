<?php
include_once('../../Include/connection.php');

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

$stmt = $pdo->prepare("SELECT * FROM serie WHERE id = ?");
$stmt->execute([$id]);
$serie = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$serie) {
    die("questao não encontrada.");
}

if (isset($_POST['confirmar'])) {
    $del = $pdo->prepare("DELETE FROM serie WHERE id = ?");
    $del->execute([$id]);
    header("Location: index.php?msg=excluida");
    exit;
}
?>

<!doctype html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <title>DELETE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header bg-danger text-white">
                <h4>Confirmação Exclusão</h4>
            </div>
            <div class="card-body">
                <p>Tem certeza que deseja excluir?</p>
                <blockquote><?= htmlspecialchars($serie['ensino']) ?> - <?= htmlspecialchars($serie['periodo']) ?>
                </blockquote>
                <form method="POST">
                    <a href="index.php" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" name="confirmar" class="btn btn-danger">Confirmar Exclusão</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>