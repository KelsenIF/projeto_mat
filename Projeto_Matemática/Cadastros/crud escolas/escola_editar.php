<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<?php 
include_once '../conexao.php';
$stmtEscola = $pdo->prepare("SELECT nome, id_moderador FROM escola where id = :id");
$stmtEscola->bindParam(':id', $_GET['id']);
$stmtEscola->execute();

$escola = $stmtEscola->fetchAll(PDO::FETCH_ASSOC);
$escola = $escola[0];
$escola_nome = $escola['nome'];
$escola_id_moderador = $escola['id_moderador'];
$escola_id = $_GET['id'];

?>


<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">

        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <h1 class="h3 mb-4 text-gray-800">Editar escola</h1>

            <form class="row g-3 needs-validation" novalidate method="POST" action="proc_escola_editar.php">

    <div class="col-md-4">
        <label for="nome" class="form-label">Nome</label>
        <input type="text" name="nome" class="form-control" id="nome" required <?php echo  "value='$escola_nome'"?>>
        <div class="invalid-feedback">
            nome invalido
        </div>
    </div>



    <div class="col-md-2">
        <label for="moderador" class="form-label">Moderador</label>
        <select id="moderador" name="moderador" class="form-select" required>
            <option value="">Escolha</option>
        <?php

            try {

                $stmtpessoas = $pdo->prepare("SELECT id, nome FROM pessoa where deleted = 0 ORDER BY id ASC");
                $stmtpessoas->execute();
                $pessoas = $stmtpessoas->fetchAll(PDO::FETCH_ASSOC);
                foreach ($pessoas as $pessoa) {
                    $id_pessoa = $pessoa['id'];
                    $nome_pessoa = $pessoa['nome'];
                    if ($escola_id_moderador == $id_pessoa) {
                        echo "<option value='$id_pessoa' selected>$nome_pessoa</option>"; // NOVA COLUNA
                    } else {
                        echo "<option value='$id_pessoa'>$nome_pessoa</option>"; // NOVA COLUNA
                    }
                }

                } catch (PDOException $e) {
                    echo "Erro ao gerar relatório: " . $e->getMessage();
            }
        ?>
        </select>
        <div class="invalid-feedback">
            moderador invalido
        </div>
    </div>

    <input type="hidden" name="id" class="form-control" id="id" required <?php echo  "value='$escola_id'"?>>


    <div class="col-12 mt-4">
        <button type="submit" class="btn btn-primary">Cadastrar</button>
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