<?php
declare(strict_types=1);

require_once __DIR__ . '/conexao.php';

class EstoqueDAO
{
    public function __construct(private PDO $pdo)
    {
    }

    // Registra a movimentação e atualiza o saldo atomicamente.
    public function registrarMovimentacao(
        int $pecaId,
        int $quantidade,
        string $tipo
    ): bool {
        if ($quantidade <= 0 || !in_array($tipo, ['entrada', 'saida'], true)) {
            return false;
        }

        try {
            $this->pdo->beginTransaction();
            $sql = 'SELECT quantidade FROM pecas_industriais
                    WHERE id = :id AND ativo = TRUE FOR UPDATE';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['id' => $pecaId]);
            $peca = $stmt->fetch();

            if (!$peca) {
                $this->pdo->rollBack();
                return false;
            }

            $delta = $tipo === 'entrada' ? $quantidade : -$quantidade;
            if ((int) $peca['quantidade'] + $delta < 0) {
                $this->pdo->rollBack();
                return false;
            }

            $this->atualizarSaldo($pecaId, $delta);
            $this->inserirMovimentacao($pecaId, $quantidade, $tipo);
            $this->pdo->commit();
            return true;
        } catch (Throwable $erro) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }
            return false;
        }
    }

    // Atualiza o saldo da peça dentro da transação.
    private function atualizarSaldo(int $id, int $delta): void
    {
        $stmt = $this->pdo->prepare(
            'UPDATE pecas_industriais SET quantidade = quantidade + :delta
             WHERE id = :id'
        );
        $stmt->bindValue(':delta', $delta, PDO::PARAM_INT);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    // Registra o histórico para auditoria.
    private function inserirMovimentacao(
        int $id,
        int $quantidade,
        string $tipo
    ): void {
        $stmt = $this->pdo->prepare(
            'INSERT INTO movimentacoes_estoque (peca_id, quantidade, tipo)
             VALUES (:id, :quantidade, :tipo)'
        );
        $stmt->execute([
            'id' => $id,
            'quantidade' => $quantidade,
            'tipo' => $tipo
        ]);
    }
}

// Testa uma saída de 2 unidades da peça de ID 1.
try {
    $dao = new EstoqueDAO(conectar());
    $ok = $dao->registrarMovimentacao(1, 2, 'saida');
    echo $ok ? "Movimentação registrada.\n" : "Movimentação cancelada.\n";
} catch (Throwable $erro) {
    echo "Não foi possível conectar ao banco.\n";
}
