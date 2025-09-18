<?php
// Conecta ao banco de dados
include '../include/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $id_moderador = $_POST['id_moderador'] ?? '';

    if (!empty($nome) && is_numeric($id_moderador)) {
        try {
            $sql = "INSERT INTO escola (nome, id_moderador, deleted) VALUES (:nome, :id_moderador, 0)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':id_moderador', $id_moderador, PDO::PARAM_INT);

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
