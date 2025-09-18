<?php
include_once '../conexao.php';
//Receber dados do formulário

try {
    $sql = "UPDATE turma SET deleted = 1 WHERE id = :id;";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $_GET['id']);
    $stmt->execute();

    $id_escola = $_GET['escola'];

    if ($stmt->rowCount()) {
        echo "<script>
                      alert('exclusao realizada com sucesso!');
             window.location.href = 'turma_relatorio.php?id=$id_escola';
         </script>";
    } else {
        echo "<script>
             alert('Erro ao excluir!');
             window.location.href = 'turma_relatorio.php?id=$id_escola';
         </script>";
    }
} catch (PDOException $e) {
    echo "<script>
         alert('Erro no sistema: " . $e->getMessage() . "');
         window.location.href = 'nova_tarefa.php';
     </script>";
}