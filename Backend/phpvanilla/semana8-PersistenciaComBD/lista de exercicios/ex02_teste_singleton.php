<?php
declare(strict_types=1);

require_once __DIR__ . '/ConexaoBanco.php';

const ARQUIVO_CONFIG = __DIR__ . '/config/database.ini';

try {
    $conexao1 = ConexaoBanco::obterConexao(ARQUIVO_CONFIG);
    $conexao2 = ConexaoBanco::obterConexao(ARQUIVO_CONFIG);

    echo "Objeto 1: " . spl_object_id($conexao1) . "\n";
    echo "Objeto 2: " . spl_object_id($conexao2) . "\n";

    if ($conexao1 === $conexao2) {
        echo "Singleton funcionando: mesma instância!\n";
    } else {
        echo "Foram obtidas instâncias diferentes.\n";
    }
} catch (PDOException $erro) {
    exit("Não foi possível conectar ao banco.\n");
}