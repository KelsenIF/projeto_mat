<?php

require_once('../../DASHBOARDS/include/connection.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
        /* Variáveis de cor (Sincronizadas com o dashboard) */
        :root {
            --neon-blue: #00ffff;
            --neon-magenta: #ff00ff;
            --dark-bg-main: #141421;
            --dark-bg-area: #1a1a2e;
            --item-bg: #22223a;
            --text-color: #e0e0e0;
            --border-color: rgba(0, 255, 255, 0.1);
            --shadow-intensity: 0 0 10px;
        }

        body {
            background-color: var(--dark-bg-main);
            color: var(--text-color);
            font-family: 'Consolas', 'Courier New', monospace;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        h2 {
            color: var(--neon-magenta);
            text-shadow: 0 0 5px var(--neon-magenta);
            margin-bottom: 25px;
            letter-spacing: 1.5px;
        }

        /* Container de Login e Registro */
        .form-neon {
            background-color: var(--dark-bg-area);
            padding: 40px;
            border-radius: 8px;
            border: 1px solid var(--neon-blue);
            box-shadow: var(--shadow-intensity) var(--neon-blue),
                0 0 20px rgba(255, 0, 255, 0.2);
            width: 100%;
            max-width: 450px;
        }

        /* Estilo para Inputs e Selects */
        .form-control {
            background-color: var(--item-bg) !important;
            border: 1px solid var(--neon-blue) !important;
            color: var(--neon-blue) !important;
            box-shadow: 0 0 3px rgba(0, 255, 255, 0.5) !important;
            transition: all 0.2s;
        }

        .form-control::placeholder {
            color: rgba(0, 255, 255, 0.5) !important;
        }

        .form-control:focus {
            background-color: var(--dark-bg-area) !important;
            border-color: var(--neon-magenta) !important;
            box-shadow: 0 0 8px var(--neon-magenta) !important;
        }

        /* Botão Neon */
        .btn-neon {
            --btn-color: var(--neon-magenta);
            background: transparent;
            color: var(--btn-color);
            border: 1px solid var(--btn-color);
            padding: 10px 20px;
            border-radius: 5px;
            box-shadow: 0 0 5px var(--btn-color);
            transition: all 0.3s;
            width: 100%;
            margin-top: 10px;
        }

        .btn-neon:hover {
            background: var(--btn-color);
            color: var(--dark-bg-area);
            box-shadow: 0 0 15px var(--btn-color);
        }

        /* Links */
        .link-neon {
            color: var(--neon-blue) !important;
            text-shadow: 0 0 5px rgba(0, 255, 255, 0.4);
            text-decoration: none;
            font-weight: bold;
            transition: text-shadow 0.2s;
        }

        .link-neon:hover {
            color: var(--neon-magenta) !important;
            text-shadow: 0 0 8px var(--neon-magenta);
        }

        /* Container de links no footer */
        .link-container {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <form class="form-neon" action="proc_login.php" method="POST">
        <h2 class="text-center">LOGIN</h2>

        <div class="mb-3">
            <input type="text" class="form-control" id="cpf" name="cpf" placeholder="CPF:" required>
        </div>

        <div class="mb-3">
            <input type="password" class="form-control" id="senha" name="senha" placeholder="Senha:" required>
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn-neon">Entrar</button>
        </div>

        <div class="link-container">
            <a class="link-neon" href="../REGISTRO/registro.php">CADASTRE-SE</a>
            <a class="link-neon" href="#">PERDEU A SENHA?</a>
        </div>
    </form>

</body>

</html>