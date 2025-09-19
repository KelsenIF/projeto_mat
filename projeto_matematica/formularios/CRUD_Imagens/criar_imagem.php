<?php include_once('../../Include/connection.php'); ?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Upload de Imagem</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <h2>Enviar Nova Imagem</h2>
    <form action="proc_criar_imagem.php" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label>Selecione a Imagem:</label>
            <input type="file" name="imagem" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Fazer Upload</button>
    </form>
</div>
</body>
</html>
