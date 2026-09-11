## Resolução das Atividades do Bloco A Exercícios Teóricos

#### Diferença Estrutural: Explique a diferença física entre onde os dados são anexados em uma requisição `GET` e em uma requisição `POST`.

- Em uma requisição GET, os dados são anexados diretamente na URL, chamada também de Query String. Enquanto em uma requisição POST, a URL permanece limpa e os dados são enviados escondidos dentro do corpo (body) da mensagem HTTP.

#### Segurança e Privacidade: Por que senhas de usuário nunca devem ser enviadas via método GET? Cite pelo menos dois locais onde essa senha ficaria gravada de forma insegura.

- As senhas nunca devem ser enviadas pelo método GET porque elas ficam visíveis diretamente na URL. Isso pode causar problemas de segurança, pois a URL pode ser armazenada em diferentes lugares.

Por exemplo, a senha pode ficar gravada no histórico do navegador e também nos logs do servidor. Além disso, outras ferramentas de monitoramento podem registrar a URL completa.

Por isso, para enviar senhas, o recomendado é utilizar o método POST junto com HTTPS, que protege os dados durante o envio.

#### Coalescência Nula: Por que a instrução $nome = $_POST['nome']; dispara um Warning na primeira vez que a página é carregada no navegador? Como o operador ?? resolve isso?

- O Warning acontece porque, na primeira vez que a página é aberta, o formulário ainda não foi enviado. Portanto, $_POST['nome'] não existe.

O operador ?? verifica se o valor existe e, caso não exista, utiliza um valor padrão. Por exemplo:

$nome = $_POST['nome'] ?? '';


Assim, se nome não existir, será usado '' e o Warning não aparecerá.

#### Idempotência: O que significa dizer que uma requisição GET é idempotente? Por que atualizar ou deletar dados no banco usando links GET é uma má prática de segurança?

- Dizer que uma requisição GET é idempotente significa que ela pode ser repetida várias vezes sem causar uma nova alteração nos dados do sistema.

Usar GET para atualizar ou deletar dados do banco é uma má prática porque um simples clique em um link pode executar uma ação importante sem confirmação. Além disso, robôs, navegadores ou mecanismos de busca podem acessar o link automaticamente e acabar alterando ou apagando dados.

Por isso, ações que modificam o banco devem usar métodos apropriados, como POST, e ter validações de segurança.

#### Validação Client vs Server: Um desenvolvedor júnior afirma que o formulário dele é 100% seguro porque colocou required e type="email" em todas as tags HTML. Explique por que essa afirmação é falsa.

- Essa afirmação é falsa porque required e type="email" fazem apenas uma validação no navegador (client-side). Um usuário pode desativar essas validações ou enviar os dados diretamente para o servidor.

Por isso, é necessário fazer também a validação no servidor (server-side), verificando novamente os dados antes de processá-los ou salvá-los no banco. Assim, o sistema fica mais seguro.

#### XSS e Sanitização: Qual é o risco de exibir dados vindos de um $_POST diretamente na tela sem utilizar htmlspecialchars()?

- O risco é sofrer um ataque XSS (Cross-Site Scripting). Um usuário mal-intencionado pode enviar um código HTML ou JavaScript pelo $_POST, e esse código pode ser executado no navegador.

O htmlspecialchars() transforma caracteres especiais em texto, impedindo que o código enviado seja interpretado como HTML ou JavaScript.

#### Sticky Forms: O que é a técnica de Sticky Forms e qual é o seu impacto na experiência do usuário (UX)?

- Sticky Forms é uma técnica que mantém os dados preenchidos pelo usuário no formulário mesmo quando acontece um erro de validação.

Isso melhora a experiência do usuário (UX) porque ele não precisa digitar todas as informações novamente. Assim, o preenchimento fica mais rápido, fácil e evita frustração.

#### DevTools: Como você utilizaria a aba Network do navegador para comprovar que um formulário foi enviado via POST e não via GET?

- Para verificar se um formulário foi enviado por POST, eu abriria o DevTools do navegador e acessaria a aba Network. Depois, preencheria e enviaria o formulário.

Na lista de requisições, eu procuraria a requisição feita pelo formulário e clicaria nela. Na aba Headers, procuraria por Request Method. Se estiver escrito POST, significa que os dados foram enviados pelo método POST. Se estivesse escrito GET, os dados seriam enviados pela URL.
