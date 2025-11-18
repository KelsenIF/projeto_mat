<?php

session_start(); 

include_once('../Dashboards/Include/connection.php');


$sql_institute = "SELECT * FROM escolas ORDER BY id DESC";
$institute = $pdo->prepare($sql_institute);
$institute->execute();
$institutes = $institute->fetchAll(PDO::FETCH_ASSOC);

$perguntas_seguranca = [
    "Qual o nome do seu primeiro animal de estimação?",
    "Qual o nome da rua onde você nasceu?",
    "Qual o seu livro ou filme favorito de infância?",
    "Qual o nome do meio da sua mãe?",
    "Qual a sua comida favorita?",
];


$mensagem_status = '';
$tipo_alerta = '';



if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $matricula = trim($_POST['user'] ?? '');
    $instituicao = trim($_POST['institution'] ?? '');
    $pergunta = trim($_POST['security_question'] ?? '');
    

    $resposta_digitada = strtolower(trim($_POST['security_answer'] ?? '')); 

    if (empty($matricula) || empty($instituicao) || empty($pergunta) || empty($resposta_digitada)) {
        $mensagem_status = "Por favor, preencha todos os campos do formulário.";
        $tipo_alerta = 'warning';
    } else {
       
        $sql = "SELECT id, pergunta_seguranca, resposta_seguranca FROM cadastros 
                WHERE user = :matricula 
                AND instituicao = :instituicao";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':matricula', $matricula);
        $stmt->bindParam(':instituicao', $instituicao);
        $stmt->execute();
        $cadastro = $stmt->fetch(PDO::FETCH_ASSOC);

 
        if ($cadastro) {
            
         
            if ($cadastro['pergunta_seguranca'] === $pergunta) {
                
  
                if (password_verify($resposta_digitada, $cadastro['resposta_seguranca'])) {
                    
                   
                    $_SESSION['recuperacao_id'] = $cadastro['id']; 

               
                    header("Location: recover_password.php");
                    exit();

                } else {

                    $mensagem_status = "A resposta de segurança está incorreta.";
                    $tipo_alerta = 'danger';
                     header("Location: recover_access.php");
                }

            } else {
     
                $mensagem_status = "Dados de segurança (pergunta ou resposta) incorretos.";
                $tipo_alerta = 'danger';
            }
            
        } else {
            
            $mensagem_status = "Cadastro não existe para a Matrícula e Instituição informadas.";
            $tipo_alerta = 'danger';
        }
    }
}
?>
