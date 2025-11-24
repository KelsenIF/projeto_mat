<?php
require_once('../../DASHBOARDS/INCLUDE/SISTEMA_BE/connection.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql_deletar = "DELETE FROM disciplinas WHERE id = ?";
    $stmt = $pdo->prepare($sql_deletar);
    $stmt->execute([$id]);

    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}

//ADICIONAR "POPUP" PARA CONFIRMAR A EXCLUSÃO
?>

