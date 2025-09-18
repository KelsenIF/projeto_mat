<?php
// Conecta ao banco de dados
include '../include/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $id_perfil = $_POST['id_perfil'] ?? '';
    $id_turma = $_POST['id_turma'] ?? '';

    // Verifica se os dados são válidos
    if (!empty($nome) && !empty($email) && is_numeric($id_perfil) && is_numeric($id_turma)) {
        try {
            $sql = "INSERT INTO pessoa (nome, email, id_perfil, id_turma, deleted) VALUES (:nome, :email, :id_perfil, :id_turma, 0)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':id_perfil', $id_perfil, PDO::PARAM_INT);
            $stmt->bindParam(':id_turma', $id_turma, PDO::PARAM_INT);

            if ($stmt->execute()) {
                header("Location: create.php?sucesso=1");
                exit;
            } else {
                echo "Erro ao inserir os dados.";
            }
        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
        }
    } else {
        echo "Dados inválidos.";
    }
} else {
    echo "Requisição inválida.";
}
?>
