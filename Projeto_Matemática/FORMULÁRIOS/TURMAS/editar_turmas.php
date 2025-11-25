<?php

require_once('../../DASHBOARDS/include/connection.php');


$sql_escolas = "SELECT id, nome_escola, cod_inep FROM escolas ORDER BY nome_escola ASC";

try {
  $stmt = $pdo->prepare('$sql_escolas');
  $stmt->execute();
  $escolas = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
  $escolas = [];
}

if (empty($escolas)) {
  $mensagem_escolas = "Não há escolas cadastradas no momento.";
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cadastro de Turma</title>
</head>

<body>

  <h1>Cadastro de Nova Turma</h1>

  <form action="proc_turmas.php" method="POST">

    <div>
      <label for="nome_turma">Nome da Turma:</label>
      <input type="text" id="nome_turma" name="nome_turma" required placeholder="Ex: 8º Ano A - Tarde">
    </div>

    <div>
      <label for="cod_inep">Escola (Código INEP):</label>

      <?php if (!empty($escolas)): ?>

                <select id="cod_inep" name="cod_inep" required>
          <option value="">-- Selecione uma Escola --</option>

          <?php
          foreach ($escolas as $escola) {
            echo '<option value="' . htmlspecialchars($escola['cod_inep']) . '">';
            echo htmlspecialchars($escola['nome_escola']);
            echo '</option>';
          }
          ?>

        </select>

      <?php else: ?>
        <p style="color: red;"><?= $mensagem_escolas ?></p>
      <?php endif; ?>

    </div>

    <br>
    <input type="hidden" id="action" name="action" value="CRIAR">
    <button type="submit" <?= empty($escolas) ? 'disabled' : '' ?>>
      Cadastrar Turma
    </button>
  </form>

</body>

</html>