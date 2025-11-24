<?php

$nivel_acesso = $_SESSION['nivel_de_acesso'] ?? 0;

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
                        <a class="nav-link d-flex align-items-center gap-2" href="#">
                            <svg class="bi" aria-hidden="true">
                                <use xlink:href="#file-earmark-text"></use>
                            </svg>
                            Last quarter
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
                    <a class="nav-link d-flex align-items-center gap-2" href="../../USUÁRIO/PERFIL/perfil.php">
                        <svg class="bi" aria-hidden="true">
                            <use xlink:href="#gear-wide-connected"></use>
                        </svg>
                        Perfil
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2"
                        href="../../DASHBOARDS/INCLUDE/SISTEMA_BE/logout.php">
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