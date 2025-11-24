<?php
require_once('../../DASHBOARDS/INCLUDE/SISTEMA_BE/connection.php');

session_start();

if ($_POST['action'] == 'CRIAR') {
    // ... (Bloco CRIAR está correto para Turmas)
    $nome_turma = $_POST['nome_turma'] ?? null;
    $cod_inep = $_POST['cod_inep'] ?? null;

    if (empty($nome_turma) || empty($cod_inep)) {
        header("Location: criar_turmas.php");
        exit();
    }

    $sql = "INSERT INTO turmas (nome_turma, cod_inep) VALUES (?, ?)";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nome_turma, $cod_inep]);

        header("Location: listar_turmas.php");
        exit();

    } catch (PDOException $e) {
        header("Location: criar_turmas.php");
        exit();
    }
}

if ($_POST['action'] == 'EDITAR') {
    
    // 🔑 CORREÇÃO 1: Mudar os parâmetros esperados para os campos da TURMA
    $id = $_POST['id'] ?? null;
    $nome_turma = $_POST['nome_turma'] ?? null; // Nome da turma
    $cod_inep = $_POST['cod_inep'] ?? null;     // Código INEP da escola

    
    // Validação
    if (empty($id) || empty($nome_turma) || empty($cod_inep)) {
        // Redireciona com o ID para facilitar a correção no formulário
        $redirect_id = !empty($id) ? "?id=" . urlencode($id) : "";
        header("Location: editar_turmas.php" . $redirect_id . "&erro=dados_faltando");
        exit();
    }

    // 🔑 CORREÇÃO 2: Ajustar a consulta SQL para atualizar as colunas corretas da TURMA
    $sql = "UPDATE turmas SET nome_turma = ?, cod_inep = ? WHERE id = ?";

    try {
        $stmt = $pdo->prepare($sql);
        
        // 🔑 CORREÇÃO 3: Passar os valores na ordem correta: Nome, INEP, ID
        $stmt->execute([$nome_turma, $cod_inep, $id]);

        header("Location: listar_turmas.php?sucesso=edicao");
        exit();

    } catch (PDOException $e) {
        // Você pode logar o erro real aqui: error_log($e->getMessage());
        $redirect_id = !empty($id) ? "?id=" . urlencode($id) : "";
        header("Location: editar_turmas.php" . $redirect_id . "&erro=bd_edicao");
        exit();
    }
}

?>