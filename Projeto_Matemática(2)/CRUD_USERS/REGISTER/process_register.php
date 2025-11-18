<?php
// =========================================================================
// 0. CONFIGURAÇÃO DE DEBUG E SESSÃO
// =========================================================================

// Ativa a exibição de erros (ideal para desenvolvimento, remova em produção)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Inclui a conexão (IMPORTANTE: Mantenha o caminho correto!)
require_once('../../Dashboards/Include/connection.php');

// CRÍTICO: Configura o PDO para lançar exceções em erros de SQL
if (isset($pdo)) {
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} else {
    die("Erro: Variável \$pdo não está definida após o require_once. Verifique a conexão.");
}

// =========================================================================
// 1. CONFIGURAÇÃO DE UPLOAD E CAMINHOS
// =========================================================================

// Caminho FÍSICO onde o arquivo será salvo no servidor. 
// Garante o caminho absoluto para a pasta 'uploads/' (CRÍTICO para move_uploaded_file)
const UPLOAD_DIR_FISICO = __DIR__ . '/uploads/'; 
 
// Caminho LÓGICO que será salvo no BD (URL)
const UPLOAD_DIR_URL = 'uploads/'; 

// =========================================================================


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // --- 2. Coleta e Limpeza de Dados ---
    
    $cpf = preg_replace('/[^0-9]/', '', $_POST['cpf'] ?? ''); 
    $nome = $_POST['nome'] ?? null;
    $email = $_POST['email'] ?? null;
    $senha = $_POST['senha'] ?? null;
    $conf_senha = $_POST['conf_senha'] ?? null;
    $nome_escola = $_POST['nome_escola'] ?? null;
    $turma = $_POST['turma'] ?? null;
    $nivel_de_acesso = $_POST['nivel_de_acesso'] ?? null;
    
    $foto_caminho = ''; 
    $caminho_completo_fisico = null; 

    // --- 3. Validações Iniciais ---
    
    // ... (Validações de senha, CPF duplicado e tamanho do CPF) ...
    // Deixei fora para focar no upload e BD, mas elas devem estar aqui.


    // --- 4. Upload de Arquivo (FINAL) ---

    if (isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] === UPLOAD_ERR_OK) {

        $arquivo_temp = $_FILES['foto_perfil']['tmp_name'];
        $nome_original = $_FILES['foto_perfil']['name']; 
        
        // Garante que o diretório físico existe
        if (!is_dir(UPLOAD_DIR_FISICO)) {
            if (!mkdir(UPLOAD_DIR_FISICO, 0777, true)) {
                 $_SESSION['erro_cadastro'] = "Erro Crítico: Não foi possível criar o diretório de uploads.";
                 header("Location: register.php");
                 exit();
            }
        }
        
        $extensao = pathinfo($nome_original, PATHINFO_EXTENSION);
        $novo_nome_arquivo = uniqid('foto_') . '.' . $extensao;
        
        $caminho_completo_fisico = UPLOAD_DIR_FISICO . $novo_nome_arquivo; 
        $caminho_completo_url = UPLOAD_DIR_URL . $novo_nome_arquivo;

        // Tenta mover o arquivo
        if (move_uploaded_file($arquivo_temp, $caminho_completo_fisico)) {
            $foto_caminho = $caminho_completo_url; // CAMINHO PARA O BD!
        } else {
            // Se falhar o upload (quase sempre permissão de pasta ou limite de arquivo no php.ini)
            error_log("FALHA MOVE UPLOADED FILE: Destino tentado: " . $caminho_completo_fisico . " | Erro PHP: " . $_FILES['foto_perfil']['error']);
            $_SESSION['aviso_upload'] = "A foto não foi salva no servidor. Verifique permissões/php.ini.";
        }
    }
    
    // --- 5. Hashing e Inserção no Banco de Dados ---
    
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
    
    // **COLUNAS:** (nome, email, foto_perfil, cpf, nome_escola, nome_turma, senha, nivel_de_acesso) 
    $sql = "INSERT INTO pessoas (nome, email, foto_perfil, cpf, nome_escola, nome_turma, senha, nivel_de_acesso) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            
    $stmt = $pdo->prepare($sql);

    
    try {
        $stmt->execute([
            $nome,
            $email,
            $foto_caminho, // Se o upload funcionou, este é o caminho 'uploads/foto_...'
            $cpf,          
            $nome_escola,
            $turma,
            $senha_hash,
            $nivel_de_acesso
        ]);

        $_SESSION['sucesso_cadastro'] = "Cadastro realizado com sucesso!";
        header("Location: ..\LOGIN\login.php");
        exit();

    } catch (PDOException $e) {
        // Tenta excluir a foto que foi salva no disco, caso o erro seja no BD
        if (!empty($caminho_completo_fisico) && file_exists($caminho_completo_fisico)) {
            unlink($caminho_completo_fisico); 
        }

        // AGORA SABEREMOS O ERRO DO BD:
        echo "<h1>ERRO CRÍTICO NO BANCO DE DADOS:</h1>";
        echo "<p>Causa provável: Nome de coluna errado ou tipo de dado incorreto (ex: Coluna 'foto_perfil' muito curta).</p>";
        die("Detalhes Técnicos do BD: " . $e->getMessage());
    }
}
?>