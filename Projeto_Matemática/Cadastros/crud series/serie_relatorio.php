<html>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
<link rel="stylesheet" href="../temporario/relatorio.css">
<body>
      <a href="serie_criar.php" style="
        display: inline-block;
        background-color: #2C3E50;
        color:rgb(255, 255, 255);
        padding: 10px 20px;
        text-decoration: none;
        border-radius: 5px;
        font-weight: bold;
        margin-bottom: 20px;
    ">+ Nova serie</a>
    <?php
include_once('../conexao.php');



try {
    

    $stmtSeries = $pdo->prepare("SELECT id, ensino, periodo FROM serie ORDER BY id ASC");
    $stmtSeries->execute();
    $series = $stmtSeries->fetchAll(PDO::FETCH_ASSOC);

    


    echo "<h2>series</h2>";
    echo "<table border='1' cellpadding='8' cellspacing='0'>";
    echo "<tr><th>id</th><th>ensino</th><th>periodo</th></tr>";

    foreach ($series as $serie) {
        $id = $serie['id'];
        $ensino = $serie['ensino'];
        $periodo = $serie['periodo'];

        echo "<tr><td>$id</td><td>$ensino</td><td>$periodo</td> <td><a href='serie_editar.php?id=$id'>editar</a> <a href='proc_serie_excluir.php?id=$id'>excluir</a><td></tr>";
    }
        
    echo "</table><br>";
    }
catch (PDOException $e) {
    echo "Erro ao gerar relatório: " . $e->getMessage();
}
?>
</body>
</html>