<?php

declare(strict_types=1);

/**
 * Formata o nome do cliente.
 * Remove espaços desnecessários e coloca
 * a primeira letra de cada palavra em maiúscula.
 */
function formatarNome(string $nome): string
{
    $nome = trim($nome);
    $nome = strtolower($nome);
    $nome = ucwords($nome);

    return $nome;
}

/**
 * Remove pontos e traços do CPF.
 */
function limparCPF(string $cpf): string
{
    return str_replace(['.', '-'], '', trim($cpf));
}

/**
 * Valida se o CPF possui exatamente 11 números.
 */
function validarCPF(string $cpf): bool
{
    $cpf = limparCPF($cpf);

    return strlen($cpf) === 11 && ctype_digit($cpf);
}

/**
 * Valida um endereço de e-mail.
 */
function validarEmail(string $email): bool
{
    return filter_var(trim($email), FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Formata um valor para moeda brasileira.
 */
function formatarMoeda(float $valor): string
{
    return "R$ " . number_format($valor, 2, ',', '.');
}

/**
 * Procura um cliente pelo nome.
 * Retorna o cliente encontrado ou null.
 */
function buscarCliente(array $clientes, string $nome): ?array
{
    $nomePesquisa = strtolower(trim($nome));

    foreach ($clientes as $cliente) {
        $nomeCliente = strtolower(trim($cliente['nome']));

        if ($nomeCliente === $nomePesquisa) {
            return $cliente;
        }
    }

    return null;
}

/**
 * Calcula o total dos contratos dos clientes ativos.
 */
function calcularTotalContratosAtivos(array $clientes): float
{
    $total = 0.0;

    foreach ($clientes as $cliente) {
        if ($cliente['ativo'] === true) {
            $total += $cliente['contrato'];
        }
    }

    return $total;
}

/**
 * Calcula a média dos contratos.
 */
function calcularMediaContratos(array $clientes): float
{
    if (count($clientes) === 0) {
        return 0.0;
    }

    $total = 0.0;

    foreach ($clientes as $cliente) {
        $total += $cliente['contrato'];
    }

    return $total / count($clientes);
}

/**
 * Aplica um reajuste percentual no contrato.
 * O & faz com que o valor original seja alterado.
 */
function aplicarReajuste(float &$contrato, float $percentual): void
{
    $contrato = $contrato + ($contrato * $percentual / 100);
}

/**
 * Conta quantos clientes estão ativos.
 */
function contarClientesAtivos(array $clientes): int
{
    $quantidade = 0;

    foreach ($clientes as $cliente) {
        if ($cliente['ativo'] === true) {
            $quantidade++;
        }
    }

    return $quantidade;
}

/**
 * Encontra o maior contrato cadastrado.
 */
function maiorContrato(array $clientes): float
{
    if (count($clientes) === 0) {
        return 0.0;
    }

    $maior = $clientes[0]['contrato'];

    foreach ($clientes as $cliente) {
        if ($cliente['contrato'] > $maior) {
            $maior = $cliente['contrato'];
        }
    }

    return $maior;
}

/**
 * Valida os dados básicos de um cliente.
 */
function validarCliente(
    string $nome,
    string $cpf,
    string $email,
    float $contrato
): bool {
    return trim($nome) !== ''
        && validarCPF($cpf)
        && validarEmail($email)
        && $contrato > 0;
}

