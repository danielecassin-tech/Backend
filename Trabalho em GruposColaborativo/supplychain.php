<?php
declare(strict_types=1);

/**
 * Dados mockados das cotações abertas.
 */
$cotacoesAbertas = [
    [
        'id' => 1,
        'fornecedor' => 'Eletro Parts Ltda',
        'email' => 'contato@eletroparts.com.br',
        'categoria' => 'Eletrônicos',
        'descricao' => 'Bobinas de cobre 2mm - 100kg',
        'valor' => 4500.00,
        'prazo' => 7,
        'condicao' => '30 dias',
        'data_abertura' => '2026-09-10'
    ],
    [
        'id' => 2,
        'fornecedor' => 'Peças Mecânicas do Brasil',
        'email' => 'vendas@pecasmec.com.br',
        'categoria' => 'Mecânica',
        'descricao' => 'Rolamentos de esferas NSK 6204',
        'valor' => 1250.50,
        'prazo' => 5,
        'condicao' => 'À Vista',
        'data_abertura' => '2026-09-12'
    ],
    [
        'id' => 3,
        'fornecedor' => 'Supply Express',
        'email' => 'compras@supplyexpress.com.br',
        'categoria' => 'Consumíveis',
        'descricao' => 'Óleo hidráulico ISO 46 - 200L',
        'valor' => 2100.00,
        'prazo' => 3,
        'condicao' => '60 dias',
        'data_abertura' => '2026-09-15'
    ],
    [
        'id' => 4,
        'fornecedor' => 'Serviços Técnicos SENAI',
        'email' => 'servicos@senaigeral.com.br',
        'categoria' => 'Serviços',
        'descricao' => 'Manutenção preventiva - 40h',
        'valor' => 3200.00,
        'prazo' => 1,
        'condicao' => '30 dias',
        'data_abertura' => '2026-09-14'
    ],
    [
        'id' => 5,
        'fornecedor' => 'Eletrônicos Avançados SA',
        'email' => 'vendas@eletravanc.com.br',
        'categoria' => 'Eletrônicos',
        'descricao' => 'Transformador 10kVA 220/110',
        'valor' => 8750.00,
        'prazo' => 15,
        'condicao' => '90 dias',
        'data_abertura' => '2026-09-11'
    ],
    [
        'id' => 6,
        'fornecedor' => 'Plásticos Industriais',
        'email' => 'venda@plasticosindustriais.com.br',
        'categoria' => 'Consumíveis',
        'descricao' => 'Tubos PVC 75mm - 50 metros',
        'valor' => 650.00,
        'prazo' => 2,
        'condicao' => 'À Vista',
        'data_abertura' => '2026-09-13'
    ],
    [
        'id' => 7,
        'fornecedor' => 'Automação Industrial Plus',
        'email' => 'suporte@autoplus.com.br',
        'categoria' => 'Eletrônicos',
        'descricao' => 'CLP Siemens S7-1200',
        'valor' => 15800.00,
        'prazo' => 21,
        'condicao' => '60 dias',
        'data_abertura' => '2026-09-09'
    ],
    [
        'id' => 8,
        'fornecedor' => 'Consultoria Técnica Premium',
        'email' => 'info@consultoriatech.com.br',
        'categoria' => 'Serviços',
        'descricao' => 'Auditoria de processos - 3 dias',
        'valor' => 5600.00,
        'prazo' => 5,
        'condicao' => '30 dias',
        'data_abertura' => '2026-09-08'
    ]
];

const CATEGORIAS_PERMITIDAS = [
    'Eletrônicos',
    'Mecânica',
    'Consumíveis',
    'Serviços'
];

const CONDICOES_PAGAMENTO = [
    'À Vista',
    '30 dias',
    '60 dias',
    '90 dias'
];


/**
 * Formata um valor numérico para o padrão monetário brasileiro.
 *
 * @param float $valor
 * @return string
 */
function formatarMoeda(float $valor): string
{
    return 'R$ ' . number_format($valor, 2, ',', '.');
}


/**
 * Converte um valor informado pelo usuário para float.
 *
 * Aceita formatos como:
 * 4500
 * 4500.50
 * 4.500,50
 * R$ 4.500,50
 *
 * @param string $valor
 * @return float|false
 */
function converterValor(string $valor): float|false
{
    $valor = trim($valor);

    if ($valor === '') {
        return false;
    }

    // Remove R$ e espaços
    $valor = str_replace(['R$', ' '], '', $valor);

    // Se tiver ponto e vírgula, assume formato brasileiro
    if (str_contains($valor, ',') && str_contains($valor, '.')) {
        $valor = str_replace('.', '', $valor);
        $valor = str_replace(',', '.', $valor);
    } elseif (str_contains($valor, ',')) {
        // Exemplo: 4500,50
        $valor = str_replace(',', '.', $valor);
    }

    if (!is_numeric($valor)) {
        return false;
    }

    return (float) $valor;
}


