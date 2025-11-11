<style>
    .sidebar {
        position: fixed;
        top: 40px;
        bottom: 0;
        z-index: 100;
        /* Garante que o sidebar ocupe todo o espaço entre o topo (40px) e o final da tela (0) */
    }

    /* CORREÇÃO CRÍTICA: Define o tamanho padrão para os ícones SVG, que estava falhando */
    .nav-link svg.bi {
        width: 1em;
        /* Tamanho padrão para ícones em linha (como no Bootstrap) */
        height: 1em;
        vertical-align: -.125em;
        /* Alinhamento vertical padrão */
        fill: currentColor;
        /* Usa a cor do texto do link */
    }
</style>

<div class="sidebar border border-right col-md-3 col-lg-2 p-0 bg-body-tertiary">
    <div class="offcanvas-md offcanvas-end bg-body-tertiary h-100" tabindex="-1" id="sidebarMenu"
        aria-labelledby="sidebarMenuLabel">

        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="sidebarMenuLabel">Dashboard</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#sidebarMenu"
                aria-label="Close"></button>
        </div>

        <div class="offcanvas-body d-md-flex flex-column p-0 pt-lg-3 h-100">

            <div class="d-flex flex-shrink-0 p-3 border-bottom bg-dark">
                <a href="perfil.php" class="d-flex align-items-center text-decoration-none w-100">
                    <img src="/Projeto_Matemática(2)/User_Registration/<?php echo htmlspecialchars($_SESSION['user_photo_path']); ?>"
                        alt="Foto de Perfil" width="40" height="40"
                        class="rounded-circle me-3 border border-2 border-white" style="object-fit: cover;">
                    <div class="lh-1 text-truncate">
                        <span class="d-block text-white-50 small">Olá, seja bem-vindo(a),</span>
                        <strong class="text-white"><?php echo htmlspecialchars($_SESSION['user_name']); ?>!</strong>

                    </div>
                </a>
            </div>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center" href="../../Dashboards/Alunos/index.php">
                        Página Inicial
                    </a>
                </li>
            </ul>
            <div class="mt-auto">
                <hr class="my-3">

                <ul class="nav flex-column">

                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center" href="../../Forms/Question/criar_questao.php">
                            <svg class="bi me-2" aria-hidden="true">
                                <use xlink:href="#file-earmark"></use>
                            </svg> Enviar Questão
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center"
                            href="..\..\Dashboards\Professores\CRUD_Classroom\read_classroom.php">
                            <svg class="bi me-2" aria-hidden="true">
                                <use xlink:href="#people"></use>
                            </svg> Turma
                        </a>
                    </li>
                </ul>

                <hr class="my-3">

                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center"
                            href="../../Dashboards/Include/Settings/edit_registration.php">
                            <svg class="bi me-2" aria-hidden="true">
                                <use xlink:href="#gear-wide-connected"></use>
                            </svg> Configurações
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center" href="../../Dashboards/Include/logout.php">
                            <svg class="bi me-2" aria-hidden="true">
                                <use xlink:href="#door-closed"></use>
                            </svg> Sair
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>