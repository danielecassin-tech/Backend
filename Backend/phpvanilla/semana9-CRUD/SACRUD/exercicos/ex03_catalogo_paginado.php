<?php
declare(strict_types=1);

require_once __DIR__ . '/conexao.php';

// Garante que o número da página seja válido.
function obterPagina(mixed $valor): int
{
    $pagina = filter_var($valor, FILTER_VALIDATE_INT);
    return $pagina !== false && $pagina > 0 ? $pagina : 1;
}

try {
    $pdo = conectar();
    $pagina = obterPagina($_GET['p'] ?? 1);
    $offset = ($pagina - 1) * 5;

    $sql = 'SELECT id, nome, quantidade FROM pecas_industriais
            WHERE ativo = TRUE ORDER BY id
            LIMIT :limite OFFSET :offset';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':limite', 5, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $pecas = $stmt->fetchAll();
} catch (Throwable $erro) {
    exit('Não foi possível carregar o catálogo.');
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Catálogo de Peças</title>
</head>
<body>
    <h1>Catálogo de Peças Industriais</h1>

    <?php if ($pecas === []): ?>
        <p>Nenhuma peça nesta página.</p>
    <?php endif; ?>

    <ul>
        <?php foreach ($pecas as $peca): ?>
            <li>
                <?= htmlspecialchars($peca['nome'], ENT_QUOTES, 'UTF-8') ?>
                — Quantidade: <?= (int) $peca['quantidade'] ?>
            </li>
        <?php endforeach; ?>
    </ul>

    <p>Página atual: <?= $pagina ?></p>
    <a href="?p=<?= max(1, $pagina - 1) ?>">Anterior</a>
    |
    <a href="?p=<?= $pagina + 1 ?>">Próxima</a>
</body>
</html>
