<?php

// INÍCIO DO BLOCO DE TRATAMENTO DA FOTO
// IMPORTANTE: session_start() deve ser chamado no arquivo principal que inclui este sidebar.

$nivel_acesso = $_SESSION['nivel_de_acesso'] ?? 0;

// Puxando o nome e o caminho da foto da SESSÃO, conforme definido no proc_login.php
$nome_usuario = $_SESSION['nome_usuario'] ?? 'Usuário Desconhecido';
$foto_perfil_bd = $_SESSION['caminho_foto_de_perfil'] ?? ''; 

// CORREÇÃO DO CAMINHO RELATIVO:
// O prefixo '../../' é necessário para sair da pasta atual (ex: DASHBOARDS/ALUNOS/) 
// e alcançar o diretório 'uploads/' na raiz do projeto, onde o arquivo de foto está.
$caminho_base_relativo = '../../'; 

// Constrói o caminho completo da foto
if (!empty($foto_perfil_bd)) {
    // Exemplo de caminho final: '../../uploads/foto_6925ddf10a212.png'
    $caminho_foto_exibicao = $caminho_base_relativo . $foto_perfil_bd;
} else {
    // Caso a foto não esteja na base, defina um caminho para uma imagem padrão.
    // AJUSTE 'assets/default.png' para o caminho real da sua imagem padrão
    $caminho_foto_exibicao = $caminho_base_relativo . 'assets/default.png'; 
}

// URL para o perfil
$url_perfil = '../../USUÁRIO/PERFIL/perfil.php';

// FIM DO BLOCO DE TRATAMENTO DA FOTO
?>
<div class="sidebar border border-right col-md-3 col-lg-2 p-0 bg-body-tertiary">
    <div class="offcanvas-md offcanvas-end bg-body-tertiary" tabindex="-1" id="sidebarMenu"
        aria-labelledby="sidebarMenuLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="sidebarMenuLabel">
                Company name
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#sidebarMenu"
                aria-label="Close"></button>
        </div>
        <div class="offcanvas-body d-md-flex flex-column p-0 pt-lg-3 overflow-y-auto " style="height: 600px;">

            <a href="<?php echo $url_perfil; ?>" class="text-decoration-none text-reset d-block">
                <div class="p-3 text-center mb-3 border-bottom">
                    
                    <h5 class="fw-bold fs-6 text-truncate" title="<?php echo htmlspecialchars($nome_usuario); ?>">
                        <?php echo htmlspecialchars($nome_usuario); ?>
                    </h5>
                    <small class="text-body-secondary">Nível de Acesso: <?php echo $nivel_acesso; ?></small>
                </div>
            </a>
            <ul class="nav flex-column mb-auto">



                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2" href="../../FORMULÁRIOS/QUESTOES/criar_questao.php">
                        <svg class="bi" aria-hidden="true">
                            <use xlink:href="#file-earmark"></use>
                        </svg>
                        ENVIAR QUESTÃO 
                    </a>
                </li>

                <?php if ($nivel_acesso >= 1): ?>
                    <hr class="my-2" />
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-2" href="../../FORMULÁRIOS/DISCIPLINAS/criar_disciplinas.php">
                            <svg class="bi" aria-hidden="true">
                                <use xlink:href="#cart"></use>
                            </svg>
                            DISCIPLINAS (Nível 1+)
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-2" href="../../FORMULÁRIOS/QUESTOES/questoes_em_analise.php">
                            <svg class="bi" aria-hidden="true">
                                <use xlink:href="#people"></use>
                            </svg>
                            QUESTÕES (Nível 1+)
                        </a>
                    </li>
                <?php endif; ?>

                <?php if ($nivel_acesso >= 2): ?>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-2" href="../../FORMULÁRIOS/TURMAS/listar_turmas.php">
                            <svg class="bi" aria-hidden="true">
                                <use xlink:href="#graph-up"></use>
                            </svg>
                            TURMAS (Nível 2+)
                        </a>
                    </li>
                <?php endif; ?>
            </ul>

            <?php if ($nivel_acesso >= 3): ?>
                <h6
                    class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-body-secondary text-uppercase">
                    <span>Saved reports</span>
                    <a class="link-secondary" href="#" aria-label="Add a new report">
                        <svg class="bi" aria-hidden="true">
                            <use xlink:href="#plus-circle"></use>
                        </svg>
                    </a>
                </h6>
                <ul class="nav flex-column mb-auto">
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-2" href="../../ESCOLAS/registro.php">
                            <svg class="bi" aria-hidden="true">
                                <use xlink:href="#file-earmark-text"></use>
                            </svg>
                            CADASTRAR ESCOLA
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-2" href="../../DASHBOARDS/ALUNOS/index.php">
                            <svg class="bi" aria-hidden="true">
                                <use xlink:href="#file-earmark-text"></use>
                            </svg>
                            Dashboard
                        </a>
                    </li>
                </ul>
            <?php endif; ?>

            <hr class="my-3" />

            <ul class="nav flex-column mb-auto">

                <?php if ($nivel_acesso == 4): ?>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-2 text-danger fw-bold" href="#">
                            <svg class="bi" aria-hidden="true">
                                <use xlink:href="#gear-wide-connected"></use>
                            </svg>
                            Configurações Admin
                        </a>
                    </li>
                <?php endif; ?>

                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2 active" aria-current="page" href="#">
                        <svg class="bi" aria-hidden="true">
                            <use xlink:href="#house-fill"></use>
                        </svg>
                        ESCOLA
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2" href="#">
                        <svg class="bi" aria-hidden="true">
                            <use xlink:href="#people"></use>
                        </svg>
                        TURMA
                    </a>
                </li>


                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2"
                        href="../include/logout.php">
                        <svg class="bi" aria-hidden="true">
                            <use xlink:href="#door-closed"></use>
                        </svg>
                        Logout
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>