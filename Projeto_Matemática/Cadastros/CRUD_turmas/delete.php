<?php
include_once ('../include/connection.php');

try {
    $sql = "UPDATE turma SET deleted = 1 WHERE id = :id;";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $_GET['id']);
    $stmt->execute();

    $id_escola = 1; //link

    if ($stmt->rowCount()) {
        echo "<script>
                      alert('exclusao realizada com sucesso!');
             window.location.href = 'index.php';
         </script>";
    } else {
        echo "<script>
             alert('Erro ao excluir!');
             window.location.href = 'index.php';
         </script>";
    }
} catch (PDOException $e) {
    echo "<script>
         alert('Erro no sistema: " . $e->getMessage() . "');
         window.location.href = 'index.php';
     </script>";
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