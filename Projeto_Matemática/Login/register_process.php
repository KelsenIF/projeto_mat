<?php
session_start();
include_once('../Include/connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['user'];
    $name = $_POST['name'];
    $password = $_POST['password'];
    $password_confirm = $_POST['password-confirm'];
    $institution = $_POST['institution'];
    $class = $_POST['class'];

    if ($password !== $password_confirm) {
        $_SESSION['erro_cadastro'] = "As senhas não coincidem.";
        header("Location: register.php");
        echo "<script>";
        echo "alert('Senhas diferentes!');";
        echo "</script>";
        exit();
    }

    $stmt = $pdo->prepare("SELECT id FROM cadastros WHERE user = ?");
    $stmt->execute([$user]);
    if ($stmt->rowCount() > 0) {
        $_SESSION['erro_cadastro'] = "Este e-mail já está cadastrado.";
        header("Location: register.php");
        echo "<script>";
        echo "alert('Email já cadastrado!');";
        echo "</script>";
        exit();
    }

    $encrypted_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO cadastros (nome, user, instituicao, turma, senha) VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);

    try {
        $stmt->execute([$name, $user, $institution, $class, $encrypted_password]);
        $_SESSION['sucesso_cadastro'] = "Cadastro realizado com sucesso! Agora você pode fazer o login.";
        header("Location: login.php");
        echo "<script>";
    echo "alert('Usuário cadastrado com sucesso!');";
    echo "</script>";
        exit();
    } catch (PDOException $e) {
        $_SESSION['erro_cadastro'] = "Erro ao cadastrar usuário: " . $e->getMessage();
        header("Location: register.php");
        echo "<script>";
        echo "alert('Usuário não cadastrado!');";
        echo "</script>";
        exit();
    }
}
?>