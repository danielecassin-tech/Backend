Exercícios Teóricos:

1. Conceito de função: Explique com suas palavras o que é uma função e cite duas vantagens de dividir um programa em funções.

- Uma função é um bloco de código que executa uma tarefa específica e pode ser reutilizado várias vezes em um programa. Dividir um código em funções deixa o programa mais organizado e fácil de corrigir.

Vantagens:
* Reutilização de código: Você escreve o bloco uma vez e chama ele quando precisar, sem repetir linhas.
* Facilidade na manutenção: Fica mais simples achar e consertar um erro em uma parte pequena do que no programa inteiro.

2. Princípio DRY: Por que repetir o mesmo bloco de código em várias partes do sistema pode causar problemas de manutenção? Como uma função ajuda a evitar essa repetição?

- O princípio DRY (Don't Repeat Yourself ou "Não se repita") diz que cada parte do conhecimento em um sistema deve ter uma representação única e sem ambiguidade. Repetir código dificulta a manutenção e as funções ajudam a centralizar essa lógica em um único lugar.

 - Como uma função ajuda a evitar essa repetição?

* Ponto único: A lógica fica guardada dentro de apenas uma função.
* Fácil mudança: Se a regra mudar, você mexe só na função e todo o sistema é atualizado.
* Reutilização: Você pode chamar a mesma função várias vezes sem reescrever nada.
* Código limpo: O programa fica menor, mais organizado e fácil de arrumar.

3. Parâmetros e retorno: Explique a diferença entre um parâmetro e um valor retornado por uma função. Use a função abaixo como exemplo:

- Um parâmetro é o valor de entrada que você envia para dentro de uma função para ela trabalhar. Um valor retornado é a resposta final que a função devolve para você depois de terminar o trabalho.

function calcularTotal(float $preco, int $quantidade): float {
    return $preco * $quantidade;
}

4. Tipagem: Identifique o tipo de cada elemento na declaração
 function cadastrar(string $nome, int $idade): bool.

 * cadastrar: Função (o nome da ação que executa o código).
 * string: Tipo de dado textual para o parâmetro $nome.
 * int: Tipo de dado numérico inteiro para o parâmetro $idade.
 * bool: Tipo de dado booleano (verdadeiro ou falso) que indica o valor retornado pela função.
 
 5. void e return: Qual é a diferença entre uma função que retorna string e uma função que retorna void? Dê um exemplo de uso para cada uma.

- A principal diferença é que uma função que retorna string devolve um texto para quem a chamou, permitindo usar esse valor em outras partes do código. Já uma função com tipo de retorno void executa uma ação (como mostrar uma mensagem na tela), mas não devolve valor nenhum.

- Função que retorna string:
* Uma função com retorno do tipo string usa a palavra-chave return seguida de um texto. Você pode guardar esse resultado em uma variável.

* function criarSaudacao(nome) {
  return "Olá, " + nome + "!";
}

let mensagem = criarSaudacao("Ana"); 
// A variável 'mensagem' agora guarda o texto "Olá, Ana!"

- Função que retorna void:
* Uma função void (vazio) faz um trabalho, mas não entrega uma resposta numérica ou textual de volta. Ela apenas realiza uma tarefa e encerra.

* function exibirAlerta(aviso) {
  console.log("ALERTA: " + aviso);
  // Não usa 'return' para devolver valor
}

exibirAlerta("Bateria fraca"); 
// A função apenas imprime o texto no console, sem salvar nada.

6. Escopo: Por que a função abaixo não consegue acessar $cliente diretamente? Explique duas formas de corrigir o código e indique qual é a mais recomendada.

- $cliente = "Mariana";

function exibirCliente(): string {
    return $cliente;
}

* A função não acessa $cliente porque o PHP usa escopo local estrito. Variáveis fora de funções não ficam visíveis lá dentro de forma automática.

* Motivo do Erro:
- O PHP cria um escopo separado para cada função. 
- A variável $cliente vive no escopo global.
- A função exibirCliente() tenta ler uma variável que não existe no seu próprio espaço de trabalho.

* Duas Formas de Corrigi:
- Usar a palavra-chave global: Declare global $cliente; dentro da função para puxar a variável de fora.
- Passar o valor por parâmetro: Envie o valor de $cliente ao chamar a função, definindo um parâmetro string $cliente na assinatura dela.

* Qual é a Mais Recomendada?:
- Passar o valor por parâmetro é a melhor escolha.O uso de global cria dependências ocultas e dificulta a manutenção do código e a realização de testes.
- Se quiser, posso mostrar exemplos em código de como ficam essas duas formas de correção

7. Referência: O que muda quando um parâmetro é declarado como float &$valor? Explique a diferença entre alterar uma cópia e alterar a variável original.

* Quando um parâmetro é declarado como float &$valor em PHP, o E comercial (&) indica que a variável é passada por referência, e não por valor. Isso significa que a função não recebe uma cópia do número, mas sim um acesso direto à variável original na memória.
* Cópia vs Variável OriginalAlterar uma cópia:
-  (Passagem por valor): A função cria uma cópia do dado. Modificar o valor dentro da função não afeta a variável original fora dela.
- Alterar a variável original (Passagem por referência): A função usa o endereço de memória original. Qualquer mudança feita no parâmetro dentro da função muda o valor da variável original de forma imediata.

8. Funções nativas: Escolha cinco funções da tabela deste material e descreva: categoria, finalidade, parâmetros principais e valor retornado.

