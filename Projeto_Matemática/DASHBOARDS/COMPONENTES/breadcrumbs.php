<?php
/**
 * breadcrumbs.php - Componente Dinâmico de Migalhas de Pão (Breadcrumbs)
 * * Este componente espera que a variável $breadcrumbs seja definida na página que o inclui.
 * * Exemplo de definição de $breadcrumbs:
 * $breadcrumbs = [
 * ['url' => '../../DASHBOARDS/index.php', 'title' => 'Dashboard'],
 * ['url' => '#', 'title' => 'Página Pai'],
 * ['url' => '', 'title' => 'Página Atual']
 * ];
 */
?>

<div class="container-fluid pt-4 px-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-chevron p-3 bg-body-tertiary rounded-3">
            <li class="breadcrumb-item">
                <a class="link-body-emphasis" href="../../DASHBOARDS/ALUNOS/index.php">
                    <svg class="bi" width="16" height="16" aria-hidden="true">
                        <use xlink:href="#house-door-fill"></use>
                    </svg>
                    <span class="visually-hidden">Home</span>
                </a>
            </li>
            
            <?php
            // Adiciona os itens dinâmicos
            if (isset($breadcrumbs) && is_array($breadcrumbs)) {
                $count = count($breadcrumbs);
                foreach ($breadcrumbs as $index => $item) {
                    // Verifica se é o último item (página atual)
                    $is_active = ($index === $count - 1);
                    $class = $is_active ? 'breadcrumb-item active' : 'breadcrumb-item';
                    $aria_current = $is_active ? 'aria-current="page"' : '';

                    echo '<li class="' . $class . '" ' . $aria_current . '>';
                    
                    if (!$is_active && !empty($item['url'])) {
                        // Links intermediários
                        echo '<a class="link-body-emphasis fw-semibold text-decoration-none" href="' . htmlspecialchars($item['url']) . '">' . htmlspecialchars($item['title']) . '</a>';
                    } else {
                        // Título da página atual (sem link)
                        echo htmlspecialchars($item['title']);
                    }
                    echo '</li>';
                }
            }
            ?>
        </ol>
    </nav>
</div>