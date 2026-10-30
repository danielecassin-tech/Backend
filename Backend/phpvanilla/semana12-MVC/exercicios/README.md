1. O Colapso do Código Espaguete: Explique por que manter consultas SQL, regras de validação e marcação HTML no mesmo arquivo inviabiliza a manutenção e a escalabilidade de um sistema corporativo.

* Manter consultas SQL, regras de validação e marcação HTML no mesmo arquivo dificulta a manutenção porque mistura diferentes responsabilidades em um único lugar. O SQL é responsável por acessar o banco de dados, as regras de validação verificam se as informações estão corretas e o HTML organiza a apresentação para o usuário.

Quando tudo fica misturado, o código se torna desorganizado, difícil de entender e mais propenso a erros. Além disso, qualquer alteração pode afetar outras partes do sistema. Por isso, separar essas responsabilidades facilita a manutenção, a reutilização do código e o crescimento do sistema.

2. A Tríade MVC
O padrão MVC divide o sistema em três componentes, cada um com uma responsabilidade específica:
- Model (Modelo): responsável pelos dados, pelo acesso ao banco de dados e pelas regras de negócio.
- View (Visão): responsável pela parte visual do sistema, ou seja, aquilo que o usuário consegue visualizar e utilizar.
- Controller (Controlador): recebe as requisições do usuário, processa as solicitações e conecta o Model à View.
As regras de negócio devem ficar principalmente no Model, pois ele é responsável por controlar as operações e as regras que determinam o funcionamento do sistema.

3. O Papel do Composer
O composer.json é o arquivo que registra as dependências do projeto, ou seja, as bibliotecas necessárias para seu funcionamento, além das configurações do Autoload.

Já o composer.lock registra as versões exatas das dependências instaladas, garantindo que todos os desenvolvedores utilizem as mesmas versões.

A pasta vendor/ não deve ser versionada no Git porque contém as bibliotecas instaladas pelo Composer. Ela pode ser recriada executando o comando composer install, utilizando as informações do composer.lock. Isso evita arquivos desnecessários e mantém o repositório mais leve.
4. A Especificação PSR-4
O PSR-4 é um padrão utilizado pelo PHP para localizar automaticamente os arquivos das classes por meio de seus namespaces.

Por exemplo, quando o sistema procura a classe App\Controllers\ProdutoController, o Autoloader identifica que o namespace App\ corresponde à pasta src/. Em seguida, transforma o restante do namespace no caminho das pastas e do arquivo.

Assim, ele encontra automaticamente:

src/Controllers/ProdutoController.php

Isso evita a necessidade de utilizar vários comandos require ou include para carregar cada classe manualmente.
5. Front Controller
O Front Controller é uma estrutura que centraliza todas as requisições do sistema em um único arquivo, geralmente chamado public/index.php.

Sua principal vantagem de segurança é impedir que usuários acessem diretamente arquivos internos do projeto, como configurações, classes, conexões com o banco de dados e outros arquivos importantes.

Com isso, somente a pasta pública fica disponível para acesso pela internet, enquanto os arquivos-fonte permanecem protegidos fora da raiz pública. Isso também facilita o controle das requisições e a organização do sistema.
6. Roteador HTTP
O objeto Roteador diferencia as requisições utilizando dois elementos: o método HTTP e o endereço solicitado (URL).

Por exemplo:
- GET /produtos: solicita a visualização ou listagem dos produtos.
- POST /produtos: solicita o cadastro de um novo produto.
Mesmo que as duas requisições utilizem o mesmo endereço, o roteador consegue identificar que são operações diferentes por causa dos métodos HTTP. Dessa forma, ele direciona cada solicitação para o Controller responsável pela ação.
7. Injeção de Dados na View
A função nativa extract() transforma as chaves de um array em variáveis do PHP.

Por exemplo, quando o Controller envia um array contendo informações de produtos para uma View, a função extract() transforma essas informações em variáveis que podem ser utilizadas diretamente no arquivo HTML.

Assim, em vez de acessar os dados utilizando índices de um array o tempo inteiro, a View consegue utilizar variáveis com nomes mais simples.

Isso facilita a organização e a apresentação das informações na página.
8. Segurança contra XSS nas Views
A função htmlspecialchars() é utilizada para proteger o sistema contra ataques XSS (Cross-Site Scripting).

Esse tipo de ataque acontece quando alguém consegue inserir códigos HTML ou JavaScript maliciosos em campos do sistema, fazendo com que esses códigos sejam interpretados pelo navegador de outros usuários.

Ao utilizar htmlspecialchars(), caracteres especiais são convertidos em entidades HTML, impedindo que sejam interpretados como comandos executáveis no contexto HTML.

Por isso, todas as informações dinâmicas exibidas em tabelas e formulários devem passar por essa proteção, evitando que códigos maliciosos sejam executados no navegador.
9. Single Responsibility no Controller
O princípio Single Responsibility determina que cada parte do sistema deve possuir uma responsabilidade específica.

O Controller deve receber as requisições, chamar os métodos necessários do Model e decidir qual View será apresentada. Ele não deve realizar conexões diretas com o banco de dados utilizando new PDO() nem executar comandos SQL com strings concatenadas.

Isso acontece porque o acesso ao banco de dados é responsabilidade de outra camada do sistema.

Separar essas funções deixa o código mais organizado, facilita os testes, evita repetições e diminui o acoplamento entre as partes do projeto.
10. Transição para o Framework Laravel 11
Os conceitos aprendidos no MVC artesanal são os mesmos princípios utilizados pelo Laravel 11. O que muda é que o framework já oferece ferramentas prontas para facilitar o desenvolvimento.