<?php
declare(strict_types=1);

require_once __DIR__ . '/conexao.php';

class PecasDAO
{
    public function __construct(private PDO $pdo)
    {
    }

    // Desativa a peça sem remover seu registro.
    public function excluir(int $id): bool
    {
        $stmt = $this->pdo->prepare(
            'UPDATE pecas_industriais SET ativo = FALSE WHERE id = :id'
        );
        $stmt->execute(['id' => $id]);
        return $stmt->rowCount() > 0;
    }

    // Lista somente as peças ativas.
    public function listarTodos(): array
    {
        $stmt = $this->pdo->prepare(
            'SELECT id, nome, quantidade FROM pecas_industriais
             WHERE ativo = TRUE ORDER BY id'
        );
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Consulta inclusive os registros desativados para auditoria.
    public function consultarAuditoria(int $id): array|false
    {
        $stmt = $this->pdo->prepare(
            'SELECT id, nome, quantidade, ativo
             FROM pecas_industriais WHERE id = :id'
        );
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }
}

try {
    $dao = new PecasDAO(conectar());

    // Use um ID existente para testar a exclusão lógica.
    $id = filter_var($_GET['id'] ?? 1, FILTER_VALIDATE_INT);
    if ($id === false || $id < 1) {
        exit('ID inválido.');
    }

    if (isset($_GET['excluir'])) {
        echo $dao->excluir($id) ? 'Peça desativada.' : 'Peça não encontrada ou já desativada.';
    }

    echo '<h1>Peças ativas</h1><ul>';
    foreach ($dao->listarTodos() as $peca) {
        echo '<li>' . htmlspecialchars($peca['nome'], ENT_QUOTES, 'UTF-8');
        echo ' — Quantidade: ' . (int) $peca['quantidade'] . '</li>';
    }
    echo '</ul>';

    $registro = $dao->consultarAuditoria($id);
    if ($registro !== false) {
        echo '<h2>Consulta de auditoria</h2>';
        echo '<p>ID: ' . (int) $registro['id'] . '</p>';
        echo '<p>Ativo: ' . ($registro['ativo'] ? 'Sim' : 'Não') . '</p>';
    }
} catch (Throwable $erro) {
    echo 'Erro ao consultar as peças. Verifique a conexão e a tabela.';
}
