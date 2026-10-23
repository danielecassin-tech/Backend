<?php
declare(strict_types=1);

require_once __DIR__ . '/conexao.php';

// Demonstra o risco de concatenar texto diretamente na SQL.
function buscarVulneravel(PDO $pdo, string $termo): void
{
    $sql = "SELECT id, nome FROM ferramentas WHERE nome = '$termo'";
    echo "\nConsulta vulnerável: texto incorporado à SQL.\n";

    try {
        $resultado = $pdo->query($sql);
        echo "Registros encontrados: " . $resultado->rowCount() . "\n";
    } catch (PDOException $erro) {
        echo "A consulta falhou.\n";
    }
}

// Pesquisa com parâmetro separado da instrução SQL.
function buscarProtegido(PDO $pdo, string $termo): void
{
    $sql = 'SELECT id, nome FROM ferramentas WHERE nome = :termo';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['termo' => $termo]);

    echo "Consulta protegida. Registros encontrados: ";
    echo count($stmt->fetchAll()) . "\n";
}

try {
    $pdo = conectar();
    $ataque = "' OR '1'='1";

    echo "Teste de comparação SQL Injection\n";
    buscarVulneravel($pdo, $ataque);
    buscarProtegido($pdo, $ataque);
} catch (Throwable $erro) {
    echo "Não foi possível executar o teste.\n";
    exit(1);
}