/**
 * Valida uma nova cotação de fornecedor.
 *
 * @param array $dados Os dados do formulário.
 * @return array Erros encontrados.
 */
function validarCotacao(array $dados): array
{
    $erros = [];

    // Nome do fornecedor
    if (strlen(trim($dados['nome_fornecedor'] ?? '')) < 5) {
        $erros['nome_fornecedor'] =
            'O nome do fornecedor deve ter no mínimo 5 caracteres.';
    }

    // E-mail
    if (!filter_var(
        trim($dados['email_fornecedor'] ?? ''),
        FILTER_VALIDATE_EMAIL
    )) {
        $erros['email_fornecedor'] =
            'Informe um e-mail corporativo válido.';
    }

    // Categoria
    if (!in_array(
        $dados['categoria_produto'] ?? '',
        CATEGORIAS_PERMITIDAS,
        true
    )) {
        $erros['categoria_produto'] =
            'Selecione uma categoria permitida.';
    }

    // Descrição
    if (strlen(trim($dados['descricao_item'] ?? '')) < 10) {
        $erros['descricao_item'] =
            'A descrição deve ter no mínimo 10 caracteres.';
    }

    // Valor
    $valor = converterValor($dados['valor_cotacao'] ?? '');

    if ($valor === false || $valor <= 0) {
        $erros['valor_cotacao'] =
            'Informe um valor positivo em R$.';
    }

    // Prazo
    $prazo = filter_var(
        $dados['prazo_entrega_dias'] ?? '',
        FILTER_VALIDATE_INT
    );

    if ($prazo === false || $prazo < 1 || $prazo > 60) {
        $erros['prazo_entrega_dias'] =
            'O prazo deve estar entre 1 e 60 dias.';
    }

    // Condição de pagamento
    if (!in_array(
        $dados['condicoes_pagamento'] ?? '',
        CONDICOES_PAGAMENTO,
        true
    )) {
        $erros['condicoes_pagamento'] =
            'Selecione uma condição de pagamento válida.';
    }

    return $erros;
}


/**
 * Filtra as cotações por fornecedor e valor máximo.
 *
 * @param array $cotacoes Array de cotações.
 * @param string $fornecedor Nome parcial do fornecedor.
 * @param float|null $valorMaximo Valor máximo.
 * @return array Cotações filtradas.
 */
function filtrarCotacoes(
    array $cotacoes,
    string $fornecedor = '',
    ?float $valorMaximo = null
): array {
    return array_filter(
        $cotacoes,
        function ($cotacao) use ($fornecedor, $valorMaximo) {

            // Filtro por fornecedor
            if (
                $fornecedor !== '' &&
                stripos($cotacao['fornecedor'], $fornecedor) === false
            ) {
                return false;
            }

            // Filtro por valor máximo
            if (
                $valorMaximo !== null &&
                $cotacao['valor'] > $valorMaximo
            ) {
                return false;
            }

            return true;
        }
    );
}


/*
|--------------------------------------------------------------------------
| VARIÁVEIS DO FORMULÁRIO
|--------------------------------------------------------------------------
*/

$dadosFormulario = [
    'nome_fornecedor' => '',
    'email_fornecedor' => '',
    'categoria_produto' => '',
    'descricao_item' => '',
    'valor_cotacao' => '',
    'prazo_entrega_dias' => '',
    'condicoes_pagamento' => ''
];

$erros = [];
$mensagemSucesso = '';


/*
|--------------------------------------------------------------------------
| PROCESSAMENTO DO GET - FILTROS
|--------------------------------------------------------------------------
*/

$filtroFornecedor = trim($_GET['fornecedor'] ?? '');
$filtroValor = converterValor($_GET['valor_max'] ?? '');

if ($filtroValor === false) {
    $filtroValor = null;
}

$cotacoesFiltradas = filtrarCotacoes(
    $cotacoesAbertas,
    $filtroFornecedor,
    $filtroValor
);


