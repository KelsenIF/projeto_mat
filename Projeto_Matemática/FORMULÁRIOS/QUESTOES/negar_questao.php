<?php
include_once('../../DASHBOARDS/include/connection.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "UPDATE questoes SET id_situacao = 0 WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);

    header('Location: ../../DASHBOARDS/ALUNOS/index.php');
    exit();
}
?>