<?php
include_once('../../DASHBOARDS/include/connection.php');

// ADICIONE ESTAS DUAS LINHAS PARA GARANTIR QUE O SIDEBAR FUNCIONE COM NÍVEIS DE ACESSO.
session_start();
$nivel_acesso = $_SESSION['nivel_de_acesso'] ?? 0;

// --- INÍCIO DA FUNÇÃO DE CONVERSÃO MATEMÁTICA PARA EXIBIÇÃO ---
function simplify_math_for_display($text) {
    // 1. Substituições simples de comandos para símbolos Unicode
    $text = str_replace('//div', '÷', $text);
    $text = str_replace('\cdot', '·', $text);
    $text = str_replace('\times', '×', $text);
    $text = str_replace('\div', '÷', $text);
    $text = str_replace('\pi', 'π', $text);
    $text = str_replace('\pm', '±', $text);
    $text = str_replace('\neq', '≠', $text);
    $text = str_replace('\approx', '≈', $text);
    $text = str_replace('\le', '≤', $text); // Menor ou igual
    $text = str_replace('\ge', '≥', $text); // Maior ou igual
    $text = str_replace('\sum', 'Σ', $text); // Somatório
    $text = str_replace('\int', '∫', $text); // Integral
    $text = str_replace('\lim', 'lim', $text); // Limite (como texto)
    $text = str_replace('\alpha', 'α', $text); // Letras Gregas
    $text = str_replace('\beta', 'β', $text);
    $text = str_replace('\gamma', 'γ', $text);
    
    // 2. Substituições complexas (Regex)

    // Tratar o comando \sqrt{conteúdo} para √conteúdo
    $text = preg_replace('/\\\sqrt{([^}]+)}/', '√$1', $text); 
    
    // Simplificar Frações: \dfrac{a}{b} ou \frac{a}{b} -> (a)/(b)
    $text = preg_replace('/\\\dfrac{([^}]+)}{([^}]+)}/', '($1)/($2)', $text); 
    $text = preg_replace('/\\\frac{([^}]+)}{([^}]+)}/', '($1)/($2)', $text); 
    
    // 🔑 NOVO: Tratar Matrizes (2x2, 3x3 e outras)
    // Converte \begin{pmatrix}1 & 2 \\ 3 & 4\end{pmatrix} para [ 1, 2 | 3, 4 ]
    // Remove os comandos de ambiente e substitui separadores
    $text = preg_replace('/\\\begin\{[a-z]?matrix\}(.+?)\\\end\{[a-z]?matrix\}/s', '[ $1 ]', $text);
    $text = str_replace('&', ', ', $text); // Separador de coluna
    $text = str_replace('\\\\', ' | ', $text); // Separador de linha (nova linha KaTeX)

    // 3. Remover comandos que apenas formatam texto e não símbolos, mas mantêm o conteúdo.
    $text = preg_replace('/\\\[a-zA-Z]+\s*\{([^}]+)\}/', '$1', $text); 
    
    // 4. Limpar tags HTML e espaços
    $text = strip_tags($text);
    $text = preg_replace('/\s+/', ' ', $text);
    
    return trim($text);
}
// --- FIM DA FUNÇÃO DE CONVERSÃO MATEMÁTICA PARA EXIBIÇÃO ---


$sql = "SELECT questoes.*, disciplinas.disciplina FROM questoes INNER JOIN disciplinas ON questoes.id_disciplina = disciplinas.id WHERE questoes.id_situacao = 0 ORDER BY questoes.id DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$questoes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// --- INÍCIO DA MUDANÇA PARA BREADCRUMBS ---
$breadcrumbs = [
    ['url' => '../../DASHBOARDS/ALUNOS/index.php', 'title' => 'Dashboard'],
    ['url' => '../../DASHBOARDS/ALUNOS/index.php', 'title' => 'Questões'],
    ['url' => 'questoes_negadas.php', 'title' => 'Negadas']
];
// --- FIM DA MUDANÇA PARA BREADCRUMBS ---
?>

