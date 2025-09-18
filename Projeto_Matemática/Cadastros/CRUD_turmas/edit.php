<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EDIT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <?php
    include_once '../include/connection.php';
    $stmtTurma = $pdo->prepare("SELECT id, ano, id_serie, id_escola FROM turma where id = :id");
    $stmtTurma->bindParam(':id', $_GET['id']);
    $stmtTurma->execute();

    $turma = $stmtTurma->fetchAll(PDO::FETCH_ASSOC);
    $turma = $turma[0];
    $turma_ano = $turma['ano'];
    $turma_id_escola = 1; //link
    $turma_id = $_GET['id'];
    $turma_id_serie = $turma['id_serie'];
    ?>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">CREATE</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>

    <div class="container mt-4 pt-5">
        <form class="row g-3 needs-validation" novalidate method="POST" action="action.php">

            <div class="col">
                <label for="ano" class="form-label">Ano</label>
                <input type="number" name="ano" min="1900" max="2099" step="1" class="form-control" id="ano" required
                    <?php echo "value='$turma_ano'" ?>>
                <div class="invalid-feedback">
                    ano invalido
                </div>
            </div>



            <div class="col">
                <label for="serie" class="form-label">Serie</label>
                <select id="serie" name="serie" class="form-select" required>
                    <option value="">Escolha</option>
                    <?php include_once '../include/connection.php';

                    try {

                        $stmtseries = $pdo->prepare("SELECT id, ensino, periodo FROM serie ORDER BY id ASC");
                        $stmtseries->execute();
                        $series = $stmtseries->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($series as $serie) {
                            $id_serie = $serie['id'];
                            $ensino_serie = $serie['ensino'];
                            $periodo_serie = $serie['periodo'];

                            if ($turma_id_serie == $id_serie) {
                                echo "<option value='$id_serie' selected>$ensino_serie | $periodo_serie</option>";
                            } else {
                                echo "<option value='$id_serie'>$ensino_serie | $periodo_serie</option>";
                            }
                        }

                    } catch (PDOException $e) {
                        echo "Erro ao gerar relatório: " . $e->getMessage();
                    }
                    ?>
                </select>
                <div class="invalid-feedback">
                    serie invalida
                </div>
            </div>

            <input type="hidden" name="escola" class="form-control" id="escola" required <?php echo "value='$turma_id_escola'" ?>>

            <input type="hidden" name="id" class="form-control" id="id" required <?php echo "value='$turma_id'" ?>>


            <div class="d-grid gap-2">
                <button type="submit" name="action" value="edit" class="btn btn-primary">Editar</button>
            </div>
        </form>
    </div>

    <!-- Certifique-se de que estes scripts estão no final da página, antes do fechamento do body -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
    <script>
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (() => {
            'use strict'

            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            const forms = document.querySelectorAll('.needs-validation')

            // Loop over them and prevent submission
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }

                    form.classList.add('was-validated')
                }, false)
            })
        })()
    </script>
    </script>
</body>