<?php
include_once('../../Dashboards/Include/connection.php');

$sql = "SELECT * FROM imagens ORDER BY data_upload DESC";
$stmt = $pdo->query($sql);
$imagens = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Listar Imagens</title>
    <style>
        .btn {
            display: inline-block;
            padding: 10px 15px;
            margin: 10px 0;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .btn:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <h1>Imagens</h1>

    <!-- Botão para criar nova imagem -->
    <a href="criar_imagem.php" class="btn">+ Criar Imagem</a>

    <div>
    <?php foreach ($imagens as $img): ?>
        <div style="margin:10px; display:inline-block; text-align:center;">
            <img src="<?= htmlspecialchars($img['caminho_imagem']) ?>" width="150"><br>
            <?= htmlspecialchars($img['nome_imagem']) ?><br>
            <a href="editar_imagem.php?id=<?= $img['id'] ?>">Editar</a> |
            <a href="deletar_imagem.php?id=<?= $img['id'] ?>" onclick="return confirm('Tem certeza?')">Deletar</a>
        </div>
    <?php endforeach; ?>
    </div>

    <?php if (isset($_GET['sucesso']) && $_GET['sucesso'] == 1): ?>
        <script>
            alert("Imagem criada com sucesso!");
        </script>
    <?php endif; ?>
</body>
</html>
