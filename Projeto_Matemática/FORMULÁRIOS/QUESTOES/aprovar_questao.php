<?php
include_once('../../DASHBOARDS/INCLUDE/SISTEMA_BE/connection.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "UPDATE questoes SET id_situacao = 1 WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);

    header('Location: questoes_aprovadas.php');
    
    exit();
}
?>