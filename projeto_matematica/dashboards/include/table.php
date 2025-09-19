<?php
// Detalhes da conexão com o banco de dados
$servername = "127.0.0.1";
$username = "root"; // Substitua pelo seu nome de usuário do banco de dados
$password = "";   // Substitua pela sua senha do banco de dados
$dbname = "projeto_mat";

// Cria a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Função para obter a contagem de questões com base no ID da situação
function getQuestionCount($conn, $statusId) {
    $sql = "SELECT COUNT(*) AS count FROM questoes WHERE id_situacao = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $statusId);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row['count'];
}

// Obtém as contagens para cada status
$aprovadas_count = getQuestionCount($conn, 1);
$reprovadas_count = getQuestionCount($conn, 0);
$analise_count = getQuestionCount($conn, 2);

// Fecha a conexão com o banco de dados
$conn->close();
?>

<div class="row row-cols-1 row-cols-md-3 g-3">
    <div class="col">
        <div class="card text-white bg-success mb-3">
            <div class="card-header">Questões Aprovadas</div>
            <div class="card-body">
                <p class="card-text">Foram aprovadas <strong><?php echo $aprovadas_count; ?></strong> questões.</p>
                <a href="../../../projeto_matematica/formularios/questao/questoes_aprovadas.php" class="btn btn-dark">Conferir</a>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card text-white bg-danger mb-3">
            <div class="card-header">Questões Reprovadas</div>
            <div class="card-body">
                <p class="card-text">Foram Reprovadas <strong><?php echo $reprovadas_count; ?></strong> questões.</p>
                <a href="../../../projeto_matematica/formularios/questao/questoes_negadas.php" class="btn btn-dark">Conferir</a>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card text-dark bg-warning mb-3">
            <div class="card-header">Questões Aguardando Análise</div>
            <div class="card-body">
                <p class="card-text">Há <strong><?php echo $analise_count; ?></strong> questões aguardando sua análise.</p>
                <a href="../../../projeto_matematica/formularios/questao/questoes_em_analise.php" class="btn btn-dark">Analisar</a>
            </div>
        </div>
    </div>
</div>