<?php

require_once('../../DASHBOARDS/INCLUDE/SISTEMA_BE/connection.php');


const UPLOAD_DIR_FISICO = __DIR__ . '/uploads/';
const UPLOAD_DIR_URL = 'uploads/';


if ($_SERVER["REQUEST_METHOD"] == "POST") {



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


    $sql_check = "SELECT cpf FROM pessoas WHERE cpf = ?";
    $stmt_check = $pdo->prepare($sql_check);
    $stmt_check->execute([$cpf]);

    if ($stmt_check->rowCount() > 0) {
        $_SESSION['erro_cadastro'] = "Erro: O CPF **" . $_POST['cpf'] . "** já está registrado em nosso sistema.";
        header("Location: registro.php");
        exit();
    }

    if (isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] === UPLOAD_ERR_OK) {

        $arquivo_temp = $_FILES['foto_perfil']['tmp_name'];
        $nome_original = $_FILES['foto_perfil']['name'];

        if (!is_dir(UPLOAD_DIR_FISICO)) {
            if (!mkdir(UPLOAD_DIR_FISICO, 0777, true)) {
                $_SESSION['erro_cadastro'] = "Erro Crítico: Não foi possível criar o diretório de uploads.";
                header("Location: registro.php");
                exit();
            }
        }

        $extensao = pathinfo($nome_original, PATHINFO_EXTENSION);
        $novo_nome_arquivo = uniqid('foto_') . '.' . $extensao;

        $caminho_completo_fisico = UPLOAD_DIR_FISICO . $novo_nome_arquivo;
        $caminho_completo_url = UPLOAD_DIR_URL . $novo_nome_arquivo;

        if (move_uploaded_file($arquivo_temp, $caminho_completo_fisico)) {
            $foto_caminho = $caminho_completo_url;
        } else {
            error_log("FALHA MOVE UPLOADED FILE: Destino tentado: " . $caminho_completo_fisico . " | Erro PHP: " . $_FILES['foto_perfil']['error']);
            $_SESSION['aviso_upload'] = "A foto não foi salva no servidor. Verifique permissões/php.ini.";
        }
    }

    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);


    $sql = "INSERT INTO pessoas (nome, email, foto_perfil, cpf, nome_escola, nome_turma, senha, nivel_de_acesso) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $pdo->prepare($sql);


    try {
        $stmt->execute([
            $nome,
            $email,
            $foto_caminho,
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
        if (!empty($caminho_completo_fisico) && file_exists($caminho_completo_fisico)) {
            unlink($caminho_completo_fisico);
        }
    }
}
?>