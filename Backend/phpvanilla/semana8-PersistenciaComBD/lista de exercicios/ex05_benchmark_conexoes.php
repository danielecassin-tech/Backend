<?php
declare(strict_types=1);

require_once __DIR__ . '/ConexaoBanco.php';

const ARQUIVO_CONFIG = __DIR__ . '/config/database.ini';
const REPETICOES = 50;

// Mede tempo e variação de memória de uma operação.
function medir(callable $operacao): array
{
    gc_collect_cycles();
    $memoriaInicial = memory_get_usage();
    $inicio = hrtime(true);

    $operacao();

    return [
        'tempo' => (hrtime(true) - $inicio) / 1_000_000,
        'memoria' => memory_get_usage() - $memoriaInicial
    ];
}

// Abre e fecha uma conexão PDO a cada repetição.
function testarNovasConexoes(array $dados): void
{
    $dsn = sprintf(
        'pgsql:host=%s;port=%s;dbname=%s',
        $dados['db_host'],
        $dados['db_port'],
        $dados['db_name']
    );

    for ($i = 0; $i < REPETICOES; $i++) {
        $pdo = new PDO(
            $dsn,
            $dados['db_user'],
            $dados['db_pass'],
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
        $pdo->query('SELECT 1');
        unset($pdo);
    }
}

// Reutiliza a mesma conexão durante as repetições.
function testarSingleton(): void
{
    $pdo = ConexaoBanco::obterConexao(ARQUIVO_CONFIG);

    for ($i = 0; $i < REPETICOES; $i++) {
        $pdo->query('SELECT 1');
        ConexaoBanco::obterConexao(ARQUIVO_CONFIG);
    }
}

try {
    $config = parse_ini_file(ARQUIVO_CONFIG, true, INI_SCANNER_TYPED);
    $dados = $config['development'];

    // Mede as duas estratégias.
    $novas = medir(fn() => testarNovasConexoes($dados));
    $singleton = medir(fn() => testarSingleton());
} catch (Throwable $erro) {
    exit('Falha no benchmark. Confira o banco e a configuração.');
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Benchmark de Conexões</title>
</head>
<body>
    <h1>Benchmark de Conexões PDO</h1>
    <p>Quantidade de repetições: <?= REPETICOES ?></p>

    <table border="1" cellpadding="8">
        <thead>
            <tr>
                <th>Estratégia</th>
                <th>Tempo (ms)</th>
                <th>Variação de memória (bytes)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Novas conexões PDO</td>
                <td><?= number_format($novas['tempo'], 3, ',', '.') ?></td>
                <td><?= $novas['memoria'] ?></td>
            </tr>
            <tr>
                <td>Singleton</td>
                <td><?= number_format($singleton['tempo'], 3, ',', '.') ?></td>
                <td><?= $singleton['memoria'] ?></td>
            </tr>
        </tbody>
    </table>

    <p>Os resultados variam conforme o computador e o servidor PostgreSQL.</p>
</body>
</html>

