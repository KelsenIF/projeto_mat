<style>
    .sidebar {
        position: fixed;
        top: 40px;
        bottom: 0;
        z-index: 100;
        /* Garante que o sidebar ocupe todo o espaço entre o topo (40px) e o final da tela (0) */
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

            <div class="mb-auto">
                <img src="/Projeto_Matemática(2)/User_Registration/<?php echo htmlspecialchars($_SESSION['user_photo_path']); ?>"
                    alt="Foto de Perfil" class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                <p>Olá, seja bem-vindo(a),
                    <strong><?php echo htmlspecialchars($_SESSION['user_name']); ?></strong>!
                </p>
            </div>


            <div class="mt-auto">
                <hr class="my-3">

                <ul class="nav flex-column">
                    <li class="nav-item"> <a class="nav-link d-flex align-items-center gap-2"
                            href="CRUD_turmas\create.php">
                            <svg class="bi" aria-hidden="true">
                                <use xlink:href="#file-earmark"></use>
                            </svg> Enviar Questão </a>
                    </li>
                    <li class="nav-item"> <a class="nav-link d-flex align-items-center gap-2"
                            href="..\..\Dashboards\Professores\CRUD_Classroom\read_classroom.php">
                            <svg class="bi" aria-hidden="true">
                                <use xlink:href="#people"></use>
                            </svg> Turma </a>
                    </li>
                </ul>

                <hr class="my-3">

                <ul class="nav flex-column">
                    <li class="nav-item"> <a class="nav-link d-flex align-items-center gap-2"
                            href="../../Dashboards/Include/Settings/edit_registration.php">
                            <svg class="bi" aria-hidden="true">
                                <use xlink:href="#gear-wide-connected"></use>
                            </svg> Configurações </a>
                    </li>
                    <li class="nav-item"> <a class="nav-link d-flex align-items-center gap-2"
                            href="../../Dashboards/Include/logout.php">
                            <svg class="bi" aria-hidden="true">
                                <use xlink:href="#door-closed"></use>
                            </svg> Sair </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>