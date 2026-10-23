<?php
declare(strict_types=1);

// Coloque o restante do seu código abaixo
require_once __DIR__ . '/conexao.php';

// Cadastra uma ferramenta usando parâmetros nomeados.
function cadastrar(PDO $pdo): void
{
    echo "Nome da ferramenta: ";
    $nome = trim((string) fgets(STDIN));
    echo "Descrição: ";
    $descricao = trim((string) fgets(STDIN));

    if ($nome === '' || $descricao === '') {
        echo "Preencha os dois campos.\n";
        return;
    }

    $sql = 'INSERT INTO ferramentas (nome, descricao)
            VALUES (:nome, :descricao)';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['nome' => $nome, 'descricao' => $descricao]);
    echo "Ferramenta cadastrada!\n";
}

// Lista somente ferramentas ativas.
function listar(PDO $pdo): void
{
    $stmt = $pdo->prepare(
        'SELECT id, nome, descricao FROM ferramentas
         WHERE ativo = :ativo ORDER BY id'
    );
    $stmt->execute(['ativo' => true]);

    foreach ($stmt->fetchAll() as $ferramenta) {
        echo "{$ferramenta['id']} - {$ferramenta['nome']}: ";
        echo "{$ferramenta['descricao']}\n";
    }
}

// Executa o menu interativo.
try {
    $pdo = conectar();
    do {
        echo "\n1 - Cadastrar ferramenta\n2 - Listar ativas\n3 - Sair\nOpção: ";
        $opcao = trim((string) fgets(STDIN));

        if ($opcao === '1') cadastrar($pdo);
        elseif ($opcao === '2') listar($pdo);
        elseif ($opcao !== '3') echo "Opção inválida.\n";
    } while ($opcao !== '3');

    echo "Programa encerrado.\n";
} catch (Throwable $erro) {
    echo "Erro ao acessar o banco de dados.\n";
    exit(1);
}
