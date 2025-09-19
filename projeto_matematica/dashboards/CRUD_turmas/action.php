<?php

include_once('../../Include/connection.php');

if (isset($_POST['action']) && $_POST['action'] === 'create') {

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
             window.location.href = 'index.php?';
         </script>";
    } else {
        echo "<script>
             alert('Erro ao cadastrar!');
             window.location.href = 'index.php';
         </script>";
    }
} catch (PDOException $e) {
    echo "<script>
         alert('Erro no sistema: " . $e->getMessage() . "');
         window.location.href = 'index.php';
     </script>";
}
}


if (isset($_POST['action']) && $_POST['action'] === 'edit') {

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
var_dump($dados);

try {
    $sql = "UPDATE turma SET ano=:ano, id_serie=:id_serie WHERE id=:id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':ano', $dados['ano']);
    $stmt->bindParam(':id_serie', $dados['serie']);
    $stmt->bindParam(':id', $dados['id']);
    $stmt->execute();

    $id_escola = $dados['escola'];

    if ($stmt->rowCount()) {
        echo "<script>
                      alert('Edicao realizada com sucesso!');
             window.location.href = 'index.php?id=$id_escola';
         </script>";
    } else {
        echo "<script>
             alert('Erro ao cadastrar!');
             window.location.href = 'index.php';
         </script>";
    }
} catch (PDOException $e) {
    echo "<script>
         alert('Erro no sistema: " . $e->getMessage() . "');
         window.location.href = 'index.php';
     </script>";
}
}


?>