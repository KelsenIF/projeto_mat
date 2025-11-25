<?php
session_start();
include_once('connection.php');

if (!isset($_SESSION['cpf_usuario'])) {
    header("Location: ../../USUÁRIO/LOGIN/login.php?erro=2");
    exit();
}

$user_logged = $_SESSION['log_user'];

$sql_username = "SELECT nome FROM cadastros WHERE user = ?";
$stmt_user = $pdo->prepare($sql_username);
$stmt_user->execute([$user_logged]);
$user_data = $stmt_user->fetch(PDO::FETCH_ASSOC);


if ($user_data) {
    $full_name = $user_data['nome'];
} else {
    $full_name = $user_logged;
}
?>