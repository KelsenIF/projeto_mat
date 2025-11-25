<?php
// 1. CONFIGURAÇÃO INICIAL E SESSÃO
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Inclui a conexão PDO.
// 🚨 CAMINHO DE CONEXÃO CORRIGIDO
require_once('../../DASHBOARDS/include/connection.php'); 

// Redireciona se não for um método POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: perfil.php');
    exit;
}

// 2. VERIFICAÇÃO DE ID E SESSÃO
$aluno_id = $_POST['aluno_id'] ?? null;

if (!$aluno_id || !is_numeric($aluno_id)) {
    $_SESSION['error_message'] = "Erro de segurança. ID do usuário inválido.";
    header('Location: perfil.php'); 
    exit;
}

// Caminho de upload (dentro da pasta User_Registration/uploads)
// Assumindo que o `editar_perfil_process.php` está em User_Registration/paginas/perfil
$upload_dir_base = realpath(__DIR__ . '/../'); 
$upload_dir_name = 'uploads/';
$upload_dir_full = $upload_dir_base . '/' . $upload_dir_name;

$new_photo_path = null;
$error_message = null;

try {
    // 3. PROCESSAMENTO DA IMAGEM
    if (isset($_FILES['imagem_upload']) && $_FILES['imagem_upload']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['imagem_upload'];
        $file_name = $file['name'];
        $file_tmp = $file['tmp_name'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];

        if (!is_dir($upload_dir_full)) {
            mkdir($upload_dir_full, 0777, true);
        }

        if (in_array($file_ext, $allowed_ext)) {
            $new_file_name = 'foto_' . uniqid() . '.' . $file_ext;
            // Cria o caminho completo para mover o arquivo no servidor
            $destination = $upload_dir_full . $new_file_name;
            
            // Cria o caminho que será salvo no banco (relativo à pasta User_Registration)
            $new_photo_path = $upload_dir_name . $new_file_name;

            // Move o arquivo
            if (move_uploaded_file($file_tmp, $destination)) {
                
                // 3.1. REMOVER FOTO ANTIGA
                // Busca o caminho da foto antiga
                $stmt_old_photo = $pdo->prepare("SELECT foto_perfil FROM pessoas WHERE id = :id");
                $stmt_old_photo->bindParam(':id', $aluno_id, PDO::PARAM_INT);
                $stmt_old_photo->execute();
                $old_photo_path_db = $stmt_old_photo->fetchColumn();

                if ($old_photo_path_db && $old_photo_path_db !== $new_photo_path) {
                    // Monta o caminho real do arquivo antigo no servidor
                    $full_old_path = $upload_dir_base . '/' . $old_photo_path_db;
                    // Verifica se o arquivo existe e está no diretório de uploads
                    if (file_exists($full_old_path) && strpos($old_photo_path_db, $upload_dir_name) === 0) {
                        unlink($full_old_path); // Apaga o arquivo antigo
                    }
                }
            } else {
                throw new Exception("Falha ao mover o arquivo de upload.");
            }
        } else {
            throw new Exception("Tipo de arquivo não permitido. Use JPG, JPEG, PNG ou GIF.");
        }
    }

    // 4. COLETA E VALIDAÇÃO DOS DADOS DO FORMULÁRIO
    $nome = trim($_POST['nome'] ?? '');
    $instituicao_codigo = trim($_POST['instituicao_codigo'] ?? ''); // É o cod_inep
    $turma_id = trim($_POST['turma_id'] ?? '');

    if (empty($nome) || empty($instituicao_codigo) || empty($turma_id)) {
        throw new Exception("Por favor, preencha todos os campos obrigatórios.");
    }

    // 5. ATUALIZAÇÃO DO BANCO DE DADOS (Tabela 'pessoas')
    $fields = [];
    $params = [':id' => $aluno_id];

    // Atualiza o NOME
    $fields[] = "nome = :nome";
    $params[':nome'] = $nome;

    // Atualiza a INSTITUIÇÃO (nome_escola)
    $fields[] = "nome_escola = :nome_escola";
    $params[':nome_escola'] = $instituicao_codigo; 

    // Atualiza a TURMA (nome_turma)
    $fields[] = "nome_turma = :nome_turma";
    $params[':nome_turma'] = $turma_id;

    // Atualiza a FOTO
    if ($new_photo_path) {
        $fields[] = "foto_perfil = :foto_perfil";
        $params[':foto_perfil'] = $new_photo_path;
    }

    // ⚠️ OBS: Campos `matricula`, `pergunta_seguranca` e `resposta_seguranca` 
    // foram ignorados no UPDATE, pois não existem na tabela `pessoas` do seu dump SQL.

    // Constrói a query de UPDATE
    $sql_update = "UPDATE pessoas SET " . implode(', ', $fields) . " WHERE id = :id";
    
    $stmt = $pdo->prepare($sql_update);
    $stmt->execute($params);


    // 6. SUCESSO E REDIRECIONAMENTO
    $_SESSION['success_message'] = "Perfil atualizado com sucesso!";
    
    header('Location: perfil.php');
    exit;

} catch (PDOException $e) {
    $error_message = "Erro ao atualizar no banco de dados: " . $e->getMessage();
    error_log("Erro no processamento de edição: " . $e->getMessage());
} catch (Exception $e) {
    $error_message = $e->getMessage();
}

// 7. TRATAMENTO DE ERROS
if ($error_message) {
    $_SESSION['error_message'] = $error_message;
    // Redireciona de volta para a tela de edição em caso de erro
    header('Location: editar_perfil.php'); 
    exit;
}
?>