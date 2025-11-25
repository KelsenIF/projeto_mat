<?php
include_once('../../DASHBOARDS/include/connection.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql_delete = "DELETE FROM questoes WHERE id = ?";
    $stmt = $pdo->prepare($sql_delete);
    $stmt->execute([$id]);

    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}
?>