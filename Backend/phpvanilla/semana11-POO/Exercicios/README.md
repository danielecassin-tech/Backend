### Parte A: Questões Teóricas de Fixação

1. Procedural vs. OO: Quais são os três principais riscos técnicos de manter regras financeiras críticas implementadas puramente através de arrays associativos e scripts procedurais?

- Os três principais riscos de utilizar arrays associativos e scripts procedurais em regras financeiras são a falta de segurança, a dificuldade de manutenção do código e a possibilidade de inconsistências nos dados financeiros.

2. Ciclo de Vida do Objeto: O que ocorre na memória Heap do servidor quando a instrução new ContaCorrente(...) é executada? Qual é o papel do método __construct() nesse processo?

- Quando o comando new ContaCorrente(...) é executado, o PHP cria um novo objeto na memória Heap do servidor, onde ficam armazenados seus atributos e dados. Em seguida, o método __construct() é chamado automaticamente para inicializar o objeto com as informações recebidas, como o nome do titular e o saldo inicial. Dessa forma, o objeto já pode começar a funcionar com os dados necessários.

3. A Pseudo-Variável $this: Explique por que o comando $this->saldo é obrigatório para acessar um atributo dentro da classe, diferenciando-o de uma variável local $saldo.

- A palavra-chave $this representa o próprio objeto que está executando um método. Por isso, usamos $this->saldo para acessar ou modificar o atributo saldo que pertence àquele objeto. Já a variável $saldo, sem $this, pode ser apenas uma variável local criada dentro de um método. A diferença é que o atributo pertence ao objeto e pode ser utilizado por diferentes métodos da classe, enquanto a variável local existe somente no seu contexto de execução.

4. Encapsulamento e Invariantes: Por que um desenvolvedor sênior de back-end nunca deve criar um método public function setSaldo(float $novoSaldo) para uma conta bancária?

- Não é recomendado criar um método público setSaldo(float $novoSaldo) em uma conta bancária porque ele permitiria que qualquer parte do sistema alterasse o saldo diretamente, sem realizar uma operação financeira válida. Por exemplo, alguém poderia definir um saldo de mil reais sem fazer um depósito de verdade. Para evitar esse problema, o saldo deve ser privado e alterado por métodos controlados, como depositar() e sacar(), que verificam as regras necessárias e mantêm os dados consistentes.

5. Modificadores de Acesso: Qual é a diferença prática entre os modificadores private e protected quando subclasses entram em cena através do extends?

- Os modificadores private e protected controlam quem pode acessar os atributos e métodos de uma classe. O private permite o acesso direto somente dentro da própria classe, impedindo que subclasses acessem diretamente aquele membro. Já o protected permite o acesso tanto dentro da classe original quanto dentro das classes filhas que herdam dela usando extends. Assim, o private oferece um controle mais restrito, enquanto o protected facilita o compartilhamento de funcionalidades entre classes relacionadas.

6. Constructor Property Promotion: Como o recurso de promoção de propriedades introduzido no PHP 8 reduz o boilerplate e melhora a legibilidade do código?

- O Constructor Property Promotion foi introduzido no PHP 8 para diminuir a repetição de código na criação de classes. Antes desse recurso, era necessário declarar os atributos da classe e depois atribuir os valores recebidos no construtor manualmente. Com a promoção de propriedades, podemos declarar os atributos diretamente nos parâmetros do construtor, utilizando modificadores como private. Isso deixa o código mais curto, organizado e fácil de entender, sem perder a possibilidade de controlar o acesso aos dados.

7. Propriedades readonly: Explique o mecanismo de segurança proporcionado pela palavra-chave readonly em atributos de classes de valor como Titular ou CPF.

- A palavra-chave readonly permite que uma propriedade seja inicializada uma vez e impede que receba outro valor posteriormente. Esse recurso é útil em classes que representam informações que não devem ser alteradas depois de definidas, como os dados de identificação de um titular ou um CPF. Dessa forma, o sistema reduz o risco de alterações acidentais e mantém as informações mais confiáveis. Entretanto, readonly protege a reatribuição da propriedade, não tornando automaticamente imutável todo o conteúdo de um objeto armazenado nela.

8. Classes Abstratas: Por que faz todo sentido no modelo bancário que a classe ContaBancaria seja declarada como abstract enquanto ContaCorrente e ContaPoupanca são classes concretas?

- Faz sentido declarar a classe ContaBancaria como abstrata porque ela representa um modelo geral de conta bancária, com características comuns, como titular, saldo, depósito e saque. Ela serve como base para outras classes, mas não pode ser instanciada diretamente. As classes ContaCorrente e ContaPoupanca são concretas porque representam tipos específicos de contas que podem ser criados e utilizados pelo sistema. Dessa maneira, as classes filhas aproveitam os recursos compartilhados e podem implementar regras particulares de cada tipo de conta.

9. Polimorfismo: Como o método transferir(float $valor, ContaBancaria $destino) consegue operar transferências entre quaisquer tipos de contas filhas sem precisar saber qual é a classe exata da conta de destino?

 - O polimorfismo permite que um método trabalhe com diferentes tipos de objetos que compartilham uma classe base ou um contrato comum. No caso do método transferir(float $valor, ContaBancaria $destino), o parâmetro $destino aceita objetos de ContaCorrente, ContaPoupanca ou outras subclasses de ContaBancaria. Assim, o método consegue realizar transferências sem precisar verificar manualmente qual é o tipo exato da conta de destino. Isso torna o código mais flexível, reutilizável e fácil de manter, desde que as regras de transferência sejam respeitadas.

10. Exceções de Domínio: Por que é uma péssima prática retornar false ou null quando uma operação de saque é rejeitada por falta de saldo?

- Retornar false ou null quando um saque é rejeitado por falta de saldo pode dificultar a identificação do problema, pois o sistema recebe apenas um resultado genérico e pode acabar ignorando a falha. O ideal é lançar uma exceção específica, como SaldoInsuficienteException, que informa claramente o motivo pelo qual a operação não po de ser realizada. Dessa forma, o sistema pode tratar o erro adequadamente, informar o usuário e impedir que uma operação financeira inválida seja considerada bem-sucedida.