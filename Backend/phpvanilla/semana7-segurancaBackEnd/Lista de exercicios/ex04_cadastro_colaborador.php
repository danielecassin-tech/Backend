
<?php
declare(strict_types=1);

function e(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function sanitizarTexto(string $dado): string
{
    return trim(strip_tags($dado));
}

function validarColaborador(array $dados): array
{
    $erros = [];
    $nome = sanitizarTexto((string) ($dados['nome'] ?? ''));
    $email = trim((string) ($dados['email'] ?? ''));
    $matricula = filter_var($dados['matricula'] ?? null, FILTER_VALIDATE_INT);
    $salario = filter_var($dados['salario'] ?? null, FILTER_VALIDATE_FLOAT);

    if ($nome === '') $erros[] = 'Informe o nome.';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $erros[] = 'E-mail inválido.';
    if ($matricula === false || $matricula === null) $erros[] = 'Matrícula deve ser inteira.';
    if ($salario === false || $salario === null || $salario < 0) $erros[] = 'Salário inválido.';

    return [
        'erros' => $erros,
        'dados' => [
            'nome' => $nome,
            'email' => $email,
            'matricula' => $matricula,
            'salario' => $salario
        ]
    ];
}

$resultado = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $resultado = validarColaborador($_POST);
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Colaboradores</title>
</head>
<body>
    <h1>Cadastro de Colaboradores</h1>

    <form method="post">
        <label>Nome:
            <input name="nome" required>
        </label>
        <br>
        <label>E-mail:
            <input type="email" name="email" required>
        </label>
        <br>
        <label>Matrícula:
            <input type="number" name="matricula" step="1" required>
        </label>
        <br>
        <label>Salário:
            <input type="number" name="salario" min="0" step="any" required>
        </label>
        <br>
        <button type="submit">Cadastrar</button>
    </form>

    <?php if ($resultado !== null): ?>
        <?php if ($resultado['erros'] !== []): ?>
            <h2>Corrija os seguintes erros:</h2>
            <ul>
                <?php foreach ($resultado['erros'] as $erro): ?>
                    <li><?= e($erro) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <h2>Colaborador validado!</h2>
            <p>Nome: <?= e($resultado['dados']['nome']) ?></p>
            <p>E-mail: <?= e($resultado['dados']['email']) ?></p>
            <p>Matrícula: <?= e((string) $resultado['dados']['matricula']) ?></p>
            <p>Salário: R$ <?= e(number_format((float) $resultado['dados']['salario'], 2, ',', '.')) ?></p>
        <?php endif; ?>
    <?php endif; ?>
</body>
</html>
