<?php
include_once '../conexao.php';
//Receber dados do formulário
$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
var_dump($dados);

try {
    $sql = "INSERT INTO escola(nome, id_moderador, deleted) VALUES (:nome,:moderador, 0)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nome', $dados['nome']);
    $stmt->bindParam(':moderador', $dados['moderador']);
    $stmt->execute();

    if ($stmt->rowCount()) {
        echo "<script>
                      alert('Cadastro realizado com sucesso!');
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