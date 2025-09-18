<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<?php 
include_once '../conexao.php';
$stmtPessoa = $pdo->prepare("SELECT nome, email, id_perfil, id_turma FROM pessoa where id = :id");
$stmtPessoa->bindParam(':id', $_GET['id']);
$stmtPessoa->execute();

$pessoa = $stmtPessoa->fetchAll(PDO::FETCH_ASSOC);
$pessoa = $pessoa[0];
$pessoa_nome = $pessoa['nome'];
$pessoa_id_perfil = $pessoa['id_perfil'];
$pessoa_id = $_GET['id'];
$pessoa_email = $pessoa['email'];
$pessoa_id_turma = $pessoa['id_turma'];
?>


<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">

        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <h1 class="h3 mb-4 text-gray-800">Editar turma do aluno</h1>

            <form class="row g-3 needs-validation" novalidate method="POST" action="proc_pessoa_editar.php">

    <div class="col-md-4">
        <label for="nome" class="form-label">Nome</label>
        <input type="text" name="nome" class="form-control" id="nome" required disabled <?php echo  "value='$pessoa_nome'"?>>
        <div class="invalid-feedback">
            nome invalido
        </div>
    </div>

    <div class="col-md-4">
        <label for="email" class="form-label">Email</label>
        <input type="email" name="email" class="form-control" id="email" required disabled <?php echo  "value='$pessoa_email'"?>>
        <div class="invalid-feedback">
            email invalido
        </div>
    </div>

    <div class="col-md-4">
        <label for="perfil" class="form-label">perfil(TODO)</label>
        <input type="perfil" name="perfil" class="form-control" id="perfil" required disabled <?php echo  "value='$pessoa_id_perfil'"?>>
        <div class="invalid-feedback">
            erro generico
        </div>
    </div>



    <div class="col-md-3">
        <label for="turma" class="form-label">turma</label>
        <select id="turma" name="turma" class="form-select" required>
            <option value="">Escolha</option>
        <?php

            try {

                $stmtTurmas = $pdo->prepare("SELECT id,ano, id_serie FROM turma where deleted = 0 ORDER BY id ASC");
                $stmtTurmas->execute();
                $turmas = $stmtTurmas->fetchAll(PDO::FETCH_ASSOC);
                foreach ($turmas as $turma) {
                    $id_turma = $turma['id'];
                    $turma_ano = $turma['ano'];
                    $turma_id_serie = $turma['id_serie'];

                    $stmtSerie = $pdo->prepare("SELECT ensino, periodo FROM serie where id = :id");
                    $stmtSerie->bindParam(':id', $turma_id_serie);
                    $stmtSerie->execute();

                    $serie = $stmtSerie->fetchAll(PDO::FETCH_ASSOC);
                    $serie = $serie[0];
                    $ensino_serie = $serie['ensino'];
                    $periodo_serie = $serie['periodo'];
                    $nome_serie = $ensino_serie .  "|" . $periodo_serie;

                    if ($pessoa_id_turma == $id_turma) {
                        echo "<option value='$id_turma' selected>turma do $nome_serie de $turma_ano</option>"; // NOVA COLUNA
                    } else {
                        echo "<option value='$id_turma'>turma do $nome_serie de $turma_ano</option>"; // NOVA COLUNA
                    }
                }

                } catch (PDOException $e) {
                    echo "Erro ao gerar relatório: " . $e->getMessage();
            }
        ?>
        </select>
        <div class="invalid-feedback">
            turma invalido
        </div>
    </div>

    <input type="hidden" name="id" class="form-control" id="id" required <?php echo  "value='$pessoa_id'"?>>

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