<?php
include_once '../conexao.php';
//Receber dados do formulário
$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
var_dump($dados);

try {
    $sql = "UPDATE escola SET nome=:nome, id_moderador=:id_moderador WHERE id=:id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nome', $dados['nome']);
    $stmt->bindParam(':id_moderador', $dados['moderador']);
    $stmt->bindParam(':id', $dados['id']);
    $stmt->execute();

    if ($stmt->rowCount()) {
        echo "<script>
                      alert('Edicao realizada com sucesso!');
             window.location.href = 'escola_relatorio.php';
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