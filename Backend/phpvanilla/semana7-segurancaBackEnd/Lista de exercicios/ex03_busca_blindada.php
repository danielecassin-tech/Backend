
<?php
declare(strict_types=1);

function e(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

$busca = $_GET['q'] ?? '';
if (!is_string($busca)) {
    $busca = '';
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Busca de Produtos</title>
</head>
<body>
    <h1>Buscar produtos</h1>
    <form method="get">
        <label for="q">Termo pesquisado:</label>
        <input type="text" id="q" name="q" value="<?= e($busca) ?>">
        <button type="submit">Buscar</button>
    </form>

    <p>Você buscou por: <?= e($busca) ?></p>
</body>
</html>
