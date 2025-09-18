<?php
include_once('../../Include/connection.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Deleta a questao da tabela `questões`
    $sql_delete = "DELETE FROM questoes WHERE id = ?";
    $stmt = $pdo->prepare($sql_delete);
    $stmt->execute([$id]);

    // Redireciona para a página de onde a solicitação veio
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}
?>