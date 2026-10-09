<?php
declare(strict_types=1);

require_once __DIR__ . '/ConexaoBanco.php';

const ARQUIVO_CONFIG = __DIR__ . '/config/database.ini';

try {
    $pdo = ConexaoBanco::obterConexao(ARQUIVO_CONFIG);
    $versao = $pdo->query('SELECT version()')->fetchColumn();

    echo "Conexão realizada com sucesso!\n";
    echo "PostgreSQL: {$versao}\n";
} catch (PDOException $erro) {
    fwrite(STDERR, "Falha ao conectar. Verifique a porta e o banco.\n");
    exit(1);
} catch (Throwable $erro) {
    fwrite(STDERR, "Erro na configuração da conexão.\n");
    exit(1);
}