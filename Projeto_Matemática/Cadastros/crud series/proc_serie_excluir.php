<?php
include_once '../conexao.php';
//Receber dados do formulário

try {
    $sql = "DELETE FROM serie WHERE id = :id;";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $_GET['id']);
    $stmt->execute();

    if ($stmt->rowCount()) {
        echo "<script>
                      alert('exclusao realizada com sucesso!');
             window.location.href = 'serie_relatorio.php';
         </script>";
    } else {
        echo "<script>
             alert('Erro ao excluir!');
             window.location.href = 'nova_tarefa.php';
         </script>";
    }
} catch (PDOException $e) {
    echo "<script>
         alert('Erro no sistema: " . $e->getMessage() . "');
         window.location.href = 'nova_tarefa.php';
     </script>";
}