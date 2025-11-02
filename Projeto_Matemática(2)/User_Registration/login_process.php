<?php
session_start();

include_once('../Dashboards/Include/connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $entry_user = trim($_POST['user'] ?? '');
    $entry_password = $_POST['password'] ?? '';


    $stmt = $pdo->prepare("SELECT id, senha, nome, foto FROM cadastros WHERE user = ?");
    $stmt->execute([$entry_user]);
    $user_data = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user_data) {
        $password_hash = $user_data['senha'];


        if (password_verify($entry_password, $password_hash)) {
            
         
            $_SESSION['user_id'] = $user_data['id'];                
            $_SESSION['log_user'] = $entry_user;                    
            
      
            $_SESSION['user_name'] = $user_data['nome'];            
            $_SESSION['user_photo_path'] = $user_data['foto']; 
            

            header("Location: ../Dashboards/Alunos/index.php");
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