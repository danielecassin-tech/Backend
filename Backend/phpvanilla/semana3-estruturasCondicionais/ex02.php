<?php 
declare(strict_types=1)

//Exercício 2: O operador da 1 linha (E-commerce)

//Crie uma variável $valorCompra com um valor decimal (float).
//Utilizando exclusivamente o Operador Ternário (? :), crie uma variável $statusFrete.
//A regra é: Se a compra for maior ou igual a R$ 250.00, o status é "Frete Grátis". Caso contrário, o status é "Frete R$ 25,00".
//Exiba o resultado na tela.


$valorCompra = 150.60;

$statusFrete = $valorCompra>=250 ? "Frete Grátis" : "Frete R$ 25,00";

echo $statusFrete;


?>