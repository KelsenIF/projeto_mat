<?php
include_once('../../Include/connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["imagem"])) {
    $nomeImagem = $_FILES["imagem"]["name"];
    $tmpName = $_FILES["imagem"]["tmp_name"];
    $diretorio = "uploads/";

    if (!is_dir($diretorio)) {
        mkdir($diretorio, 0777, true);
    }

    $caminhoFinal = $diretorio . uniqid() . "_" . basename($nomeImagem);

    if (move_uploaded_file($tmpName, $caminhoFinal)) {
        try {
            $sql = "INSERT INTO imagens (nome_imagem, caminho_imagem) VALUES (:nome, :caminho)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":nome", $nomeImagem);
            $stmt->bindParam(":caminho", $caminhoFinal);
            $stmt->execute();

            // Redireciona com flag de sucesso
            header("Location: listar_imagens.php?sucesso=1");
            exit;
        } catch (PDOException $e) {
            die("Erro ao salvar no banco: " . $e->getMessage());
        }
    } else {
        die("Erro ao mover o arquivo!");
    }
} else {
    die("Requisição inválida!");
}
?>
