<?php
declare(strict_types=1);

require_once __DIR__ . '/ConexaoBanco.php';

const ARQUIVO_CONFIG = __DIR__ . '/config/database.ini';

// Registra mensagens com níveis permitidos.
function registrarLog(string $nivel, string $mensagem): void
{
    $niveis = ['INFO', 'WARNING', 'ERROR'];

    if (!in_array($nivel, $niveis, true)) {
        throw new InvalidArgumentException('Nível de log inválido.');
    }

    $pasta = __DIR__ . '/logs';
    if (!is_dir($pasta)) {
        mkdir($pasta, 0770, true);
    }

    $linha = sprintf(
        "[%s] [%s] %s%s",
        date('Y-m-d H:i:s'),
        $nivel,
        $mensagem,
        PHP_EOL
    );

    file_put_contents($pasta . '/sistema.log', $linha, FILE_APPEND | LOCK_EX);
}

try {
    $pdo = ConexaoBanco::obterConexao(ARQUIVO_CONFIG);
    $pdo->query('SELECT 1');

    registrarLog('INFO', 'Conexão com PostgreSQL realizada.');
    echo "Conexão OK. Log INFO registrado.\n";
} catch (Throwable $erro) {
    registrarLog('ERROR', 'Falha na conexão com PostgreSQL.');
    echo "Conexão falhou. Log ERROR registrado.\n";
    exit(1);
}
