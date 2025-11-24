<?php
require_once('../../DASHBOARDS/INCLUDE/SISTEMA_BE/connection.php');

session_start();

if ($_POST['action'] == 'CRIAR') {

    $disciplina = $_POST['disciplina'] ?? null;
    $id_escolaridade = $_POST['id_escolaridade'] ?? null;

    if (empty($disciplina) || empty($id_escolaridade)) {
        header("Location: criar_disciplinas.php");
        exit();
    }

    $sql = "INSERT INTO disciplinas (disciplina, id_escolaridade) VALUES (?, ?)";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$disciplina, $id_escolaridade]);

        header("Location: listar_disciplinas.php");
        exit();

    } catch (PDOException $e) {
        header("Location: criar_disciplinas.php");
        exit();
    }
}

if ($_POST['action'] == 'EDITAR') {
    
    $id = $_POST['id'] ?? null;
    $disciplina = $_POST['disciplina'] ?? null;
    $id_escolaridade = $_POST['id_escolaridade'] ?? null;

    
    if (empty($id) || empty($disciplina) || empty($id_escolaridade)) {
        header("Location: listar_disciplinas.php?erro=dados_faltando");
        exit();
    }

    $sql = "UPDATE disciplinas SET disciplina = ?, id_escolaridade = ? WHERE id = ?";

    try {
        $stmt = $pdo->prepare($sql);
        
        $stmt->execute([$disciplina, $id_escolaridade, $id]);

        header("Location: listar_disciplinas.php?sucesso=edicao");
        exit();

    } catch (PDOException $e) {
        header("Location: listar_disciplinas.php?erro=bd_edicao");
        exit();
    }
}

?>