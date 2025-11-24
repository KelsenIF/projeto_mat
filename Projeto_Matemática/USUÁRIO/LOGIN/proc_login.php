<?php
require_once('../../DASHBOARDS/INCLUDE/SISTEMA_BE/connection.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $log_cpf = trim($_POST['cpf'] ?? '');
    $log_senha = $_POST['senha'] ?? '';

    $stmt = $pdo->prepare("SELECT id, nome, foto_perfil, senha, nivel_de_acesso FROM pessoas WHERE cpf = ?");
    $stmt->execute([$log_cpf]);
    $info_user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($info_user) {
        $senha_hash = $info_user['senha'];

        if (password_verify($log_senha, $senha_hash)) {

            
            $_SESSION['id_usuario'] = $info_user['id'];
            $_SESSION['cpf_usuario'] = $log_cpf;
            $_SESSION['nome_usuario'] = $info_user['nome'];
            $_SESSION['caminho_foto_de_perfil'] = $info_user['foto_perfil']; 
            $_SESSION['nivel_de_acesso'] = $info_user['nivel_de_acesso'];
            header("Location: ../../DASHBOARDS/ALUNOS/index.php");
            exit();

        } else {
            $_SESSION['erro_login'] = "Usuário ou senha inválidos.";
            header("Location: login.php");
            exit();
        }
    } else {
        $_SESSION['erro_login'] = "Usuário ou senha inválidos.";
        header("Location: login.php");
        exit();
    }
}
?>