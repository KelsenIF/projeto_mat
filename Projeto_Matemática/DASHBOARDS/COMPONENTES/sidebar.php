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

<style>
/* Variáveis de cor (Sincronizadas com o index.php) */
:root {
    --neon-blue: #00e0ff;
    --neon-magenta: #ff00c3;
    --dark-bg-main: #141421; 
    --dark-bg-area: #1a1a2e; 
    --item-bg: #22223a; 
    --text-color: #e0e0e0;
    --border-color: rgba(0, 224, 255, 0.1);
}

/* 1. Estilização Global da Sidebar e Fundo Escuro */
.sidebar {
    background-color: #04101eff !important;
    border-right: 1px solid var(--border-color) !important;
    min-height: 100vh; /* Garante que a sidebar tenha altura suficiente */
    position: sticky; /* Mantém a sidebar visível ao rolar a página */
    top: 0;
}
    .nav-scroller {
      position: relative;
      z-index: 2;
      height: 2.75rem;
      overflow-y: hidden;
    }

    .nav-scroller .nav {
      display: flex;
      flex-wrap: nowrap;
      padding-bottom: 1rem;
      margin-top: -1px;
      overflow-x: auto;
      text-align: center;
      white-space: nowrap;
      -webkit-overflow-scrolling: touch;
    }

    .btn-bd-primary {
      --bd-violet-bg: #712cf9;
      --bd-violet-rgb: 112.520718, 44.062154, 249.437846;
      --bs-btn-font-weight: 600;
      --bs-btn-color: var(--bs-white);
      --bs-btn-bg: var(--bd-violet-bg);
      --bs-btn-border-color: var(--bd-violet-bg);
      --bs-btn-hover-color: var(--bs-white);
      --bs-btn-hover-bg: #6528e0;
      --bs-btn-hover-border-color: #6528e0;
      --bs-btn-focus-shadow-rgb: var(--bd-violet-rgb);
      --bs-btn-active-color: var(--bs-btn-hover-color);
      --bs-btn-active-bg: #5a23c8;
      --bs-btn-active-border-color: #5a23c8;
    }

    .bd-mode-toggle {
      z-index: 1500;
    }

    .bd-mode-toggle .bi {
      width: 1em;
      height: 1em;
    }

    .bd-mode-toggle .dropdown-menu .active .bi {
      display: block !important;
    }
    


    .offcanvas-body {
        background-color: #04101eff !important;
    }
    .offcanvas-md {
        background-color: #04101eff !important;
    }

    /* Se você estiver usando o Bootstrap 5, o .bg-body-tertiary (que está na div principal)
    precisa ser sobrescrito com !important
    */
    .bg-body-tertiary {
        background-color: #04101eff !important;
    }
/* 2. Estilização do Título e Header */
.offcanvas-header {
    background-color: var(--dark-bg-area) !important;
    border-bottom: 1px solid var(--border-color);
}

.offcanvas-title {
    color: var(--neon-blue);
    text-shadow: 0 0 5px rgba(0, 224, 255, 0.6);
    font-weight: 700;
}

.btn-close {
    filter: invert(1) hue-rotate(180deg); 
}

/* 3. Estilização da Seção do Perfil */
.p-3.text-center.mb-3 {
    background-color: var(--item-bg);
    box-shadow: 0 0 10px rgba(0, 224, 255, 0.2);
    border-radius: 5px;
    margin: 15px !important; 
    transition: all 0.3s;
}

.p-3.text-center.mb-3:hover {
    box-shadow: 0 0 15px var(--neon-blue), 0 0 20px rgba(0, 224, 255, 0.4);
}

h5.fw-bold.fs-6 {
    color: var(--text-color);
}

small.text-body-secondary {
    color: var(--neon-magenta) !important;
    text-shadow: 0 0 3px rgba(255, 0, 195, 0.5);
    font-style: italic;
}

/* 4. Estilização da Navegação e Links */
.nav-link {
    color: var(--text-color) !important;
    transition: background-color 0.2s, color 0.2s, text-shadow 0.2s;
}

/* Efeito Hover/Foco: O Brilho Neon Sutil */
.nav-link:hover,
.nav-link:focus {
    background-color: var(--item-bg);
    color: var(--neon-blue) !important;
    text-shadow: 0 0 5px rgba(0, 224, 255, 0.5); /* Brilho do texto */
    box-shadow: inset 5px 0 0 var(--neon-blue); /* Linha lateral */
}

/* Efeito para Links ATIVOS */
.nav-link.active {
    background-color: var(--item-bg);
    color: var(--neon-magenta) !important;
    text-shadow: 0 0 5px rgba(255, 0, 195, 0.5);
    box-shadow: inset 5px 0 0 var(--neon-magenta);
}

/* 5. Títulos de Seção */
hr.my-2, hr.my-3 {
    border-color: var(--border-color);
    opacity: 0.5;
}

.sidebar-heading {
    color: var(--neon-blue) !important;
    text-shadow: 0 0 5px rgba(0, 224, 255, 0.4);
    font-size: 0.85rem;
}

/* 6. Link de Administrador (Destaque Vermelho/Perigo) */
.nav-link.text-danger {
    color: var(--neon-magenta) !important;
    text-shadow: 0 0 5px rgba(255, 0, 195, 0.5);
}

.nav-link.text-danger:hover {
    color: #ff4d4d !important; /* Vermelho mais intenso no hover */
    text-shadow: 0 0 8px #ff4d4d;
    box-shadow: inset 5px 0 0 #ff4d4d;
}

/* 🌟 CORREÇÃO DE VISIBILIDADE 🌟 */
/* Força o offcanvas a se comportar como uma coluna normal em telas maiores ou iguais a 768px (md) */
@media (min-width: 768px) {
    .offcanvas-md {
        visibility: visible !important;
        transform: none !important;
    }
}
</style>

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
        <div class="offcanvas-body d-md-flex flex-column p-0 pt-lg-3 overflow-y-auto ">

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

                    <hr class="my-2" />
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-2" href="../../FORMULÁRIOS/DISCIPLINAS/listar_disciplinas.php">
                            <svg class="bi" aria-hidden="true">
                                <use xlink:href="#cart"></use>
                            </svg>
                            DISCIPLINAS (Nível 1+)
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-2" href="../../FORMULÁRIOS/TURMAS/listar_turmas.php">
                            <svg class="bi" aria-hidden="true">
                                <use xlink:href="#graph-up"></use>
                            </svg>
                            TURMAS (Nível 2+)
                        </a>
                    </li>
            </ul>

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

            <hr class="my-3" />

            <ul class="nav flex-column mb-auto">

                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-2 text-danger fw-bold" href="#">
                            <svg class="bi" aria-hidden="true">
                                <use xlink:href="#gear-wide-connected"></use>
                            </svg>
                            Configurações Admin
                        </a>
                    </li>

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
                        href="../../../Projeto_Matemática/DASHBOARDS/include/logout.php">
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