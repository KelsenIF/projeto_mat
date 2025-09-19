<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cadastrar Escola</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        crossorigin="anonymous">
    <script>
        function confirmarEnvio() {
            const nome = document.getElementById("nome").value;
            const idModerador = document.getElementById("id_moderador").value;

            const confirmacao = confirm(
                `Você tem certeza que deseja cadastrar esta escola?\n\n` +
                `Nome: ${nome}\n` +
                `ID do Moderador: ${idModerador}`
            );

            return confirmacao; // Só envia se for true
        }
    </script>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Cadastrar Escola</a>
        </div>
    </nav>

    <div class="container mt-5 pt-5">

        <!-- MENSAGEM DE SUCESSO -->
        <?php if (isset($_GET['sucesso']) && $_GET['sucesso'] == 1): ?>
            <div class="alert alert-success text-center">
                Escola cadastrada com sucesso!
                <div class="mt-3">
                    <a href="create.php" class="btn btn-success">Cadastrar outra escola</a>
                </div>
            </div>
        <?php endif; ?>

        <!-- FORMULÁRIO -->
        <form action="processa.php" method="post" onsubmit="return confirmarEnvio();">
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="nome" class="form-label">Nome da Escola</label>
                    <input type="text" class="form-control" id="nome" name="nome" required>
                </div>
                <div class="col-md-6">
                    <label for="id_moderador" class="form-label">ID do Moderador</label>
                    <input type="number" class="form-control" id="id_moderador" name="id_moderador" required>
                </div>
            </div>
            <div class="mt-4 d-flex gap-3">
                <button class="btn btn-primary" type="submit">Cadastrar escola</button>
                <a href="../index.php" class="btn btn-secondary">Voltar ao Dashboard</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>

</body>
</html>
