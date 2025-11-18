<?php
include_once('../../Dashboards/Include/connection.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "UPDATE questoes SET id_situacao = 0 WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);

    // Redireciona de volta para a página de questões em análise
    header('Location: ../../../Projeto_Matemática(2)/Dashboards/Alunos/index.php');
    exit();
}
?>