/*
|--------------------------------------------------------------------------
| PROCESSAMENTO DO POST - NOVA COTAÇÃO
|--------------------------------------------------------------------------
*/

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Recebe os dados
    foreach ($dadosFormulario as $campo => $valor) {
        $dadosFormulario[$campo] = trim($_POST[$campo] ?? '');
    }

    // Valida
    $erros = validarCotacao($dadosFormulario);

    // Se não houver erros
    if (empty($erros)) {

        $valor = converterValor($dadosFormulario['valor_cotacao']);

        $novaCotacao = [
            'id' => count($cotacoesAbertas) + 1,
            'fornecedor' => $dadosFormulario['nome_fornecedor'],
            'email' => $dadosFormulario['email_fornecedor'],
            'categoria' => $dadosFormulario['categoria_produto'],
            'descricao' => $dadosFormulario['descricao_item'],
            'valor' => $valor,
            'prazo' => (int) $dadosFormulario['prazo_entrega_dias'],
            'condicao' => $dadosFormulario['condicoes_pagamento'],
            'data_abertura' => date('Y-m-d')
        ];

        $cotacoesAbertas[] = $novaCotacao;

        $mensagemSucesso = 'Cotação cadastrada com sucesso!';

        // Limpa o formulário depois do cadastro
        $dadosFormulario = [
            'nome_fornecedor' => '',
            'email_fornecedor' => '',
            'categoria_produto' => '',
            'descricao_item' => '',
            'valor_cotacao' => '',
            'prazo_entrega_dias' => '',
            'condicoes_pagamento' => ''
        ];

        // Atualiza a tabela
        $cotacoesFiltradas = $cotacoesAbertas;
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>SupplyChain - Cotações</title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f1f2f6;
            color: #2c3e50;
        }

        .container {
            max-width: 1400px;
            margin: auto;
        }

        h1 {
            color: #1e3799;
        }

        h2 {
            color: #1e3799;
            margin-top: 0;
        }

        .box {
            background: white;
            padding: 25px;
            margin-bottom: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        /* FILTROS */

        .filtros {
            display: grid;
            grid-template-columns: 1fr 1fr auto;
            gap: 15px;
            align-items: end;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 6px;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 11px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 15px;
        }

        textarea {
            min-height: 100px;
            resize: vertical;
        }

        button {
            padding: 11px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 15px;
            font-weight: bold;
        }

        .btn-filtrar {
            background: #1e3799;
            color: white;
        }

        .btn-filtrar:hover {
            background: #162d7a;
        }

        .btn-cadastrar {
            background: #27ae60;
            color: white;
            width: 100%;
            margin-top: 10px;
        }

        .btn-cadastrar:hover {
            background: #219150;
        }

        .btn-limpar {
            display: inline-block;
            margin-left: 10px;
            color: #555;
            text-decoration: none;
        }

        /* TABELA */

        .tabela-wrapper {
            overflow-x: auto;
        }

        .tabela-cotacoes {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: white;
        }

        .tabela-cotacoes thead {
            background: #1e3799;
            color: white;
        }

        .tabela-cotacoes th,
        .tabela-cotacoes td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        .tabela-cotacoes tbody tr:hover {
            background: #f9f9f9;
        }

        .valor-destaque {
            color: #27ae60;
            font-weight: bold;
            font-family: 'Courier New', monospace;
        }

        /* BADGES */

        .badge-categoria {
            display: inline-block;
            padding: 5px 9px;
            border-radius: 12px;
            font-size: 0.85em;
            font-weight: bold;
        }

        .eletronicos {
            background: #e3f2fd;
            color: #1565c0;
        }

        .mecanica {
            background: #f3e5f5;
            color: #6a1b9a;
        }

        .consumiveis {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .servicos {
            background: #fff3e0;
            color: #e65100;
        }

        /* FORMULÁRIO */

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px;
        }

        .campo-completo {
            grid-column: 1 / -1;
        }

        /* MENSAGENS */

        .erro {
            color: #c0392b;
            font-size: 14px;
            margin-top: 5px;
        }

        .campo-erro {
            border-color: #c0392b;
        }

        .sucesso {
            background: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        .sem-resultados {
            text-align: center;
            padding: 30px;
            color: #777;
        }

        /* RESPONSIVO */

        @media (max-width: 800px) {

            .filtros,
            .form-grid {
                grid-template-columns: 1fr;
            }

            .campo-completo {
                grid-column: auto;
            }

            body {
                padding: 10px;
            }

        }

    </style>

</head>

<body>

<div class="container">

    <h1>📦 SupplyChain</h1>

    <!-- =====================================================
         SEÇÃO A - FILTRO
    ====================================================== -->

    <div class="box">

        <h2>🔎 Filtro de Cotações</h2>

        <form method="GET">

            <div class="filtros">

                <div>

                    <label for="fornecedor">
                        Nome do fornecedor
                    </label>

                    <input
                        type="text"
                        id="fornecedor"
                        name="fornecedor"
                        placeholder="Digite o fornecedor"
                        value="<?= htmlspecialchars(
                            $filtroFornecedor,
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>"
                    >

                </div>

                <div>

                    <label for="valor_max">
                        Valor máximo
                    </label>

                    <input
                        type="text"
                        id="valor_max"
                        name="valor_max"
                        placeholder="Ex: R$ 5.000,00"
                        value="<?= htmlspecialchars(
                            $_GET['valor_max'] ?? '',
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>"
                    >

                </div>

                <div>

                    <button
                        type="submit"
                        class="btn-filtrar"
                    >
                        Filtrar
                    </button>

                    <a
                        href="supplychain.php"
                        class="btn-limpar"
                    >
                        Limpar
                    </a>

                </div>

            </div>

        </form>

    </div>


    <!-- =====================================================
         TABELA
    ====================================================== -->

    <div class="box">

        <h2>📋 Cotações Abertas</h2>

        <p>
            <?= count($cotacoesFiltradas) ?>
            cotação(ões) encontrada(s).
        </p>

        <div class="tabela-wrapper">

            <table class="tabela-cotacoes">

                <thead>

                    <tr>
                        <th>ID</th>
                        <th>Fornecedor</th>
                        <th>E-mail</th>
                        <th>Categoria</th>
                        <th>Descrição</th>
                        <th>Valor</th>
                        <th>Prazo</th>
                        <th>Pagamento</th>
                        <th>Abertura</th>
                    </tr>

                </thead>

                <tbody>

                <?php if (empty($cotacoesFiltradas)): ?>

                    <tr>

                        <td
                            colspan="9"
                            class="sem-resultados"
                        >
                            Nenhuma cotação encontrada.
                        </td>

                    </tr>

                <?php else: ?>

                    <?php foreach ($cotacoesFiltradas as $cotacao): ?>

                        <?php

                        $classeCategoria = match ($cotacao['categoria']) {

                            'Eletrônicos' => 'eletronicos',

                            'Mecânica' => 'mecanica',

                            'Consumíveis' => 'consumiveis',

                            'Serviços' => 'servicos',

                            default => ''
                        };

                        ?>

                        <tr>

                            <td>
                                <?= (int) $cotacao['id'] ?>
                            </td>

                            <td>
                                <?= htmlspecialchars(
                                    $cotacao['fornecedor'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>
                            </td>

                            <td>
                                <?= htmlspecialchars(
                                    $cotacao['email'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>
                            </td>

                            <td>

                                <span
                                    class="badge-categoria <?= $classeCategoria ?>"
                                >
                                    <?= htmlspecialchars(
                                        $cotacao['categoria'],
                                        ENT_QUOTES,
                                        'UTF-8'
                                    ) ?>
                                </span>

                            </td>

                            <td>
                                <?= htmlspecialchars(
                                    $cotacao['descricao'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>
                            </td>

                            <td class="valor-destaque">

                                <?= formatarMoeda(
                                    (float) $cotacao['valor']
                                ) ?>

                            </td>

                            <td>
                                <?= (int) $cotacao['prazo'] ?> dias
                            </td>

                            <td>
                                <?= htmlspecialchars(
                                    $cotacao['condicao'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>
                            </td>

                            <td>
                                <?= htmlspecialchars(
                                    $cotacao['data_abertura'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>
                            </td>

                        </tr>

                    <?php endforeach; ?>

                <?php endif; ?>

                </tbody>

            </table>

        </div>

    </div>


    <!-- =====================================================
         SEÇÃO B - NOVA COTAÇÃO
    ====================================================== -->

    <div class="box">

        <h2>➕ Nova Cotação</h2>

        <?php if ($mensagemSucesso !== ''): ?>

            <div class="sucesso">
                <?= htmlspecialchars(
                    $mensagemSucesso,
                    ENT_QUOTES,
                    'UTF-8'
                ) ?>
            </div>

        <?php endif; ?>


        <form method="POST">

            <div class="form-grid">

                <!-- FORNECEDOR -->

                <div>

                    <label for="nome_fornecedor">
                        Nome do fornecedor *
                    </label>

                    <input
                        type="text"
                        id="nome_fornecedor"
                        name="nome_fornecedor"
                        value="<?= htmlspecialchars(
                            $dadosFormulario['nome_fornecedor'],
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>"
                    >

                    <?php if (isset($erros['nome_fornecedor'])): ?>

                        <div class="erro">
                            <?= htmlspecialchars(
                                $erros['nome_fornecedor'],
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
                        </div>

                    <?php endif; ?>

                </div>


                <!-- EMAIL -->

                <div>

                    <label for="email_fornecedor">
                        E-mail do fornecedor *
                    </label>

                    <input
                        type="text"
                        id="email_fornecedor"
                        name="email_fornecedor"
                        value="<?= htmlspecialchars(
                            $dadosFormulario['email_fornecedor'],
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>"
                    >

                    <?php if (isset($erros['email_fornecedor'])): ?>

                        <div class="erro">
                            <?= htmlspecialchars(
                                $erros['email_fornecedor'],
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
                        </div>

                    <?php endif; ?>

                </div>


                <!-- CATEGORIA -->

                <div>

                    <label for="categoria_produto">
                        Categoria do produto *
                    </label>

                    <select
                        id="categoria_produto"
                        name="categoria_produto"
                    >

                        <option value="">
                            Selecione...
                        </option>

                        <?php foreach (
                            CATEGORIAS_PERMITIDAS
                            as $categoria
                        ): ?>

                            <option
                                value="<?= htmlspecialchars(
                                    $categoria,
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>"
                                <?= $dadosFormulario[
                                    'categoria_produto'
                                ] === $categoria
                                    ? 'selected'
                                    : '' ?>
                            >
                                <?= htmlspecialchars(
                                    $categoria,
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>
                            </option>

                        <?php endforeach; ?>

                    </select>

                    <?php if (isset($erros['categoria_produto'])): ?>

                        <div class="erro">
                            <?= htmlspecialchars(
                                $erros['categoria_produto'],
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
                        </div>

                    <?php endif; ?>

                </div>


                <!-- VALOR -->

                <div>

                    <label for="valor_cotacao">
                        Valor da cotação *
                    </label>

                    <input
                        type="text"
                        id="valor_cotacao"
                        name="valor_cotacao"
                        placeholder="Ex: R$ 4.500,00"
                        value="<?= htmlspecialchars(
                            $dadosFormulario['valor_cotacao'],
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>"
                    >

                    <?php if (isset($erros['valor_cotacao'])): ?>

                        <div class="erro">
                            <?= htmlspecialchars(
                                $erros['valor_cotacao'],
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
                        </div>

                    <?php endif; ?>

                </div>


                <!-- DESCRIÇÃO -->

                <div class="campo-completo">

                    <label for="descricao_item">
                        Descrição do item *
                    </label>

                    <textarea
                        id="descricao_item"
                        name="descricao_item"
                        minlength="10"
                    ><?= htmlspecialchars(
                        $dadosFormulario['descricao_item'],
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?></textarea>

                    <?php if (isset($erros['descricao_item'])): ?>

                        <div class="erro">
                            <?= htmlspecialchars(
                                $erros['descricao_item'],
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
                        </div>

                    <?php endif; ?>

                </div>


                <!-- PRAZO -->

                <div>

                    <label for="prazo_entrega_dias">
                        Prazo de entrega *
                    </label>

                    <input
                        type="number"
                        id="prazo_entrega_dias"
                        name="prazo_entrega_dias"
                        min="1"
                        max="60"
                        value="<?= htmlspecialchars(
                            $dadosFormulario[
                                'prazo_entrega_dias'
                            ],
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>"
                    >

                    <?php if (isset($erros['prazo_entrega_dias'])): ?>

                        <div class="erro">
                            <?= htmlspecialchars(
                                $erros['prazo_entrega_dias'],
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
                        </div>

                    <?php endif; ?>

                </div>


                <!-- PAGAMENTO -->

                <div>

                    <label for="condicoes_pagamento">
                        Condições de pagamento *
                    </label>

                    <select
                        id="condicoes_pagamento"
                        name="condicoes_pagamento"
                    >

                        <option value="">
                            Selecione...
                        </option>

                        <?php foreach (
                            CONDICOES_PAGAMENTO
                            as $condicao
                        ): ?>

                            <option
                                value="<?= htmlspecialchars(
                                    $condicao,
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>"
                                <?= $dadosFormulario[
                                    'condicoes_pagamento'
                                ] === $condicao
                                    ? 'selected'
                                    : '' ?>
                            >
                                <?= htmlspecialchars(
                                    $condicao,
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>
                            </option>

                        <?php endforeach; ?>

                    </select>

                    <?php if (
                        isset($erros['condicoes_pagamento'])
                    ): ?>

                        <div class="erro">
                            <?= htmlspecialchars(
                                $erros['condicoes_pagamento'],
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
                        </div>

                    <?php endif; ?>

                </div>


                <!-- BOTÃO -->

                <div class="campo-completo">

                    <button
                        type="submit"
                        class="btn-cadastrar"
                    >
                        Cadastrar Cotação
                    </button>

                </div>

            </div>

        </form>

    </div>

</div>

</body>

</html>

