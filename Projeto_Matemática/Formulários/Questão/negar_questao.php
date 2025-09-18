<?php
include_once('../../Include/connection.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "UPDATE questões SET id_situacao = 0 WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);

    // Redireciona de volta para a página de questões em análise
    header('Location: questoes_em_analise.php');
    exit();
}
?>