<?php

include_once('../Dashboards/Include/connection.php');
header('Content-Type: application/json');


if (isset($_GET['institute_id']) && !empty($_GET['institute_id'])) {
    $instituteCode = $_GET['institute_id'];

    try {
        $sql_turmas = "SELECT id, nome FROM turmas WHERE codigoescola = :code ORDER BY nome ASC";
        $stmt = $pdo->prepare($sql_turmas);
        $stmt->bindParam(':code', $instituteCode, PDO::PARAM_INT);
        $stmt->execute();
        $turmas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($turmas);

    } catch (PDOException $e) {
        
        http_response_code(500);
        
        echo json_encode(['error' => 'Erro interno ao buscar turmas.']);
    }

} else {
    
    http_response_code(400);
    echo json_encode([]);
}
?>