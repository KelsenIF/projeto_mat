<?php
session_start();

include_once('../Dashboards/Include/connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    
    $user = $_POST['user'];
    $name = $_POST['name'];
    $password = $_POST['password'];
    $password_confirm = $_POST['password-confirm'];
    $institution = $_POST['institution'];
    $class = $_POST['class'];
    
 
    $security_question = $_POST['security_question'];
    $security_answer = $_POST['security_answer'];
    
    $foto_caminho = ''; 

   
    if ($password !== $password_confirm) {
        $_SESSION['erro_cadastro'] = "As senhas não coincidem.";
        header("Location: register.php");
        exit();
    }

   
    $stmt = $pdo->prepare("SELECT id FROM cadastros WHERE user = ?");
    $stmt->execute([$user]);
    if ($stmt->rowCount() > 0) {
        $_SESSION['erro_cadastro'] = "Esta matrícula já está cadastrada.";
        header("Location: register.php");
        exit();
    }
    
    
    $target_dir = "uploads/"; 
    
    if (isset($_FILES['imagem_upload']) && $_FILES['imagem_upload']['error'] === UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['imagem_upload']['tmp_name'];
        $file_name_original = basename($_FILES['imagem_upload']['name']);
        $file_extension = strtolower(pathinfo($file_name_original, PATHINFO_EXTENSION));
        $unique_file_name = uniqid('foto_', true) . '.' . $file_extension;
        $target_file = $target_dir . $unique_file_name;
        
        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($file_extension, $allowed_ext)) {
            $_SESSION['erro_cadastro'] = "Formato de arquivo não permitido. Use JPG, PNG ou GIF.";
            header("Location: register.php");
            exit();
        }

        if (move_uploaded_file($file_tmp, $target_file)) {
            $foto_caminho = $target_file; 
        } else {
             $_SESSION['erro_cadastro'] = "Erro interno ao salvar a foto de perfil.";
             header("Location: register.php");
             exit();
        }
    } else {
        if ($_FILES['imagem_upload']['error'] !== UPLOAD_ERR_NO_FILE) {
             $_SESSION['erro_cadastro'] = "Erro no envio da foto: Código do erro (" . $_FILES['imagem_upload']['error'] . ").";
             header("Location: register.php");
             exit();
        }
    }


    
    $encrypted_password = password_hash($password, PASSWORD_DEFAULT);
    
    
    $encrypted_answer = password_hash(strtolower(trim($security_answer)), PASSWORD_DEFAULT); 
    
    
    $sql = "INSERT INTO cadastros (nome, foto, user, instituicao, turma, senha, pergunta_seguranca, resposta_seguranca) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            
    $stmt = $pdo->prepare($sql);

    try {
        $stmt->execute([
            $name, 
            $foto_caminho, 
            $user, 
            $institution, 
            $class, 
            $encrypted_password,
            $security_question,         
            $encrypted_answer           
        ]);
        
        $_SESSION['sucesso_cadastro'] = "Cadastro realizado com sucesso!";
        header("Location: login.php"); 
        exit();
        
    } catch (PDOException $e) {
        if (!empty($foto_caminho) && file_exists($foto_caminho)) {
            unlink($foto_caminho);
        }
        
        $_SESSION['erro_cadastro'] = "Erro ao cadastrar usuário: Verifique se as colunas 'pergunta_seguranca' e 'resposta_seguranca' existem no seu banco de dados.";
        
        header("Location: register.php"); 
        exit();
    }
}
?>