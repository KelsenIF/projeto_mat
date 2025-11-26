<?php

require_once('../../DASHBOARDS/include/connection.php');
header('Content-Type: application/json');

if (!isset($pdo)) {
    http_response_code(500);
    echo json_encode(['error' => 'Erro fatal de conexão: $pdo não definida.']);
    exit;
}

if (isset($_GET['cod_inep']) && !empty($_GET['cod_inep'])) {
    $cod_inep = $_GET['cod_inep'];

    try {
        $sql_turmas = "SELECT id, nome_turma AS nome FROM turmas WHERE cod_inep = :cod_inep ORDER BY nome_turma ASC";
        
        $stmt = $pdo->prepare($sql_turmas);
        $stmt->bindParam(':cod_inep', $cod_inep, PDO::PARAM_INT);
        $stmt->execute();
        $turmas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($turmas);

    } catch (PDOException $e) {
        
        http_response_code(500);
        echo json_encode(['error' => 'Erro interno ao buscar turmas: ' . $e->getMessage()]);
    }

} else {
    
    http_response_code(400);
    echo json_encode([]);
}
?>