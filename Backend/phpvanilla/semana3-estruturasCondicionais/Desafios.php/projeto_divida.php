<?php

declare(strict_types=1);
//fazer um painel financeiro de uma divida.
 
$categoria = "B";
$divida = 1000; //coloquei para começar 1000 reais de divida

$taxa = match ($categoria){ // Colocamos o valor de cada taxa
    'A' => 0.01,
    'B' => 0.02,
    'C' => 0.03,
    default => 0.05
    };

for ($mes = 1; $mes <= 12; $mes++) {
if ($mes == 6){
    echo "Mes 6 : insençao de juros";
    continue; //Usamos para pular, pois nesse mês não precisamos calcular o juros.
    }

$juros = $divida * $taxa;// Aqui calculo a divida com a taxa.
$divida = $divida + $juros; // E aqui eu calculo divida mais juros.
echo "Mes $mes: juros = R$ ". number_format($juros, 2, ',', '.')
. " | divida = R$ " . number_format($divida, 2, ',', '.') . "<br>"; //Usamos para que possa fazer calculo na tela para mostrar o resulytado de cada mes
}
    
?>
