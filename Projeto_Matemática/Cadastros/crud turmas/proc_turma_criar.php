<?php
include_once '../conexao.php';
//Receber dados do formulário
$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
var_dump($dados);

try {
    $sql = "INSERT INTO turma(ano, id_serie, id_escola, deleted) VALUES (:ano,:id_serie,:id_escola,0)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':ano', $dados['ano']);
    $stmt->bindParam(':id_serie', $dados['serie']);
    $stmt->bindParam(':id_escola', $dados['escola']);
    $stmt->execute();
    $id_escola = $dados['escola'];

    if ($stmt->rowCount()) {
        echo "<script>
                      alert('Cadastro realizado com sucesso!');
             window.location.href = 'turma_relatorio.php?id=$id_escola';
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