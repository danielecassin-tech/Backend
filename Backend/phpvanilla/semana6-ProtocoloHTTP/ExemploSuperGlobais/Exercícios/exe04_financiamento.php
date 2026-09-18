```php
<?php
declare(strict_types=1);

// ==========================================
// CONSTANTES
// ==========================================

const PARCELAS_PERMITIDAS = [12, 24, 36, 48, 60];
const JUROS_MENSAL = 0.015; // 1,5% ao mês
const PERCENTUAL_MINIMO_ENTRADA = 0.20; // 20%

$erros = [];
$resultado = null;

// ==========================================
// VERIFICA SE O FORMULÁRIO FOI ENVIADO
// ==========================================

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // ==========================================
    // PEGAR OS VALORES DOS CAMPOS
    // ==========================================

    $valorVeiculo = filter_var(
        $_POST["valorVeiculo"] ?? null,
        FILTER_VALIDATE_FLOAT
    );

    $valorEntrada = filter_var(
        $_POST["valorEntrada"] ?? null,
        FILTER_VALIDATE_FLOAT
    );

    $numeroParcelas = filter_var(
        $_POST["numeroParcelas"] ?? null,
        FILTER_VALIDATE_INT
    );

    // ==========================================
    // VALIDAÇÃO DO VALOR DO VEÍCULO
    // ==========================================

    if ($valorVeiculo === false || $valorVeiculo <= 0) {
        $erros[] = "Informe um valor de veículo válido.";
    }

    // ==========================================
    // VALIDAÇÃO DO VALOR DA ENTRADA
    // ==========================================

    if ($valorEntrada === false || $valorEntrada <= 0) {
        $erros[] = "Informe um valor de entrada válido.";
    }

    // ==========================================
    // VALIDAÇÃO DA ENTRADA MÍNIMA DE 20%
    // ==========================================

    if (
        $valorVeiculo !== false &&
        $valorVeiculo > 0 &&
        $valorEntrada !== false &&
        $valorEntrada < ($valorVeiculo * PERCENTUAL_MINIMO_ENTRADA)
    ) {
        $minimoEntrada = $valorVeiculo * PERCENTUAL_MINIMO_ENTRADA;

        $erros[] = "A entrada deve ser de pelo menos 20% do valor do veículo: "
            . formatarMoeda($minimoEntrada);
    }

    // ==========================================
    // VALIDAÇÃO DO NÚMERO DE PARCELAS
    // ==========================================

    if (
        $numeroParcelas === false ||
        !in_array($numeroParcelas, PARCELAS_PERMITIDAS, true)
    ) {
        $erros[] = "Selecione um número de parcelas válido.";
    }

    // ==========================================
    // REGRA DE NEGÓCIO
    // ==========================================

    if (empty($erros)) {

        // Valor que será realmente financiado
        $saldoFinanciado = $valorVeiculo - $valorEntrada;

        // Juros simples:
        // J = C × i × t
        $totalJuros = $saldoFinanciado
            * JUROS_MENSAL
            * $numeroParcelas;

        // Valor total financiado + juros
        $valorTotalComJuros = $saldoFinanciado + $totalJuros;

        // Valor de cada parcela
        $valorParcela = $valorTotalComJuros / $numeroParcelas;

        // Guardar os resultados
        $resultado = [
            "valorVeiculo" => $valorVeiculo,
            "valorEntrada" => $valorEntrada,
            "saldoFinanciado" => $saldoFinanciado,
            "totalJuros" => $totalJuros,
            "valorTotal" => $valorTotalComJuros,
            "valorParcela" => $valorParcela,
            "numeroParcelas" => $numeroParcelas
        ];
    }
}

// ==========================================
// FUNÇÃO PARA FORMATAR VALORES EM REAL
// ==========================================

function formatarMoeda(float $valor): string
{
    return "R$ " . number_format($valor, 2, ",", ".");
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Simulador de Financiamento</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 500px;
            margin: 30px auto;
            padding: 20px;
        }

        .campo {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input,
        select {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        .erros {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 15px;
        }

        .resultado {
            background-color: #e2e3e5;
            padding: 15px;
            border-radius: 4px;
            margin-top: 20px;
        }
    </style>
</head>

<body>

    <h2>Simulador de Financiamento</h2>

    <!-- ==========================================
         EXIBIR ERROS
         ========================================== -->

    <?php if (!empty($erros)): ?>

        <div class="erros">

            <ul style="margin: 0; padding-left: 20px;">

                <?php foreach ($erros as $erro): ?>

                    <li>
                        <?= htmlspecialchars($erro) ?>
                    </li>

                <?php endforeach; ?>

            </ul>

        </div>

    <?php endif; ?>


    <!-- ==========================================
         FORMULÁRIO
         ========================================== -->

    <form method="POST" action="ex04_simulador_financiamento.php">

        <div class="campo">

            <label for="valorVeiculo">
                Valor do Veículo (R$):
            </label>

            <input
                type="number"
                step="0.01"
                id="valorVeiculo"
                name="valorVeiculo"
                value="<?= htmlspecialchars($_POST['valorVeiculo'] ?? '') ?>"
                required
            >

        </div>


        <div class="campo">

            <label for="valorEntrada">
                Valor da Entrada (R$):
            </label>

            <input
                type="number"
                step="0.01"
                id="valorEntrada"
                name="valorEntrada"
                value="<?= htmlspecialchars($_POST['valorEntrada'] ?? '') ?>"
                required
            >

        </div>


        <div class="campo">

            <label for="numeroParcelas">
                Número de Parcelas:
            </label>

            <select
                id="numeroParcelas"
                name="numeroParcelas"
                required
            >

                <option value="">
                    Selecione...
                </option>

                <?php foreach (PARCELAS_PERMITIDAS as $opcao): ?>

                    <option
                        value="<?= $opcao ?>"
                        <?= (
                            isset($_POST['numeroParcelas']) &&
                            $_POST['numeroParcelas'] == $opcao
                        ) ? 'selected' : '' ?>
                    >
                        <?= $opcao ?>x
                    </option>

                <?php endforeach; ?>

            </select>

        </div>


        <button type="submit">
            Calcular Financiamento
        </button>

    </form>


    <!-- ==========================================
         MEMÓRIA DE CÁLCULO
         ========================================== -->

    <?php if ($resultado !== null): ?>

        <div class="resultado">

            <h3>Memória de Cálculo</h3>

            <p>
                <strong>Valor do Veículo:</strong>
                <?= formatarMoeda($resultado["valorVeiculo"]) ?>
            </p>

            <p>
                <strong>Valor da Entrada:</strong>
                <?= formatarMoeda($resultado["valorEntrada"]) ?>
            </p>

            <hr>

            <p>
                <strong>Valor Financiado:</strong>
                <?= formatarMoeda($resultado["saldoFinanciado"]) ?>
            </p>

            <p>
                <strong>Total de Juros (1,5% a.m.):</strong>
                <?= formatarMoeda($resultado["totalJuros"]) ?>
            </p>

            <p>
                <strong>Valor Total com Juros:</strong>
                <?= formatarMoeda($resultado["valorTotal"]) ?>
            </p>

            <p>
                <strong>Valor de Cada Parcela:</strong>

                <?= $resultado["numeroParcelas"] ?>x de

                <strong>
                    <?= formatarMoeda($resultado["valorParcela"]) ?>
                </strong>

            </p>

        </div>

    <?php endif; ?>

</body>

</html>
```
