
<?php
declare(strict_types=1);

require_once __DIR__ . '/ConexaoBanco.php';

const ARQUIVO_CONFIG = __DIR__ . '/config/database.ini';

try {
    $pdo = ConexaoBanco::obterConexao(ARQUIVO_CONFIG);
    $versao = $pdo->query('SELECT version()')->fetchColumn();

    echo "Conexão com PostgreSQL realizada com sucesso!\n";
    echo "Porta configurada: 5432\n";
    echo "Versão: " . $versao . "\n";
} catch (Throwable $erro) {
    echo "Falha na conexão com PostgreSQL.\n";
    echo "Confira servidor, porta, banco, usuário e senha.\n";
    exit(1);
}
