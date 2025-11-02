<?php
include_once('../../Dashboards/Include/connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = intval($_POST["id"]);
    $novoNome = $_POST["nome"];

    // Atualiza nome
    $sql = "UPDATE imagens SET nome_imagem = :nome WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":nome", $novoNome);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();

    // Se enviar nova imagem
    if (isset($_FILES["imagem"]) && $_FILES["imagem"]["error"] == 0) {
        $sql = "SELECT caminho_imagem FROM imagens WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $imgAtual = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($imgAtual && file_exists($imgAtual["caminho_imagem"])) {
            unlink($imgAtual["caminho_imagem"]);
        }

        $diretorio = "uploads/";
        if (!is_dir($diretorio)) {
            mkdir($diretorio, 0777, true);
        }

        $novoCaminho = $diretorio . uniqid() . "_" . basename($_FILES["imagem"]["name"]);
        move_uploaded_file($_FILES["imagem"]["tmp_name"], $novoCaminho);

        $sql = "UPDATE imagens SET caminho_imagem = :caminho WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":caminho", $novoCaminho);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
    }
}

header("Location: listar_imagens.php");
exit;
?>
