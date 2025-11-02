<?php

session_start();

include_once('../Dashboards/Include/connection.php');

$mensagem_status = '';
$tipo_alerta = '';


if (!isset($_SESSION['recuperacao_id'])) {
    
    header("Location: recover_access.php");
    exit();
}

$user_id = $_SESSION['recuperacao_id'];



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $nova_senha = $_POST['nova_senha'] ?? '';
    $confirma_senha = $_POST['confirma_senha'] ?? '';

    if (empty($nova_senha) || empty($confirma_senha)) {
        $mensagem_status = "Por favor, preencha ambos os campos de senha.";
        $tipo_alerta = 'warning';
    } elseif ($nova_senha !== $confirma_senha) {
        $mensagem_status = "As senhas não coincidem. Digite novamente.";
        $tipo_alerta = 'danger';
    } elseif (strlen($nova_senha) < 6) {
        $mensagem_status = "A nova senha deve ter pelo menos 6 caracteres.";
        $tipo_alerta = 'danger';
    } else {
        
        $senha_hashed = password_hash($nova_senha, PASSWORD_DEFAULT);

        $sql_update = "UPDATE cadastros SET senha = :senha WHERE id = :id";
        $stmt_update = $pdo->prepare($sql_update);
        $stmt_update->bindParam(':senha', $senha_hashed);
        $stmt_update->bindParam(':id', $user_id);

        if ($stmt_update->execute()) {
          
            $mensagem_status = "Senha atualizada com sucesso! Você já pode fazer login.";
            $tipo_alerta = 'success';

           
            unset($_SESSION['recuperacao_id']);

            
            header("Refresh: 5; URL=login.php");
        } else {
            $mensagem_status = "Erro ao atualizar a senha no banco de dados. Tente novamente.";
            $tipo_alerta = 'danger';
        }
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Trocar Senha</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-5">
                <div class="card shadow-lg p-4">
                    <div class="card-body">
                        <h1 class="card-title text-center mb-4">Nova Senha 🔑</h1>
                        <p class="text-center text-muted mb-4">Defina sua nova senha. Mínimo 6 caracteres.</p>

                        <?php if ($mensagem_status): ?>
                            <div class="alert alert-<?php echo $tipo_alerta; ?> text-center" role="alert">
                                <?php echo htmlspecialchars($mensagem_status); ?>
                                <?php if ($tipo_alerta == 'success')
                                    echo '<br>Redirecionando para o login...'; ?>
                            </div>
                        <?php endif; ?>

                        <?php if (!($tipo_alerta == 'success')): ?>
                            <form action="" method="POST">
                                <div class="mb-3">
                                    <label for="nova_senha" class="form-label">Nova Senha</label>
                                    <input type="password" id="nova_senha" name="nova_senha" class="form-control"
                                        placeholder="Digite a nova senha" required minlength="6">
                                </div>

                                <div class="mb-4">
                                    <label for="confirma_senha" class="form-label">Confirme a Senha</label>
                                    <input type="password" id="confirma_senha" name="confirma_senha" class="form-control"
                                        placeholder="Confirme a nova senha" required minlength="6">
                                </div>

                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-success btn-lg">Alterar Senha</button>
                                </div>
                            </form>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
        </script>
</body>

</html>