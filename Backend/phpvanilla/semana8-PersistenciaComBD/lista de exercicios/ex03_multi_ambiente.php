<?php
declare(strict_types=1);

require_once __DIR__ . '/ConexaoBanco.php';

const ARQUIVO_CONFIG = __DIR__ . '/config/database.ini';

// Carrega os dados de um ambiente específico.
function carregarAmbiente(string $ambiente): array
{
    $config = parse_ini_file(ARQUIVO_CONFIG, true, INI_SCANNER_TYPED);

    if (!is_array($config) || !isset($config[$ambiente])) {
        throw new RuntimeException('Ambiente inválido.');
    }

    return $config[$ambiente];
}

$ambiente = $argv[1] ?? 'development';

try {
    $dados = carregarAmbiente($ambiente);
    $pdo = ConexaoBanco::obterConexao(ARQUIVO_CONFIG, $ambiente);

    echo "Ambiente: " . $ambiente . "\n";
    echo "Banco: " . $dados['db_name'] . "\n";
    echo "Conexão realizada com sucesso!\n";
} catch (Throwable $erro) {
    echo "Falha: confira o ambiente e as configurações.\n";
    exit(1);
}
