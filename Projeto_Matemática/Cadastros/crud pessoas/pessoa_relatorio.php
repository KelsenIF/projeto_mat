<html>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
<link rel="stylesheet" href="../temporario/relatorio.css">
<body>
    <?php
include_once('../conexao.php');



try {
    

    $stmtPessoas = $pdo->prepare("SELECT id, nome, email FROM pessoa where deleted = 0 and id_turma=:id_turma ORDER BY id ASC");
    $stmtPessoas->bindParam(':id_turma', $_GET['id']);
    $stmtPessoas->execute();
    $pessoas = $stmtPessoas->fetchAll(PDO::FETCH_ASSOC);

    $stmtTurma = $pdo->prepare("SELECT id_escola FROM turma where deleted = 0 and id=:id ORDER BY id ASC");
    $stmtTurma->bindParam(':id', $_GET['id']);
    $stmtTurma->execute();
    $turma = $stmtTurma->fetchAll(PDO::FETCH_ASSOC);
    $turma = $turma[0];
    $escola_id = $turma['id_escola'];

    echo "<h2>Alunos</h2>";
    echo "<table border='1' cellpadding='8' cellspacing='0'>";
    echo "<tr><th>id</th><th>nome</th><th>email</th></tr>";

    foreach ($pessoas as $pessoa) {
        $id = $pessoa['id'];
        $nome = $pessoa['nome'];
        $email = $pessoa['email'];

        echo "<tr><td>$id</td><td>$nome</td><td>$email</td> <td><a href='pessoa_editar.php?id=$id'>mudar turma</a> <a href='proc_pessoa_excluir.php?id=$id'>excluir/remover da turma</a><td></tr>";
    }
        
    echo "</table><br>";
    }
catch (PDOException $e) {
    echo "Erro ao gerar relatório: " . $e->getMessage();
}
?>
<a href="<?php echo "../crud turmas/turma_relatorio.php?id=$escola_id" ?>" style="
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