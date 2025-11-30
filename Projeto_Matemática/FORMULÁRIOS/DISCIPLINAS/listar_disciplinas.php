<?php
require_once('../../DASHBOARDS/include/connection.php');

$sql_disciplina = "
    SELECT 
        d.id, 
        d.disciplina, 
        ae.nome_escolaridade AS nome_escolaridade 
    FROM 
        disciplinas d
    JOIN 
        anos_escolaridades ae ON d.id_escolaridade = ae.id
    ORDER BY 
        d.id DESC
";

$disciplina = $pdo->prepare($sql_disciplina);
$disciplina->execute();

// --- INÍCIO: MIGALHAS DE PÃO (BREADCRUMBS) ---
$breadcrumbs = [
    ['url' => '../../DASHBOARDS/ALUNOS/index.php', 'title' => 'Dashboard'],
    ['url' => '#', 'title' => 'Disciplinas']
];
// --- FIM: MIGALHAS DE PÃO (BREADCRUMBS) ---

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LISTAR - DISCIPLINAS</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.min.css">
    
    <style>
        /* Variáveis de cor */
        :root {
            --neon-blue: #00ffff;
            --neon-magenta: #ff00ff;
            --dark-bg-main: #141421;
            --dark-bg-area: #000000; /* Fundo preto puro para a área da tabela e Datatables */
            --item-bg: #22223a;
            --text-color: var(--neon-blue); /* Todo texto da área deve ser azul neon */
            --border-color: rgba(0, 255, 255, 0.1);
            --shadow-intensity: 0 0 10px;
        }

        body {
            background-color: var(--dark-bg-main);
            color: var(--text-color);
            font-family: 'Consolas', 'Courier New', monospace;
            padding-top: 20px;
            padding-bottom: 20px;
        }

        /* Estilo de Títulos */
        h2 {
            color: var(--neon-blue); /* Título principal em azul neon */
            text-shadow: 0 0 5px var(--neon-blue);
            margin-bottom: 25px;
            letter-spacing: 1.5px;
            text-align: left;
        }

        /* Estilo para Migalhas de Pão (Breadcrumbs) */
        .breadcrumb {
            --bs-breadcrumb-divider-color: var(--neon-magenta);
            background-color: transparent;
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

        /* Estilo específico para o Botão Criar */
        .neon-create-btn {
            background: var(--neon-blue) !important;
            color: var(--dark-bg-area) !important; /* Texto escuro no botão neon */
            border-color: var(--neon-blue) !important;
            font-weight: bold;
            box-shadow: 0 0 10px var(--neon-blue) !important;
        }

        .neon-create-btn:hover {
            background: var(--neon-magenta) !important;
            border-color: var(--neon-magenta) !important;
            box-shadow: 0 0 15px var(--neon-magenta) !important;
            color: var(--dark-bg-area) !important;
        }

        /* Botões Secundários/Ações */
        .btn-primary {
            --btn-color: var(--neon-blue);
            background: transparent !important;
            color: var(--btn-color) !important;
            border-color: var(--btn-color) !important;
            box-shadow: 0 0 3px var(--btn-color) !important;
        }

        .btn-primary:hover {
            background: var(--btn-color) !important;
            color: var(--dark-bg-area) !important;
            box-shadow: 0 0 10px var(--btn-color) !important;
        }

        .btn-danger {
            background-color: transparent !important;
            color: var(--neon-magenta) !important;
            border-color: var(--neon-magenta) !important;
            box-shadow: 0 0 3px var(--neon-magenta) !important;
        }

        .btn-danger:hover {
            background-color: var(--neon-magenta) !important;
            color: var(--dark-bg-area) !important;
            border-color: var(--neon-magenta) !important;
            box-shadow: 0 0 10px var(--neon-magenta) !important;
        }

        /* Estilo para Tabelas (DataTables e Bootstrap) */
        .table-neon {
            border: 1px solid var(--neon-blue);
            box-shadow: 0 0 10px rgba(0, 255, 255, 0.4);
            background-color: var(--dark-bg-area) !important; /* Fundo Preto */
            color: var(--text-color); /* Texto Azul Neon */
            margin-top: 20px;
        }

        .table-neon thead {
            background-color: var(--dark-bg-area); /* Fundo Preto */
            border-bottom: 2px solid var(--neon-magenta);
        }

        .table-neon th {
            color: var(--neon-blue) !important;
            text-shadow: 0 0 5px rgba(0, 255, 255, 0.5);
            font-weight: bold;
            border-bottom: 1px solid var(--border-color) !important;
        }

        .table-neon tbody tr {
            transition: background-color 0.2s;
            border-color: var(--border-color) !important;
        }

        .table-neon tbody tr:hover {
            background-color: var(--item-bg) !important;
        }

        .table-neon tbody tr td {
            color: var(--text-color); /* Garantindo que o texto da célula seja azul neon */
        }

        /*
        * AJUSTES CRUCIAIS PARA O DATATABLES FICAR PRETO
        */

        /* Wrapper principal do DataTables */
        .dataTables_wrapper {
            background-color: var(--dark-bg-area) !important; /* Fundo Preto */
            color: var(--text-color) !important;
            padding: 10px 0; /* Adiciona padding ao redor dos controles */
        }
        
        /* Controles de tamanho (Show entries) e Filtro (Search) */
        .dataTables_wrapper label,
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_processing {
            color: var(--text-color) !important; /* Texto dos controles em azul neon */
        }
        
        /* Inputs e Selects do DataTables (para busca e seleção de número de linhas) */
        .dataTables_wrapper .dataTables_filter input,
        .dataTables_wrapper .dataTables_length select {
            color: var(--text-color) !important;
            background-color: var(--dark-bg-area) !important; /* Fundo Preto no input */
            border: 1px solid var(--neon-blue) !important;
            box-shadow: 0 0 5px rgba(0, 255, 255, 0.5);
        }

        /* Paginação */
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            color: var(--neon-blue) !important;
            border: 1px solid var(--border-color) !important;
            background: var(--dark-bg-area) !important; /* Fundo Preto no botão */
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover:not(.disabled) {
            background: var(--neon-magenta) !important;
            color: var(--dark-bg-area) !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: var(--neon-blue) !important;
            color: var(--dark-bg-area) !important;
            border-color: var(--neon-blue) !important;
        }
    </style>
</head>

<body>
    <section class="container">

        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <?php foreach ($breadcrumbs as $item): ?>
                    <li class="breadcrumb-item <?php echo $item['url'] === '#' ? 'active' : ''; ?>">
                        <?php if ($item['url'] !== '#'): ?>
                            <a href="<?php echo $item['url']; ?>"><?php echo $item['title']; ?></a>
                        <?php else: ?>
                            <?php echo $item['title']; ?>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ol>
        </nav>
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="my-0">Disciplinas Cadastradas</h2>
            <a href="criar_disciplinas.php" class="btn btn-primary d-flex align-items-center gap-1 neon-create-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle-fill" viewBox="0 0 16 16">
                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3z"/>
                </svg>
                Criar Disciplina
            </a>
        </div>
        <table class="table table-striped table-bordered table-neon" id="minhaTabela">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>DISCIPLINA</th>
                    <th>ESCOLARIDADE</th>
                    <th>AÇÕES</th>
                </tr>
            </thead>
            <tbody>

                <?php
                while ($disc = $disciplina->fetch(PDO::FETCH_ASSOC)) { 
                ?>

                    <tr>
                        <td><?php echo htmlspecialchars($disc['id']); ?></td>
                        <td><?php echo htmlspecialchars($disc['disciplina']); ?></td>
                        <td><?php echo htmlspecialchars($disc['nome_escolaridade']); ?></td>
                        <td>
                            <a class="btn btn-primary btn-sm"
                                href="<?php echo 'editar_disciplinas.php?id=' . $disc['id']; ?>">Editar</a>
                            <a class="btn btn-danger btn-sm"
                                href="<?php echo 'deletar_disciplinas.php?id=' . $disc['id']; ?>">Excluir</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </section>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#minhaTabela').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/2.0.7/i18n/pt-BR.json"
                },
                "order": [[ 0, "desc" ]]
            });
        });
    </script>

</body>
</html>