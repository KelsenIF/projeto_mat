<?php
include_once('../../Dashboards/Include/connection.php');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $sql = "SELECT caminho_imagem FROM imagens WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
    $imagem = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($imagem) {
        if (file_exists($imagem['caminho_imagem'])) {
            unlink($imagem['caminho_imagem']);
        }

        $sqlDel = "DELETE FROM imagens WHERE id = :id";
        $stmtDel = $pdo->prepare($sqlDel);
        $stmtDel->bindParam(":id", $id, PDO::PARAM_INT);
        $stmtDel->execute();
    }
}

header("Location: listar_imagens.php");
exit;
?>
