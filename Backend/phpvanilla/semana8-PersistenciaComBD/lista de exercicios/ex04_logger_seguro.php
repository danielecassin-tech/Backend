<?php
declare(strict_types=1);

require_once __DIR__ . '/ConexaoBanco.php';

const ARQUIVO_CONFIG = __DIR__ . '/config/database.ini';

function registrarLog(string $nivel, string $mensagem): void
{
    $niveis = ['INFO', 'WARNING', 'ERROR'];

    if (!in_array($nivel, $niveis, true)) {
        throw new InvalidArgumentException('Nível de log inválido.');
    }

    $linha = sprintf(
        "[%s] [%s] %s%s",
        date('Y-m-d H:i:s'),
        $nivel,
        $mensagem,
        PHP_EOL
    );

    file_put_contents(
        __DIR__ . '/logs/sistema.log',
        $linha,
        FILE_APPEND | LOCK_EX
    );
}

try {
    $pdo = ConexaoBanco::obterConexao(ARQUIVO_CONFIG);
    $pdo->query('SELECT 1');

    registrarLog('INFO', 'Conexão com PostgreSQL realizada.');
    echo "Conexão realizada com sucesso.\n";
} catch (PDOException $erro) {
    registrarLog('ERROR', 'Falha na conexão: ' . $erro->getMessage());
    echo "Não foi possível conectar ao banco de dados.\n";
}