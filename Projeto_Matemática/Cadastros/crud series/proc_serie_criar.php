<?php
include_once '../conexao.php';
//Receber dados do formulário
$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
var_dump($dados);

try {
    $sql = "INSERT INTO serie(ensino, periodo) VALUES (:ensino, :periodo)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':ensino', $dados['ensino']);
    $stmt->bindParam(':periodo', $dados['periodo']);
    $stmt->execute();

    if ($stmt->rowCount()) {
        echo "<script>
                      alert('Cadastro realizado com sucesso!');
             window.location.href = 'serie_relatorio.php';
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