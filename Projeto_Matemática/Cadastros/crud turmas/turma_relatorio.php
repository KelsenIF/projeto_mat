<html>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
<link rel="stylesheet" href="../temporario/relatorio.css">
<?php
include_once('../conexao.php');

$id_escola = $_GET['id'];
$stmtEscola = $pdo->prepare("SELECT nome FROM escola where deleted = 0 and id = :id ORDER BY id ASC");
$stmtEscola->bindParam(':id', $id_escola);
$stmtEscola->execute();
$escola = $stmtEscola->fetchAll(PDO::FETCH_ASSOC);
$escola = $escola[0];

$nome_escola = $escola['nome'];

?>

<body>
      <a href="<?php echo "turma_criar.php?id=$id_escola" ?>" style="
        display: inline-block;
        background-color: #2C3E50;
        color:rgb(255, 255, 255);
        padding: 10px 20px;
        text-decoration: none;
        border-radius: 5px;
        font-weight: bold;
        margin-bottom: 20px;
    ">+ Nova turma</a>
    <?php
try {
    

    $stmtTurmas = $pdo->prepare("SELECT id, ano, id_serie FROM turma where deleted = 0 and id_escola = :id_escola ORDER BY id ASC");
    $stmtTurmas->bindParam(':id_escola', $id_escola);
    $stmtTurmas->execute();
    $turmas = $stmtTurmas->fetchAll(PDO::FETCH_ASSOC);

    


    echo "<h2>Turmas da escola '$nome_escola'</h2>";
    echo "<table border='1' cellpadding='8' cellspacing='0'>";
    echo "<tr><th>id</th><th>ano</th><th>serie</th></tr>";

    foreach ($turmas as $turma) {
        $id = $turma['id'];
        $ano = $turma['ano'];
        $id_serie = $turma['id_serie'];

        $stmtSerie = $pdo->prepare("SELECT ensino, periodo FROM serie where id = :id");
        $stmtSerie->bindParam(':id', $id_serie);
        $stmtSerie->execute();

        $serie = $stmtSerie->fetchAll(PDO::FETCH_ASSOC);
        $serie = $serie[0];
        $nome_serie = $serie['ensino'] . " | " . $serie['periodo'];

        echo "<tr><td>$id</td><td>$ano</td><td>$nome_serie</td> <td><a href='../crud pessoas/pessoa_relatorio.php?id=$id'>alunos</a> <a href='turma_editar.php?id=$id'>editar</a> <a href='proc_turma_excluir.php?id=$id&escola=$id_escola'>excluir</a><td></tr>";
    }
        
    echo "</table><br>";
    }
catch (PDOException $e) {
    echo "Erro ao gerar relatório: " . $e->getMessage();
}
?>
<a href="<?php echo "../crud escolas/escola_relatorio.php" ?>" style="
        display: inline-block;
        background-color: #2C3E50;
        color:rgb(255, 255, 255);
        padding: 10px 20px;
        text-decoration: none;
        border-radius: 5px;
        font-weight: bold;
        margin-bottom: 20px;
    ">voltar</a>


</body>
</html>