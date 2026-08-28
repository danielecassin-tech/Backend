<?php
// utilitarios.php
declare(strict_types=1);

/**
 * 1. Formata um número para moeda Brasileira
 */
function formatarMoeda(float $valor): string {
    return "R$ " . number_format($valor, 2, ',', '.');
}

/**
 * 2. Remove pontos e traços (Deixa só os números)
 */
function limparDocumento(string $docSujeira): string {
    return str_replace(['.', '-'], '', $docSujeira);
}

/**
 * 3. Aplica desconto na variável original usando Referência (&)
 */
function aplicarDesconto(float &$preco, float $porcentagem): void {
    $desconto = $preco * ($porcentagem / 100);
    $preco -= $desconto;
}

/**
 * 4. Gera as iniciais do nome
 */
function gerarIniciais(string $nomeCompleto): string {
    $palavras = explode(" ", $nomeCompleto);

    $iniciais = "";

    foreach ($palavras as $palavra) {
        if ($palavra !== "") {
            $iniciais .= substr($palavra, 0, 1);
        }
    }

    return strtoupper($iniciais);
}
?>