<?php
// Adicionei a inicialização da sessão aqui
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
//if (!isset($_SESSION['nivel_de_acesso'])) {
  //header("Location: ../../USUÁRIO/LOGIN/login.php?erro=2");
 // exit();
//}
?>

<!doctype html>
<html lang="en" data-bs-theme="auto">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="description" content="" />
  <title>DASHBOARD</title>
  <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/dashboard/" />
  <script src="../assets/js/color-modes.js"></script>
  <link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet" />
  <meta name="theme-color" content="#712cf9" />
  <link href="dashboard.css" rel="stylesheet" />
  <style>
    /* Estilos Padrão (Mantidos) */
    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      user-select: none;
    }

    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }

    .bi {
      vertical-align: -0.125em;
      fill: currentColor;
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
    
    /* === INÍCIO DO CSS NEON GAMIFICADO PROFISSIONAL REVISADO (Incluindo Cards) === */
    
    :root {
        --dark-bg: #141421; /* Fundo principal escuro */
        --item-bg: #1a1a2e; /* Fundo dos cards/itens */
        --text-color: #e0e0e0;
        --neon-blue: #00e0ff;
        
        /* Cores Neon Mapeadas para Cards */
        --neon-success: #00ff73; /* Verde Neon */
        --neon-danger: #ff4d4d;  /* Vermelho Neon */
        --neon-warning: #ffb700; /* Amarelo/Laranja Neon */
    }

    body {
        background-color: var(--dark-bg);
        color: var(--text-color);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    /* OTIMIZAÇÃO DE LAYOUT: Garante que o conteúdo principal ocupe todo o espaço */
    main.col-md-9 {
        background-color: var(--dark-bg);
        border-left: 1px solid rgba(255, 255, 255, 0.1);
        min-height: 100vh; /* ESSENCIAL para evitar que os cards desçam demais */
        padding-top: 20px !important;
    }

    /* Estilização do Título Principal */
    main h1 {
        color: var(--neon-blue);
        text-shadow: 0 0 5px rgba(0, 224, 255, 0.6);
        font-weight: 700;
        margin-top: 2rem;
    }

    /* Estilização dos Cards (QUESTÕES - table.php) */
    .card {
        background-color: var(--item-bg) !important;
        border: 2px solid transparent !important; 
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.4);
        transition: all 0.3s ease-out;
    }
    
    .card-header {
        font-weight: 600;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    /* APROVADAS (Success) */
    .card.bg-success {
        border-color: var(--neon-success) !important;
        box-shadow: 0 0 10px rgba(0, 255, 115, 0.4);
    }
    .card.bg-success:hover {
        box-shadow: 0 0 15px var(--neon-success), 0 0 25px rgba(0, 255, 115, 0.6);
    }
    .card.bg-success .card-header { color: var(--neon-success); }


    /* NEGADAS (Danger) */
    .card.bg-danger {
        border-color: var(--neon-danger) !important;
        box-shadow: 0 0 10px rgba(255, 77, 77, 0.4);
    }
    .card.bg-danger:hover {
        box-shadow: 0 0 15px var(--neon-danger), 0 0 25px rgba(255, 77, 77, 0.6);
    }
    .card.bg-danger .card-header { color: var(--neon-danger); }

    /* NOVO: Estilo para Migalhas de Pão (Breadcrumbs) */
        .breadcrumb {
            --bs-breadcrumb-divider-color: var(--neon-magenta);
background-color: var(--bg-black) !important; /* Fundo preto puro */
        }
        .breadcrumb-item a,
        .breadcrumb-item.active {
            color: var(--neon-blue) !important;
            text-shadow: 0 0 3px rgba(0, 255, 255, 0.4);
        }
        .breadcrumb-item.active {
            color: var(--neon-magenta) !important;
            text-shadow: 0 0 3px rgba(255, 0, 255, 0.4);
        }
    /* EM ANÁLISE (Warning) */
    .card.bg-warning {
        border-color: var(--neon-warning) !important;
        box-shadow: 0 0 10px rgba(255, 183, 0, 0.4);
    }
    .card.bg-warning:hover {
        box-shadow: 0 0 15px var(--neon-warning), 0 0 25px rgba(255, 183, 0, 0.6);
    }
    .card.bg-warning .card-header { color: var(--neon-warning); }


    /* Botões internos (btn-dark) */
    .card .btn-dark {
        background-color: var(--item-bg) !important;
        border: 1px solid var(--text-color) !important;
        color: var(--text-color) !important;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    /* Efeito neon sutil no hover dos botões */
    .card.bg-success .btn-dark:hover { 
        background-color: var(--neon-success) !important; 
        color: var(--item-bg) !important;
        border-color: var(--neon-success) !important;
        box-shadow: 0 0 10px var(--neon-success);
    }
    .card.bg-danger .btn-dark:hover { 
        background-color: var(--neon-danger) !important; 
        color: var(--item-bg) !important;
        border-color: var(--neon-danger) !important;
        box-shadow: 0 0 10px var(--neon-danger);
    }
    .card.bg-warning .btn-dark:hover { 
        background-color: var(--neon-warning) !important; 
        color: var(--item-bg) !important;
        border-color: var(--neon-warning) !important;
        box-shadow: 0 0 10px var(--neon-warning);
    }

    /* === FIM DO CSS REVISADO === */

  </style>
</head>

<body>

  <?php
  require_once('../COMPONENTES/toggle.php');
  require_once('../COMPONENTES/svg.php');
  require_once('../COMPONENTES/navbar.php');
  ?>


  <div class="container-fluid">
    <div class="row">
      <?php
      require_once('../COMPONENTES/sidebar.php');
      ?>
      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <svg xmlns="http://www.w3.org/2000/svg" class="d-none">
          <symbol id="house-door-fill" viewBox="0 0 16 16">
            <path
              d="M6.5 14.5v-3.505c0-.245.25-.495.5-.495h2c.25 0 .5.25.5.5v3.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5z">
            </path>
          </symbol>
        </svg>

        <?php
        require_once('../COMPONENTES/breadcrumbs.php');
        require_once('../COMPONENTES/table.php');
        ?>
       
      </main>
    </div>
  </div>

  <?php
  require_once('../COMPONENTES/footer.php');
  ?>



  <script src="../assets/dist/js/bootstrap.bundle.min.js" class="astro-vvvwv3sm"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.2/dist/chart.umd.js"
    integrity="sha384-eI7PSr3L1XLISH8JdDII5YN/njoSsxfbrkCTnJrzXt+ENP5MOVBxD+l6sEG4zoLp" crossorigin="anonymous"
    class="astro-vvvwv3sm"></script>
  <script src="dashboard.js" class="astro-vvvwv3sm"></script>
</body>

</html>