<!doctype html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Questões Negadas</title>
  <link rel="stylesheet" type="text/css" href="../../Dashboards/dashboard.css">
  <link rel="stylesheet" href="../../include/style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
  <link href="../../DASHBOARDS/ALUNOS/dashboard.css" rel="stylesheet" />

  <style>
        /* Variáveis de Cores (Unificadas com visualizar_questao.php) */
        :root {
            --dark-bg: #141421; /* Fundo principal escuro */
            --item-bg: #1a1a2e; /* Fundo dos cards/itens */
            --text-color: #e0e0e0;
            --neon-blue: #00e0ff;
            --bg-black: #000000;
            --neon-magenta: #ff00ff;
            
            /* Mapeamento para estilos existentes da tabela */
            --neon-color: var(--neon-blue); 
            --neon-color-alt: var(--neon-magenta); 
            --shadow-intensity: 0 0 10px;
        }

        body {
            background-color: var(--dark-bg);
            color: var(--text-color);
            /* Fonte de visualizacao */
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
        }

        /* 🔑 Estilo do Sidebar/Layout (Importado de visualizar_questao.php) */
        .sidebar .bi {
            width: 1rem;
            height: 1rem;
            vertical-align: -0.125em;
            pointer-events: none;
            fill: currentColor;
        }

        /* Aplica o estilo de fundo e borda à main para corresponder ao layout */
        main.col-md-9, .main {
            background-color: var(--dark-bg) !important;
            border-left: 1px solid rgba(255, 255, 255, 0.1);
            min-height: 100vh;
            padding-top: 20px !important;
        }
        
        /* Estilos do Título Principal (Importado de visualizar_questao.php) */
        .h2, h1 {
            color: var(--neon-blue);
            text-shadow: 0 0 5px rgba(0, 224, 255, 0.6);
            font-weight: 700;
            margin-top: 2rem;
            /* Mantido para a linha separadora */
            border-bottom: 2px solid var(--neon-blue);
            letter-spacing: 1.5px; 
        }

        /* Tabela Neon (Ajustado/Mantido) */
        .table-striped>tbody>tr:nth-of-type(odd)>* {
            background-color: var(--item-bg) !important; 
        }

        .table-striped>tbody>tr:nth-of-type(even)>* {
            background-color: var(--dark-bg) !important; 
        }

        .table-bordered {
            border: 1px solid var(--neon-color);
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid rgba(0, 255, 255, 0.3) !important;
        }

        .table td {
            color: var(--neon-blue) !important; /* Ajustado para neon-blue */
            font-weight: 500;
        }

        .table thead th {
            color: var(--neon-magenta); /* Ajustado para neon-magenta */
            background-color: var(--item-bg) !important;
            border-bottom: 2px solid var(--neon-magenta) !important;
            text-shadow: 0 0 5px rgba(255, 0, 255, 0.5);
        }

        /* Botões (Unificados com o estilo de visualizacao) */
        .btn {
            --btn-color: var(--neon-blue);
            background: transparent;
            color: var(--btn-color);
            border: 1px solid var(--btn-color);
            padding: 5px 10px;
            border-radius: 3px;
            box-shadow: 0 0 3px var(--btn-color);
            transition: all 0.2s;
            font-weight: 500; /* Adicionado para clareza */
        }

        .btn:hover:not(:disabled) {
            background: var(--btn-color);
            color: var(--dark-bg);
            box-shadow: 0 0 10px var(--btn-color);
        }

        /* Cores Específicas dos Botões */
        .btn-warning {
            --btn-color: #ffb700; /* Neon Warning (do visualizar) */
        }

        .btn-danger {
            --btn-color: #ff4d4d; /* Neon Danger (do visualizar) */
        }

        .btn-success {
            --btn-color: #00ff73; /* Neon Success (do visualizar) */
        }

        .btn-secondary {
            --btn-color: #9999ff;
        }
        
        /* NOVO: Estilo para Migalhas de Pão (Breadcrumbs) (Mantido) */
        .breadcrumb {
            --bs-breadcrumb-divider-color: var(--neon-magenta);
            background-color: var(--bg-black) !important;
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
        
        /* Estilos do DataTables (Mantido) */
        .dataTables_wrapper .dataTables_filter input,
        .dataTables_wrapper .dataTables_length select,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            color: var(--text-color) !important;
            background-color: transparent !important;
            border-color: var(--neon-blue) !important;
        }

        .dataTables_wrapper .dataTables_filter input,
        .dataTables_wrapper .dataTables_length select {
            background-color: var(--item-bg) !important;
            border: 1px solid var(--neon-blue) !important;
            box-shadow: 0 0 5px rgba(0, 255, 255, 0.3);
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current,
        .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
            background-color: var(--neon-blue) !important;
            color: var(--dark-bg) !important;
            border: 1px solid var(--neon-blue) !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            color: var(--neon-blue) !important;
            background-color: var(--item-bg) !important;
            border: 1px solid var(--neon-blue) !important;
        }

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
  </style>
</head>

<body>
  <?php
  include_once('../../DASHBOARDS/COMPONENTES/navbar.php');
  ?>

  <div class="container-fluid">
    <div class="row">
      <?php
            include_once('../../DASHBOARDS/COMPONENTES/sidebar.php');
            include_once('../../DASHBOARDS/COMPONENTES/svg.php');
      ?>

      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mx-auto">
        <?php include_once('../../DASHBOARDS/COMPONENTES/breadcrumbs.php'); ?>
        <div class="pt-3 pb-2 mb-3">
          <h1 class="h2">Questões Negadas</h1>
        </div>

        <table id="questoesTable" class="table table-striped table-bordered" style="width:100%">
          <thead>
            <tr>
              <th>ID</th>
              <th>Enunciado</th>
              <th>Origem</th>
              <th>Disciplina</th>
              <th>Ações</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($questoes as $questao) : ?>
              <tr>
                <td><?php echo htmlspecialchars($questao['id']); ?></td>
                <td><?php 
                // APLICAÇÃO DA FUNÇÃO simplify_math_for_display()
                $enunciado_preview = simplify_math_for_display(mb_substr($questao['enunciado'], 0, 50));
                echo htmlspecialchars($enunciado_preview) . (mb_strlen($questao['enunciado']) > 50 ? '...' : ''); 
                ?></td>
                <td><?php echo htmlspecialchars($questao['origem']); ?></td>
                <td><?php echo htmlspecialchars($questao['disciplina']); ?></td>
                <td>
                  <a href="editar_questao.php?id=<?php echo $questao['id']; ?>" class="btn btn-warning btn-sm">Editar</a>
                  <a href="excluir_questao.php?id=<?php echo $questao['id']; ?>" class="btn btn-danger btn-sm"
                    onclick="return confirm('Tem certeza que deseja excluir esta questao?');">Excluir</a>
                  <a href="aprovar_questao.php?id=<?php echo $questao['id']; ?>"
                    class="btn btn-success btn-sm">Aprovar</a>
                  <a href="visualizar_questao.php?id=<?php echo $questao['id']; ?>"
                    class="btn btn-secondary btn-sm">View</a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </main>
    </div>
  </div>

  <?php
  include_once('../../DASHBOARDS/COMPONENTES/footer.php');
  ?>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
  <script>
    $(document).ready(function () {
      $('#questoesTable').DataTable();
    });
  </script>
</body>

</html>