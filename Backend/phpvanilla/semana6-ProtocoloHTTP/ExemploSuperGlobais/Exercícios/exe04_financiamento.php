<?php

declare(strict_types=1);

$erro = '';
$valorFinanciado = 0;
$totalJuros = 0;
$valorParcela = 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $valorVeiculo = (float) $_POST['valor_veiculo'];
    $valorEntrada = (float) $_POST['valor_entrada'];
    $numeroParcelas = (int) $_POST['numero_parcelas'];

    $parcelasPermitidas = [12, 24, 36, 48, 60];

    if ($valorVeiculo <= 0) {
        $erro = 'Valor do veículo inválido.';
    } elseif ($valorEntrada < $valorVeiculo * 0.20) {
        $erro = 'A entrada deve ser de pelo menos 20% do veículo.';
    } elseif (!in_array($numeroParcelas, $parcelasPermitidas)) {
        $erro = 'Número de parcelas inválido.';
    } else {

        $valorFinanciado = $valorVeiculo - $valorEntrada;

        $totalJuros = $valorFinanciado * 0.015 * $numeroParcelas;

        $valorParcela =
            ($valorFinanciado + $totalJuros) / $numeroParcelas;
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Financiamento</title>
</head>

<body>

<h1>Financiamento de Veículos</h1>

<form method="POST">

    Valor do veículo:
    <input type="number" name="valor_veiculo" step="0.01" required>

    <br><br>

    Valor da entrada:
    <input type="number" name="valor_entrada" step="0.01" required>

    <br><br>

    Número de parcelas:
    <select name="numero_parcelas" required>
        <option value="">Selecione</option>
        <option value="12">12</option>
        <option value="24">24</option>
        <option value="36">36</option>
        <option value="48">48</option>
        <option value="60">60</option>
    </select>

    <br><br>

    <button type="submit">Calcular</button>

</form>

<?php if ($erro !== ''): ?>

    <p style="color: red;">
        <?= $erro ?>
    </p>

<?php endif; ?>

<?php if ($valorFinanciado > 0): ?>

    <h2>Memória de cálculo</h2>

    <p>
        Valor financiado:
        R$ <?= number_format($valorFinanciado, 2, ',', '.') ?>
    </p>

    <p>
        Total de juros:
        R$ <?= number_format($totalJuros, 2, ',', '.') ?>
    </p>

    <p>
        Valor de cada parcela:
        R$ <?= number_format($valorParcela, 2, ',', '.') ?>
    </p>

<?php endif; ?>

</body>
</html>
