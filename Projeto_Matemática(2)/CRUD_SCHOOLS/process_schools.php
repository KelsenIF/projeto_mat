<?php

require_once('..//Dashboards/Include/connection.php');

try {
    $pdo = new PDO("mysql:host=" . host . ";dbname=" . database_name . ";charset=utf8", user, password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    error_log($e->getMessage());
    die("Erro de conexão com o banco de dados.");
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $nome_escola = htmlspecialchars($_POST['nome_escola']);
    $cod_inep = htmlspecialchars($_POST['cod_inep']);

    $cep = htmlspecialchars($_POST['cep']);
    $rua = htmlspecialchars($_POST['rua']);
    $numero = htmlspecialchars($_POST['numero']);
    $bairro = htmlspecialchars($_POST['bairro']);
    $cidade = htmlspecialchars($_POST['cidade']);
    $estado = htmlspecialchars($_POST['estado']);

    $telefone = htmlspecialchars($_POST['telefone']);
    $email = htmlspecialchars($_POST['email']);

    $tipo_escola = htmlspecialchars($_POST['tipo_escola']);
    $status = htmlspecialchars($_POST['status']);
    
    $etapas_array = [];
    if (isset($_POST['etapa_ensino']) && is_array($_POST['etapa_ensino'])) {
        foreach ($_POST['etapa_ensino'] as $etapa_valor) {
            $etapas_array[] = htmlspecialchars($etapa_valor);
        }
    }
    
    $etapa_ensino_string = implode(', ', $etapas_array);
    
    
    try {
       
        $sql = "INSERT INTO escolas (nome_escola, cod_inep, cep, rua, numero, bairro, cidade, estado, telefone, email, etapa_ensino, tipo_escola, status) VALUES 
        (:nome_escola, :cod_inep, :cep, :rua, :numero, :bairro, :cidade, :estado, :telefone, :email, :etapa_ensino, :tipo_escola, :status)";

        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':nome_escola', $nome_escola, PDO::PARAM_STR);
        $stmt->bindParam(':cod_inep', $cod_inep, PDO::PARAM_STR);
        $stmt->bindParam(':cep', $cep, PDO::PARAM_STR);
        $stmt->bindParam(':rua', $rua, PDO::PARAM_STR);
        $stmt->bindParam(':numero', $numero, PDO::PARAM_STR);
        $stmt->bindParam(':bairro', $bairro, PDO::PARAM_STR);
        $stmt->bindParam(':cidade', $cidade, PDO::PARAM_STR);
        $stmt->bindParam(':estado', $estado, PDO::PARAM_STR);
        $stmt->bindParam(':telefone', $telefone, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        
        
        $stmt->bindParam(':etapa_ensino', $etapa_ensino_string, PDO::PARAM_STR); 
        
        $stmt->bindParam(':tipo_escola', $tipo_escola, PDO::PARAM_STR);
        
        $stmt->bindParam(':status', $status, PDO::PARAM_STR); 

        $stmt->execute();

        header("Location: validate_email.php");
        exit();

    } catch (PDOException $e) {
        error_log("Erro no INSERT da Escola: " . $e->getMessage());
        die("Erro ao Inserir Dados. Por favor, tente novamente.");
    }
} else {
    header("Location: register_schools.php");
    exit();
}