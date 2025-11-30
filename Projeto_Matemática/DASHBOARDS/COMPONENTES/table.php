<?php
$servername = "127.0.0.1";
$username = "root"; 
$password = ""; 
$dbname = "projeto_mat";

// Cria a conexão
$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


function getQuestionCount($conn, $statusId) {
    $sql = "SELECT COUNT(*) AS count FROM questoes WHERE id_situacao = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $statusId);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row['count'];
}

$aprovadas_count = getQuestionCount($conn, 1);
$reprovadas_count = getQuestionCount($conn, 0);
$analise_count = getQuestionCount($conn, 2);

$conn->close();
?>
<div class="row row-cols-1 row-cols-md-3 g-3"> <div class="col">
        <div class="card text-white bg-success mb-3">
            <div class="card-header">QUESTÕES - APROVADAS</div>
            <div class="card-body">
                <p class="card-text"> <strong><?php echo $aprovadas_count; ?></strong> Exercícios.</p>
                <a href="../../FORMULÁRIOS/QUESTOES/questoes_aprovadas.php" class="btn btn-dark">Conferir</a>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card text-white bg-danger mb-3">
            <div class="card-header">QUESTÕES - NEGADAS</div>
            <div class="card-body">
                <p class="card-text"><strong><?php echo $reprovadas_count; ?></strong> Exercícios.</p>
                <a href="../../FORMULÁRIOS/QUESTOES/questoes_negadas.php" class="btn btn-dark">Conferir</a>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card text-white bg-warning mb-3">
            <div class="card-header">QUESTÕES - EM ANÁLISE</div>
            <div class="card-body">
                <p class="card-text"><strong><?php echo $analise_count; ?></strong> Exercícios.</p>
                <a href="../../FORMULÁRIOS/QUESTOES/questoes_em_analise.php" class="btn btn-dark">Analisar</a>
            </div>
        </div>
    </div>
</div>