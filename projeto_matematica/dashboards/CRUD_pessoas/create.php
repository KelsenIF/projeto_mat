<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cadastrar Pessoas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        crossorigin="anonymous">
    <script>
        function confirmarEnvio() {
            const nome = document.getElementById("nome").value;
            const email = document.getElementById("email").value;
            const idPerfil = document.getElementById("id_perfil").value;
            const idTurma = document.getElementById("id_turma").value;

            const confirmacao = confirm(
                `Você tem certeza que deseja cadastrar esta pessoa?\n\n` +
                `Nome: ${nome}\n` +
                `Email: ${email}\n` +
                `ID do Perfil: ${idPerfil}\n` +
                `ID da Turma: ${idTurma}`
            );

            return confirmacao;
        }
    </script>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Cadastrar Pessoa</a>
        </div>
    </nav>

    <div class="container mt-5 pt-5">

        <!-- MENSAGEM DE SUCESSO -->
        <?php if (isset($_GET['sucesso']) && $_GET['sucesso'] == 1): ?>
            <div class="alert alert-success text-center">
                Pessoa cadastrada com sucesso!
                <div class="mt-3">
                    <a href="create.php" class="btn btn-success">Cadastrar outra pessoa</a>
                </div>
            </div>
        <?php endif; ?>

        <!-- FORMULÁRIO -->
        <form action="processa.php" method="post" onsubmit="return confirmarEnvio();">
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="nome" class="form-label">Nome</label>
                    <input type="text" class="form-control" id="nome" name="nome" required>
                </div>
                <div class="col-md-6">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="col-md-6">
                    <label for="id_perfil" class="form-label">ID do Perfil</label>
                    <input type="number" class="form-control" id="id_perfil" name="id_perfil" required>
                </div>
                <div class="col-md-6">
                    <label for="id_turma" class="form-label">ID da Turma</label>
                    <input type="number" class="form-control" id="id_turma" name="id_turma" required>
                </div>
            </div>

            <div class="mt-4 d-flex gap-3">
                <button class="btn btn-primary" type="submit">Cadastrar pessoa</button>
                <a href="../index.php" class="btn btn-secondary">Voltar ao Dashboard</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>

</body>
</html>
