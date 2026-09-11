<?php
declare(strict_types=1);

$produtos = [
    ['nome' => 'Notebook', 'categoria' => 'Eletrônicos', 'preco' => 3500],
    ['nome' => 'Mouse', 'categoria' => 'Eletrônicos', 'preco' => 80],
    ['nome' => 'Teclado', 'categoria' => 'Eletrônicos', 'preco' => 150],
    ['nome' => 'Camiseta', 'categoria' => 'Roupas', 'preco' => 60],
    ['nome' => 'Tênis', 'categoria' => 'Calçados', 'preco' => 250],
    ['nome' => 'Mochila', 'categoria' => 'Acessórios', 'preco' => 180],
];

$nome = $_GET['nome'] ?? '';
$precoMaximo = $_GET['preco_maximo'] ?? '';

$resultados = array_filter($produtos, function (array $produto) use ($nome, $precoMaximo): bool {
    $nomeOk = $nome === '' || stripos($produto['nome'], $nome) !== false;
    $precoOk = $precoMaximo === '' || $produto['preco'] <= (float) $precoMaximo;

    return $nomeOk && $precoOk;
});
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Busca de Produtos</title>
</head>
<body>

<h1>Catálogo de Produtos</h1>

<form method="GET">
    <label>
        Nome:
        <input type="text" name="nome" value="<?= htmlspecialchars($nome) ?>">
    </label>

    <label>
        Preço máximo:
        <input type="number" name="preco_maximo" step="0.01"
               value="<?= htmlspecialchars($precoMaximo) ?>">
    </label>

    <button type="submit">Buscar</button>
</form>

<h2>Produtos</h2>

<?php if (empty($resultados)): ?>
    <p>Nenhum produto encontrado.</p>
<?php else: ?>
    <ul>
        <?php foreach ($resultados as $produto): ?>
            <li>
                <strong><?= htmlspecialchars($produto['nome']) ?></strong>
                - <?= htmlspecialchars($produto['categoria']) ?>
                - R$ <?= number_format($produto['preco'], 2, ',', '.') ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

</body>
</html>