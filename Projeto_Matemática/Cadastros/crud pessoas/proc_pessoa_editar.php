<?php
include_once '../conexao.php';
//Receber dados do formulário
$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
var_dump($dados);

try {
    $sql = "UPDATE pessoa SET id_turma=:id_turma WHERE id=:id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_turma', $dados['turma']);
    $stmt->bindParam(':id', $dados['id']);
    $stmt->execute();

    $turma_id = $dados['turma'];

    if ($stmt->rowCount()) {
        echo "<script>
                      alert('Edicao realizada com sucesso!');
             window.location.href = 'pessoa_relatorio.php?id=$turma_id';
         </script>";
    } else {
        echo "<script>
             alert('Erro ao cadastrar!');
             window.location.href = 'nova_tarefa.php';
         </script>";
    }
} catch (PDOException $e) {
    echo "<script>
         alert('Erro no sistema: " . $e->getMessage() . "');
         window.location.href = 'nova_tarefa.php';
     </script>";
}