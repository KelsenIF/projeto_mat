<?php

include_once('../../Include/connection.php');

if (isset($_POST['action']) && $_POST['action'] === 'create') {

    $ensino = $_POST['ensino'];
    $periodo = $_POST['período'];

    try {
        $stmt = $pdo->prepare("INSERT INTO serie (ensino, periodo) VALUES ( :ensino, :periodo)");

        $stmt->execute([
            ':ensino' => $ensino,
            ':periodo' => $periodo
        ]);

        $ultimoId = $pdo->lastInsertId();
        echo "<script>
                      alert('Adição realizada com sucesso!');
             window.location.href = 'index.php';
         </script>";

    } catch (PDOException $e) {
        echo "Erro ao salvar questão: " . $e->getMessage();
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
    $sql = "UPDATE serie SET ensino=:ensino, periodo=:periodo WHERE id=:id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':ensino', $dados['ensino']);
    $stmt->bindParam(':periodo', $dados['periodo']);
    $stmt->bindParam(':id', $dados['id']);
    $stmt->execute();

    if ($stmt->rowCount()) {
        echo "<script>
                      alert('Edicao realizada com sucesso!');
             window.location.href = 'index.php';
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