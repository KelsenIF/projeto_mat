<?php
include '../include/connection.php';

if (!isset($_GET['id'])) {
    die("ID não informado.");
}

$id = $_GET['id'];

try {
    $stmt = $pdo->prepare("UPDATE pessoa SET deleted = 1 WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    header("Location: index.php?excluido=1");
    exit;
} catch (PDOException $e) {
    die("Erro ao excluir: " . $e->getMessage());
}
?>
