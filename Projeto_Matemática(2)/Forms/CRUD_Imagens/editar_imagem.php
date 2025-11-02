<?php
include_once('../../Dashboards/Include/connection.php');

if (!isset($_GET['id'])) {
    die("ID inválido!");
}

$id = intval($_GET['id']);
$sql = "SELECT * FROM imagens WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(":id", $id, PDO::PARAM_INT);
$stmt->execute();
$imagem = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$imagem) {
    die("Imagem não encontrada!");
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Imagem</title>
</head>
<body>
    <h1>Editar Imagem</h1>
    <form action="proc_editar_imagem.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $imagem['id'] ?>">
        Nome: <input type="text" name="nome" value="<?= htmlspecialchars($imagem['nome_imagem']) ?>"><br><br>
        Substituir imagem: <input type="file" name="imagem"><br><br>
        <button type="submit">Salvar</button>
    </form>
</body>
</html>
