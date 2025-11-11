<?php
session_start();

include_once('../../Include/connection.php'); 


if ($_SERVER["REQUEST_METHOD"] != "POST") {
   
    header("Location: ../../Alunos/index.php?status=error&msg=Acesso_Invalido");
    exit();
}


$aluno_id = $_POST['aluno_id'] ?? null;

if (!$aluno_id || !is_numeric($aluno_id)) {
    header("Location: ../../Dashboards/Alunos/index.php?status=error&msg=ID_Invalido");
    exit();
}


$matricula              = trim($_POST['matricula'] ?? '');
$nome                   = trim($_POST['nome'] ?? '');
$pergunta_seguranca     = trim($_POST['pergunta_seguranca'] ?? ''); 
$resposta_seguranca     = trim($_POST['resposta_seguranca'] ?? ''); 
$instituicao_codigo     = trim($_POST['instituicao_codigo'] ?? '');
$turma_id               = trim($_POST['turma_id'] ?? '');


$update_fields = [
    'user'                  => $matricula,
    'nome'                  => $nome,
    'pergunta_seguranca'    => $pergunta_seguranca, 
    'instituicao'           => $instituicao_codigo,
    'turma'                 => $turma_id
];


if (!empty($resposta_seguranca)) {
 
    $hashed_resposta = password_hash(strtolower($resposta_seguranca), PASSWORD_DEFAULT);
    $update_fields['resposta_seguranca'] = $hashed_resposta;
}



$set_clauses = [];
$update_params = [];

foreach ($update_fields as $field => $value) {

    $set_clauses[] = "$field = :$field";
    $update_params[":$field"] = $value;
}


$update_params[':aluno_id'] = $aluno_id;

$sql_update = "UPDATE cadastros SET " . implode(', ', $set_clauses) . " WHERE id = :aluno_id";


try {
   
    $stmt_update = $pdo->prepare($sql_update);
    $success = $stmt_update->execute($update_params);


    if ($success && isset($_FILES['imagem_upload']) && $_FILES['imagem_upload']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = '../../uploads/';
        
        
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $file_ext = pathinfo($_FILES['imagem_upload']['name'], PATHINFO_EXTENSION);
       
        $new_file_name = 'user_' . $aluno_id . '_' . time() . '.' . $file_ext; 
        $upload_file = $upload_dir . $new_file_name;

        if (move_uploaded_file($_FILES['imagem_upload']['tmp_name'], $upload_file)) {
          
            $sql_img = "UPDATE cadastros SET foto = ? WHERE id = ?";
            $stmt_img = $pdo->prepare($sql_img);
            $stmt_img->execute([$new_file_name, $aluno_id]);
            
           
            $_SESSION['user_photo_path'] = $new_file_name; 
        }
    }
    
 
    $_SESSION['status_msg'] = "Cadastro atualizado com sucesso!";
    $_SESSION['status_type'] = "success";
    header("Location: ../../Alunos/perfil.php"); 
    exit();

} catch (PDOException $e) {

    $error_msg = "Erro ao salvar alterações. Matrícula já pode existir ou erro no banco.";
    

    if (strpos($e->getMessage(), 'Integrity constraint violation') !== false) {
        $error_msg = "Erro: A matrícula '{$matricula}' já está em uso por outro usuário.";
    }

    $_SESSION['status_msg'] = $error_msg;
    $_SESSION['status_type'] = "danger";
    
    header("Location: edit_registration.php?id={$aluno_id}");
    exit();
}
?>