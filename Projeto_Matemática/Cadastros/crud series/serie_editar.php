<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<?php 
include_once '../conexao.php';
$stmtSerie = $pdo->prepare("SELECT ensino, periodo FROM serie where id = :id");
$stmtSerie->bindParam(':id', $_GET['id']);
$stmtSerie->execute();

$serie = $stmtSerie->fetchAll(PDO::FETCH_ASSOC);
$serie = $serie[0];
$serie_ensino = $serie['ensino'];
$serie_periodo = $serie['periodo'];
$serie_id = $_GET['id'];

?>


<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">

        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <h1 class="h3 mb-4 text-gray-800">Editar serie</h1>

    <form class="row g-3 needs-validation" novalidate method="POST" action="proc_serie_editar.php">

    <div class="col-md-4">
        <label for="ensino" class="form-label">Ensino</label>
        <input type="text" name="ensino" class="form-control" id="ensino" required <?php echo  "value='$serie_ensino'"?>>
        <div class="invalid-feedback">
            ensino invalido?
        </div>
    </div>

    <div class="col-md-4">
        <label for="periodo" class="form-label">Periodo</label>
        <input type="text" name="periodo" class="form-control" id="periodo" required <?php echo  "value='$serie_periodo'"?>>
        <div class="invalid-feedback">
            periodo invalido
        </div>
    </div>

    <input type="hidden" name="id" class="form-control" id="id" required <?php echo  "value='$serie_id'"?>>


    <div class="col-12 mt-4">
        <button type="submit" class="btn btn-primary">Editar</button>
    </div>
</form>


        </div>

        <!-- Certifique-se de que estes scripts estão no final da página, antes do fechamento do body -->
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    </div>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
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