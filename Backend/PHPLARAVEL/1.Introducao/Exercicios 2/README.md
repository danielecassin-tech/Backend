#### Parte A: Questões Teóricas de Fixação

1. Semântica RESTful
Uma ação de exclusão nunca deve ser realizada por uma requisição HTTP do tipo GET porque esse método deve ser utilizado apenas para consultar informações, sem modificar ou apagar dados do sistema. Se uma exclusão fosse feita por GET, robôs de busca, como o Google, poderiam acessar automaticamente o endereço e acabar apagando informações sem autorização. Por isso, utilizamos o método DELETE para excluir registros, mantendo a segurança e a organização da aplicação.
2. Idempotência
Idempotência significa que uma requisição pode ser executada várias vezes e produzir o mesmo resultado final de quando foi executada apenas uma vez. O método PUT é considerado idempotente porque atualizar um registro várias vezes com os mesmos dados não altera o resultado final. Já o POST não é idempotente, pois cada envio pode criar um novo registro no banco de dados, gerando informações duplicadas.
3. Resource Controllers
O comando php artisan make:controller --resource cria um controller com sete ações principais:
1. index(): Exibe a lista de registros cadastrados.
2. create(): Exibe o formulário para cadastrar um novo registro.
3. store(): Recebe os dados do formulário e salva um novo registro.
4. show(): Exibe os detalhes de um registro específico.
5. edit(): Exibe o formulário para editar um registro existente.
6. update(): Recebe os dados alterados e atualiza o registro no banco de dados.
7. destroy(): Exclui um registro do sistema.
Essas ações facilitam a organização do código e seguem um padrão de desenvolvimento utilizado pelo Laravel.
4. Injeção de Dependências
O Service Container é um recurso do Laravel responsável por gerenciar e fornecer automaticamente as dependências necessárias para o funcionamento da aplicação. Quando declaramos Request $request como parâmetro de um método do controller, o Laravel identifica que precisamos de um objeto Request e entrega uma instância automaticamente. Dessa forma, não precisamos utilizar new Request(), deixando o código mais simples, organizado e fácil de manter.
5. Method Spoofing
Os navegadores web possuem uma limitação nos formulários HTML convencionais, que permitem enviar requisições apenas pelos métodos GET e POST. Por isso, não conseguem enviar diretamente requisições PUT e DELETE através de formulários comuns.

O Laravel resolve essa limitação utilizando o recurso chamado Method Spoofing. Dentro do formulário, podemos utilizar a diretiva @method('PUT') ou @method('DELETE'), que informa ao Laravel qual método HTTP deve ser interpretado na requisição.
6. Ataques CSRF
CSRF significa Cross-Site Request Forgery e é um tipo de ataque em que um site malicioso tenta realizar ações em outro sistema utilizando a sessão de um usuário que já está autenticado.

O Laravel oferece proteção contra esse ataque por meio da diretiva Blade @csrf, que gera um token de segurança exclusivo para a sessão. Esse token precisa ser enviado junto com o formulário e validado pelo Laravel. Assim, o sistema consegue identificar requisições falsas que não possuem um token válido.
7. Constraints de Rota
As Constraints de Rota servem para restringir os valores que podem ser recebidos pelos parâmetros de uma URL. Por exemplo, whereNumber('id') permite que o parâmetro receba somente números, enquanto whereAlphaNumeric('codigo') permite letras e números.

Quando o formato informado não corresponde à restrição definida, o Laravel não encontra uma rota compatível e retorna o código HTTP 404 (Not Found), indicando que a página ou rota não foi encontrada.
8. Rotas Nomeadas
As rotas nomeadas permitem identificar os endereços da aplicação por nomes, utilizando a função route('clientes.show', $id).

Duas vantagens importantes são:
- Facilidade de manutenção: Se o endereço da rota mudar, não precisamos alterar todos os links espalhados pelas views, pois basta atualizar a definição da rota.
- Organização e redução de erros: Os nomes facilitam a identificação dos caminhos da aplicação e evitam erros causados por URLs escritas manualmente.
Isso torna o sistema mais organizado e facilita o trabalho de toda a equipe de desenvolvimento.
9. Single Responsibility no Controller
O princípio Single Responsibility determina que cada parte do sistema deve possuir uma responsabilidade específica. Por isso, os controllers devem ser responsáveis principalmente por receber as requisições, organizar o fluxo da aplicação e retornar as respostas.

A validação pode ser feita com $request->validate() ou com Form Requests, que permitem separar regras mais complexas em classes próprias. Manter os métodos curtos, com até 20 linhas, facilita a leitura, os testes, a manutenção e evita que o controller fique sobrecarregado com muitas responsabilidades.
10. A Ferramenta route:list
O comando php artisan route:list permite visualizar todas as rotas cadastradas em uma aplicação Laravel. Ele apresenta informações como o método HTTP, o endereço da rota, o nome da rota e o controller responsável por executar cada ação.

Essa ferramenta ajuda as equipes de desenvolvimento a documentar, organizar e auditar os endpoints disponíveis. Também facilita a identificação de rotas duplicadas, erros de configuração e métodos HTTP utilizados incorretamente, tornando o desenvolvimento e a manutenção da aplicação mais eficientes.