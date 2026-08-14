<?php
declare(strict_types=1);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estudos de Variáveis</title>
</head>
<body>
    <h1>Estudos de Variáves</h1>
    <hr>
    <?php
    //para criar variáveis em php bata o sinal de $
    // variáveis em php são não tipadas, não precisa declara o tipo (Texto, números booleanas)
    // ao atribuir valor para a variável a tipagem é automatica
    $nome = "João"; // criação da variável nome com o valor textual "João"
    $idade = 25; //criação da variável idade com o valor numérico 25
    $ativo = true; // criação da variável ativo com o valor booleano true
    $salario = 1520.68; // Variavel numerica - decimal (float - double)
    $status = null; // variável null
    //$endereço; //Variavel Undefined, não é possivel declarar sem atribuir umm valor a ela, não existe Undefined em PHP

    //Dicas para criação de variáveis:
    // Não inicie o nome de uma variável com numeros
    // Não utilize espaços em branco
    // Não utilize caracteres especiais, somente o underline
    // Crie variáveis con nomes que ajudarão a indentificar melhor a mesma
    // Evite utilizar letras maiúsculas.
    
    //Exibir as variáveis na tela
    echo "Nome: $nome <br>";
    echo "Idade: $idade <br>";
    echo "Ativo: $ativo <br>";
    echo "Salario: $salario <br>";
    echo "Status $status <br>";


    echo "<br><h3> Constantes </h3><br>";
    // Constantes são representadas pela palavra "const" ou "define" seguidas do nome da constante
    // Exemplos de constantes
    const PI = 3.14; //Constantes do Tipo Number (float)
    const EMPRESA = "Google"; //Constante do Tipo String
    define("SITE", "www.google.com"); //Declaração de Constante do tipo string usando "define"
    // uma boa prática é urilizar letras maiúsculas para nomear constantes, para diferenciar das variáveis

    //Exibir as constantes na tela
    echo "Valor de PI: " . PI . "<br>";
    echo "Nome da Empressa: " . EMPRESA . "<br>";
    echo "Site: " . SITE . "<br";

    // tentar alterar o valor de uma constante, isso irá gerar um erro de código, pois constante não podem ser alteradas
    // PI = 3.141559; // isso é um erro
    // redeclarar uma constante também irá gerar um erro
    // const SITE = "www.google.com.br"; // Isso é um Erro

    // Regra de ouro: sempre coloque a instrução "declare(strict_types=1);" no início do seu código PHP,
    // isso blindará o seu sistema contra mistura acidentais de tipos de dados.


    //Utilização de Texto (Concatenação Vs Interpolação)

    //Exemplo de Concatenação => Juntar duas ou mais Strings utilizando p operador "." (ponto) 
    echo "Olá, ".$nome ."! Seja bem-vindo ao nosso site! <br>";

    //Exemplo de Interpolação => Utilização de variáveis dentro de um exto, utilizando aspas duplas no texto
    echo "$nome, tem $idade anos e seu alário é R$ $salario reais. <br>"; //forma mais correta de misturar texto e variáveis
  

    ?>

    
</body>
</html>