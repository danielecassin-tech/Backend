<?php

declare(strict_types=1);
//Desafio FinanSENAI
//Regra do Negocio:
//Classificação de Risco
//Projeção da divida
//Regra da Anistia

//fazer um painel financeiro de uma divida.
 
$categoriaCliente = "B";
$divida = 1000.00; //coloquei para começar 1000 reais de divida

//RF01 - Determinar o juros de Acordo com a Classificação de Risco

$taxa = match ($categoriaCliente){ // Colocamos o valor de cada taxa
    'A' => 0.01,
    'B' => 0.02,
    'C' => 0.03,
    default => 0.05
    };

//RF02 - Projeção da Dívida: Calcular o juros ao Longo de 12 meses
for ($mes = 1; $mes <= 12; $mes++) {
if ($mes == 6){//RF03 - Anistia da Dívida : não é cobrado Juros no mês6
    echo "Mes 6 : insençao de juros";
    continue; //Vai interromper a execução do laço Usamos para pular, pois nesse mês não precisamos calcular o juros.
    }
//Cálculo do Juros
$juros = $divida * $taxa;// Aqui calculo a divida com a taxa.
// adicione ao saldo devedor
$divida = $divida + $juros; // E aqui eu calculo divida mais juros.
echo "\nMes $mes: juros = R$ ". number_format($juros, 2, ',', '.')
. " | divida = R$ " . number_format($divida, 2, ',', '.') . "<br>"; //Usamos para que possa fazer calculo na tela para mostrar o resulytado de cada mes
}
    
?>
