<html>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
<link rel="stylesheet" href="../temporario/relatorio.css">
<body>
      <a href="escola_criar.php" style="
        display: inline-block;
        background-color: #2C3E50;
        color:rgb(255, 255, 255);
        padding: 10px 20px;
        text-decoration: none;
        border-radius: 5px;
        font-weight: bold;
        margin-bottom: 20px;
    ">+ Nova escola</a>
    <?php
include_once('../conexao.php');



try {
    

    $stmtEscolas = $pdo->prepare("SELECT id, nome, id_moderador FROM escola where deleted = 0 ORDER BY id ASC");
    $stmtEscolas->execute();
    $escolas = $stmtEscolas->fetchAll(PDO::FETCH_ASSOC);

    


    echo "<h2>Escolas</h2>";
    echo "<table border='1' cellpadding='8' cellspacing='0'>";
    echo "<tr><th>id</th><th>nome</th><th>moderador</th></tr>";

    foreach ($escolas as $escola) {
        $id = $escola['id'];
        $nome = $escola['nome'];
        $id_moderador = $escola['id_moderador'];

        $stmtModerador = $pdo->prepare("SELECT nome FROM pessoa where id = :id");
        $stmtModerador->bindParam(':id', $id_moderador);
        $stmtModerador->execute();

        $moderador = $stmtModerador->fetchAll(PDO::FETCH_ASSOC);
        $moderador = $moderador[0];
        $nome_moderador = $moderador['nome'];

        echo "<tr><td>$id</td><td>$nome</td><td>$nome_moderador</td> <td><a href='../crud turmas/turma_relatorio.php?id=$id'>turmas</a> <a href='escola_editar.php?id=$id'>editar</a> <a href='proc_escola_excluir.php?id=$id'>excluir</a><td></tr>";
    }
        
    echo "</table><br>";
    }
catch (PDOException $e) {
    echo "Erro ao gerar relatório: " . $e->getMessage();
}
?>

</body>
</html>