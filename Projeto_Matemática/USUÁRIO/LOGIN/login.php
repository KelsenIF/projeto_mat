<?php

require_once('../../DASHBOARDS/include/connection.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN</title>
</head>

<body>
    <form class="" action="proc_login.php" method="POST">
        <div class="">
            <input type="text" class="" id="cpf" name="cpf" placeholder="CPF:" required>
        </div>

        <div class="">
            <input type="password" class="" id="senha" name="senha" placeholder="Senha:" required>
        </div>

        <div class="">
            <button type="submit" class="">Entrar</button>
        </div>
        <div class="">
            <a class="text-decoration-none" href="../REGISTRO/registro.php">CADASTRE-SE</a>
            <a class="text-decoration-none" href="#">PERDEU A SENHA?</a>
        </div>
    </form>

</body>

</html>