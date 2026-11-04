LISTA DE EXERCÍCIOS DE FIXAÇÃO E PRÁTICA

### Parte A: Questões Teóricas de Fixação

1. **Evolução Arquitetural:** Quais foram os principais aprendizados técnicos obtidos na construção do MVC artesanal da Semana 12 que permitiram que você compreendesse o Laravel 11 com facilidade?

R: A construção do MVC artesanal na Semana 12 permitiu compreender melhor como organizar um sistema, separando suas responsabilidades. Aprendi que o Model é responsável pelos dados e pelas regras de negócio, o View apresenta as informações ao usuário e o Controller faz a comunicação entre essas duas partes. Esse aprendizado facilitou a compreensão do Laravel, pois ele utiliza o mesmo padrão MVC, mas oferece ferramentas prontas que tornam o desenvolvimento mais organizado, seguro e rápido.

2. **A Nova Arquitetura do Laravel 11:** O que mudou na estrutura de inicialização do Laravel 11 em relação às versões anteriores (Laravel 9 e 10)? Onde fica o novo ponto central de configuração?

R: No Laravel 11, a estrutura de inicialização foi simplificada em comparação com as versões 9 e 10. Algumas configurações que antes ficavam espalhadas em vários arquivos e pastas foram centralizadas. O novo ponto principal de configuração é o arquivo bootstrap/app.php, responsável por configurar a inicialização da aplicação, rotas, middlewares e tratamento de exceções.

3. **Padrão 12-Factor App:** Por que é uma violação grave de segurança gravar senhas de banco de dados diretamente dentro do arquivo `config/database.php` em vez de utilizar o arquivo `.env`?

R: Gravar senhas do banco de dados diretamente no arquivo config/database.php é uma prática perigosa porque essas informações podem ser expostas quando o projeto é compartilhado ou enviado para o GitHub. O correto é utilizar o arquivo .env, que guarda informações sensíveis, como senhas e credenciais, separadas do código-fonte. Isso aumenta a segurança e facilita a configuração do sistema em diferentes ambientes.

4. **O Papel da `APP_KEY`:** Qual é o risco técnico de alterar a `APP_KEY` de uma aplicação que já está em produção há meses com usuários reais cadastrados?

R: A APP_KEY é uma chave utilizada pelo Laravel para proteger informações, como dados criptografados e cookies. Alterar essa chave em uma aplicação que já está em produção pode causar problemas porque os dados criptografados com a chave antiga podem não ser mais reconhecidos. Isso pode invalidar sessões, dificultar o acesso a informações protegidas e prejudicar o funcionamento do sistema.

5. **Isolamento de Diretórios:** Por que um servidor web de produção (Nginx/Apache) deve apontar rigorosamente para a pasta `public/` e nunca para a raiz do projeto Laravel?

R: O servidor web deve apontar somente para a pasta public/ porque ela contém os arquivos que podem ser acessados publicamente, como o index.php, CSS, JavaScript e imagens. A raiz do projeto contém arquivos importantes, como .env, configurações e códigos internos. Se o servidor permitir acesso direto a esses arquivos, informações confidenciais poderão ser expostas, causando riscos de segurança.

6. **Artisan CLI:** Qual é a diferença prática entre executar um script PHP procedural com `php arquivo.php` e executar comandos através do `php artisan`?

R: Executar um script com php arquivo.php significa iniciar diretamente um arquivo PHP, que executará apenas as instruções programadas nele. Já o php artisan utiliza uma ferramenta própria do Laravel, que oferece diversos comandos para facilitar o desenvolvimento, como criar Controllers, Models, executar migrations, limpar caches e iniciar o servidor de desenvolvimento.

7. **O Arquivo `.env.example`:** Por que manter o arquivo `.env.example` sempre atualizado é indispensável para o sucesso de equipes de desenvolvimento que utilizam Git?

R: O arquivo .env.example é importante porque apresenta um modelo das configurações necessárias para executar o projeto. Como o arquivo .env normalmente não é enviado ao Git por conter informações sensíveis, o .env.example permite que outros desenvolvedores saibam quais variáveis precisam configurar. Assim, todos conseguem preparar o ambiente corretamente sem compartilhar senhas pessoais ou informações confidenciais.

8. **Motor de Templates Blade:** Qual é a diferença entre a diretiva Blade `{{ $variavel }}` e a diretiva `{!! $variavel !!}` em termos de proteção contra ataques Cross-Site Scripting (XSS)?

R: A diretiva {{ $variavel }} apresenta o conteúdo da variável realizando o escape automático de caracteres HTML, ajudando a proteger a aplicação contra ataques XSS. Já a diretiva {!! $variavel !!} apresenta o conteúdo sem realizar esse escape, permitindo que códigos HTML sejam interpretados pelo navegador. Por isso, a segunda diretiva exige muito cuidado, pois pode permitir a execução de códigos maliciosos quando recebe conteúdo não confiável.

9. **Responsabilidade do Controller:** Em uma aplicação profissional com Laravel, por que um método de Controller deve ser curto (≤ 20 linhas) e não deve conter consultas SQL cruas ou regras de negócio extensas?
10. **A Ferramenta Tinker:** Para que serve o comando `php artisan tinker` e em quais situações ele economiza tempo do desenvolvedor durante testes de laboratório?

R: 9. Responsabilidade do Controller:

Em uma aplicação profissional, o Controller deve ter métodos curtos e objetivos porque sua principal responsabilidade é receber as requisições, chamar os componentes responsáveis pelo processamento e retornar uma resposta. Consultas SQL e regras de negócio extensas devem ficar em classes apropriadas, como Models e Services. Essa separação facilita a manutenção, os testes, a organização e a reutilização do código.

10.**A Ferramenta Tinker:** Para que serve o comando `php artisan tinker` e em quais situações ele economiza tempo do desenvolvedor durante testes de laboratór.

R: O Tinker é uma ferramenta interativa do Laravel que permite executar comandos PHP diretamente no ambiente da aplicação através do terminal, utilizando o comando php artisan tinker. Ele economiza tempo porque permite testar Models, consultar registros do banco de dados, criar objetos e verificar relacionamentos sem precisar criar arquivos PHP ou telas específicas para cada teste.