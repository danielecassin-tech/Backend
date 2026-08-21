<?php
declare(strict_types=1);

declare(strict_types=1);

$produtos = [
    1 => ["nome" => "Coxinha", "preco" => 6.00, "estoque" => 10],
    2 => ["nome" => "Suco", "preco" => 5.00, "estoque" => 8],
    3 => ["nome" => "Sanduíche", "preco" => 12.00, "estoque" => 5],
    4 => ["nome" => "Bolo", "preco" => 7.50, "estoque" => 6]
];

$pedido = [];
$opcao = 0;

do {

    echo "\n===== CANTINA SENAI =====\n";
    echo "1 - Listar produtos\n";
    echo "2 - Adicionar produto ao pedido\n";
    echo "3 - Exibir resumo do pedido\n";
    echo "4 - Finalizar compra\n";
    echo "0 - Sair sem finalizar\n";

    $opcao = (int) readline("Escolha uma opção: ");

    $acao = match ($opcao) {
        1 => "listar",
        2 => "adicionar",
        3 => "resumo",
        4 => "finalizar",
        0 => "sair",
        default => "invalida"
    };
    if ($acao === "invalida") {

        echo "Opção inválida! Tente novamente.\n";

    } elseif ($acao === "listar") {

        echo "\n--- PRODUTOS ---\n";

        foreach ($produtos as $codigo => $produto) {

            echo "Código: $codigo | ";
            echo "Nome: {$produto['nome']} | ";
            echo "Preço: R$ "
                . number_format($produto['preco'], 2, ',', '.') . " | ";
            echo "Estoque: {$produto['estoque']}\n";
        }

    } elseif ($acao === "adicionar") {

        $codigo = (int) readline("Digite o código do produto: ");

        if (!isset($produtos[$codigo])) {

            echo "Produto inexistente! Voltando ao menu.\n";

        } elseif ($produtos[$codigo]['estoque'] <= 0) {

            echo "Produto sem estoque disponível.\n";

        } else {

            $quantidade = 0;

            while (
                $quantidade <= 0 ||
                $quantidade > $produtos[$codigo]['estoque']
            ) {
                $quantidade = (int) readline(
                    "Digite a quantidade (estoque: {$produtos[$codigo]['estoque']}): "
                );

                if ($quantidade <= 0) {

                    echo "Quantidade inválida. Digite um número maior que zero.\n";

                } elseif ($quantidade > $produtos[$codigo]['estoque']) {

                    echo "Quantidade maior que o estoque disponível.\n";
                }
            }

            if (isset($pedido[$codigo])) {

                $pedido[$codigo]['quantidade'] += $quantidade;

            } else {

                $pedido[$codigo] = [
                    "nome" => $produtos[$codigo]['nome'],
                    "preco" => $produtos[$codigo]['preco'],
                    "quantidade" => $quantidade
                ];
            }

            $produtos[$codigo]['estoque'] -= $quantidade;

            echo "Produto adicionado ao pedido!\n";
        }
        } elseif ($acao === "resumo") {

        if (empty($pedido)) {

            echo "Nenhum produto foi adicionado ao pedido.\n";

        } else {

            echo "\n--- RESUMO DO PEDIDO ---\n";

            $total = 0.0;

            foreach ($pedido as $item) {

                $subtotal = $item['quantidade'] * $item['preco'];
                $total += $subtotal;

                echo "Nome: {$item['nome']} | ";
                echo "Quantidade: {$item['quantidade']} | ";
                echo "Preço unitário: R$ "
                    . number_format($item['preco'], 2, ',', '.') . " | ";
                echo "Subtotal: R$ "
                    . number_format($subtotal, 2, ',', '.') . "\n";
            }

            echo "Total: R$ "
                . number_format($total, 2, ',', '.') . "\n";
        }

    } elseif ($acao === "finalizar") {

        if (empty($pedido)) {

            echo "Não é possível finalizar: nenhum produto foi adicionado.\n";

        } else {
            $total = 0.0;

            foreach ($pedido as $item) {

                $total += $item['quantidade'] * $item['preco'];
            }

            echo "\n--- FINALIZAÇÃO ---\n";

            echo "Total da compra: R$ "
                . number_format($total, 2, ',', '.') . "\n";

            echo "1 - Pix (5% de desconto)\n";
            echo "2 - Cartão (sem desconto)\n";
            echo "3 - Dinheiro (3% de desconto)\n";

            $pagamento = (int) readline(
                "Escolha a forma de pagamento: "
            );

            $resultado = match ($pagamento) {
                1 => ["forma" => "Pix", "desconto" => 0.05],
                2 => ["forma" => "Cartão", "desconto" => 0.00],
                3 => ["forma" => "Dinheiro", "desconto" => 0.03],
                default => null
            };

            if ($resultado === null) {

                echo "Pagamento inválido.\n";

            } else {
                $desconto = $total * $resultado['desconto'];
                $totalFinal = $total - $desconto;

                echo "Pagamento: {$resultado['forma']}\n";

                echo "Desconto: R$ "
                    . number_format($desconto, 2, ',', '.') . "\n";

                echo "Total final: R$ "
                    . number_format($totalFinal, 2, ',', '.') . "\n";

                echo "Compra finalizada com sucesso!\n";

                break;
            }
        }

    } elseif ($acao === "sair") {

        echo "Saindo sem finalizar a compra.\n";

        break;
    }

} while ($opcao !== 4 && $opcao !== 0);

?>