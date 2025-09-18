<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Log-in</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body class="bg-light">

    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card shadow p-4">
                <div class="card-header text-center bg-transparent border-0">
                    <h2 class="fw-bold text-primary">ENTRAR</h2>
                </div>
                <div class="card-body">
                    <form action="login_process.php" method="POST">
                        <div class="mb-3">
                            <input type="text" placeholder="Matrícula:" id="user" name="user" class="form-control" required>
                        </div>
                        <div class="mb-4">
                            <input type="password" placeholder="Senha:" id="password" name="password" class="form-control" required>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">Entrar</button>
                        </div>
                        <br>
                        <div class="d-flex justify-content-center">
                            <a class="text-decoration-none" href="register.php">CADASTRE-SE</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>

</html>