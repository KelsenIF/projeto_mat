<?php
session_start();

include_once('../Include/connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $entry_user = $_POST['user'];
    $entry_password = $_POST['password'];

    
    $stmt = $pdo->prepare("SELECT senha FROM cadastros WHERE user = ?");
    $stmt->execute([$entry_user]);
    $user_data = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user_data) {
        $password_hash = $user_data['senha'];

        if (password_verify($entry_password, $password_hash)) {
            $_SESSION['log_user'] = $entry_user;
            header("Location: ../Dashboards/index.php");
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