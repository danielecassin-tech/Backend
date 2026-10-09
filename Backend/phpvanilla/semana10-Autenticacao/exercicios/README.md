### Parte A: Exercícios Teóricos de Fixação
 
1.  Protocolo Stateless: O que significa afirmar que o protocolo HTTP é "stateless" e por que o mecanismo de cookies/sessões é necessário para aplicações modernas?


- Afirmar que o protocolo HTTP é stateless (sem estado) significa que cada requisição feita pelo cliente ao servidor é tratada de forma isolada, sem qualquer conhecimento ou memória das requisições anteriores. O servidor não mantém um histórico nativo que associe uma requisição à outra; ele simplesmente recebe dados, processa-os, envia uma resposta e encerra a conexão.
Como as aplicações modernas exigem a continuidade da experiência do usuário (como manter o usuário logado ou reter itens em um carrinho de compras), os mecanismos de cookies e sessões tornaram-se fundamentais. Eles funcionam como uma "identidade digital temporária" que é enviada a cada requisição, permitindo que o servidor reconheça o usuário e mantenha o estado da aplicação ativo entre as páginas visitadas.

2. Cookies vs. Sessões: Qual é a diferença entre os dados armazenados em um cookie e os dados mantidos no array superglobal $_SESSION? Qual dos dois apresenta maior segurança para informações confidenciais?


- A principal diferença reside no local de armazenamento e na visibilidade dos dados:
• Cookies: Os dados são armazenados no navegador do cliente. Eles trafegam pela rede a cada requisição HTTP e podem ser livremente lidos ou modificados pelo usuário (ou por scripts maliciosos, se não protegidos).
• Array Superglobal $_SESSION: No PHP, os dados da sessão ficam armazenados com segurança no lado do servidor (em arquivos temporários ou bancos de dados). O cliente recebe apenas uma chave de identificação única chamada PHPSESSID, armazenada em um cookie.
Qual apresenta maior segurança? O mecanismo de Sessões ($_SESSION) é significativamente mais seguro para informações confidenciais. Como os dados reais nunca saem do servidor, o cliente não consegue visualizar ou alterar os privilégios, saldos ou dados sensíveis diretamente.

3. A Flag HttpOnly: Explique detalhadamente como a configuração httponly => true impede o sequestro de sessão (Session Hijacking) mesmo se a aplicação possuir uma vulnerabilidade de Cross-Site Scripting (XSS).

- O sequestro de sessão (Session Hijacking) ocorre quando um atacante rouba o identificador da sessão (PHPSESSID) do usuário para se passar por ele no sistema. Se a aplicação possuir uma vulnerabilidade de Cross-Site Scripting (XSS), um invasor pode injetar um script JavaScript na página que executa o comando document.cookie e envia o token de sessão para um servidor externo controlado pelo hacker.
Quando configuramos a flag httponly => true, nós criamos uma barreira rígida no navegador: o cookie de sessão fica completamente inacessível para scripts do lado do cliente (JavaScript). Mesmo que a aplicação seja vulnerável a XSS e o atacante consiga injetar scripts maliciosos, o comando document.cookie retornará uma string vazia para aquele cookie específico. Isso impede o roubo do token por essa via e neutraliza o sequestro de sessão via XSS.

4. A Flag SameSite: Qual é a finalidade do atributo SameSite=Lax em cookies e contra qual tipo de ataque corporativo ele atua?


- A finalidade do atributo SameSite=Lax é controlar se os cookies serão enviados em requisições feitas a partir de sites de terceiros.
• O SameSite=Lax impede que o navegador envie o cookie de autenticação se a requisição partir de um site externo de forma oculta (como via tags <img>, scripts ou requisições POST). Ele só permite o envio do cookie se o usuário estiver realizando uma navegação de alto nível segura (como clicar em um link comum <a> que altera a URL do navegador).
Esse mecanismo atua diretamente contra o ataque de Cross-Site Request Forgery (CSRF) (Falsificação de Requisição Transversal). No CSRF, um site malicioso tenta forçar o navegador do usuário a executar uma ação indesejada em uma aplicação onde ele já está autenticado (ex: submeter um formulário de transferência bancária em segundo plano). Com o SameSite=Lax, o cookie de sessão não é anexado a essa requisição forçada pelo site malicioso, bloqueando o ataque.

5. Ataque de Fixação de Sessão: O que é o ataque de Session Fixation e por que é mandatório executar session_regenerate_id(true) imediatamente após o login do usuário?


- O ataque de Session Fixation ocorre quando o invasor escolhe e fixa um ID de sessão válido no navegador da vítima antes mesmo de ela fazer o login. O fluxo geralmente funciona assim:
1. O atacante acessa o site e gera um ID de sessão (ex: XYZ).
2. O atacante faz com que a vítima use esse mesmo ID XYZ (enviando um link com a URL ?PHPSESSID=XYZ ou injetando o cookie via script).
3. A vítima clica no link e faz o login normalmente.
4. Se a aplicação mantiver o mesmo ID após o login, o atacante (que já conhece o ID XYZ) ganha acesso imediato à conta autenticada da vítima.
É mandatório executar session_regenerate_id(true) imediatamente após o login porque essa função destrói a sessão antiga, gera um identificador de sessão completamente novo e transfere os dados atuais para ele. Isso quebra o vínculo que o atacante tinha com o ID antigo, inutilizando o identificador fixado por ele.

6. MD5 e Rainbow Tables: Por que é considerado negligência técnica armazenar senhas com algoritmos rápidos como MD5 ou SHA256? Como as Rainbow Tables operam contra esses hashes?

- Armazenar senhas com algoritmos rápidos como MD5 ou SHA256 é considerado negligência técnica porque esses algoritmos foram projetados para integridade de dados e velocidade, e não para segurança de credenciais. Em servidores modernos, é possível calcular bilhões de hashes MD5/SHA256 por segundo, tornando os ataques de força bruta extremamente baratos e rápidos.
As Rainbow Tables (Tabelas Arco-Íris) operam como gigantescos bancos de dados de pré-computação. Elas contêm milhões de senhas comuns já combinadas com seus respectivos hashes resultantes. Em vez de calcular o hash de cada senha na hora do ataque, o invasor faz uma busca reversa extremamente rápida na Rainbow Table: ele procura o hash roubado e encontra instantaneamente a senha em texto limpo original.

7. O Papel do Salt: O que é o Salt criptográfico e por que ele garante que dois usuários com a mesma senha possuam hashes completamente distintos no banco de dados?

- O Salt é uma sequência de caracteres aleatórios gerada automaticamente para cada usuário e anexada à senha antes de o hash ser calculado.
Se dois usuários escolherem a senha idêntica 123456, o processo funcionará assim:
• Usuário A: Senha ("123456") + Salt_Aleatorio_A ("@xF9!") \(\rightarrow \) Gera o Hash A
• Usuário B: Senha ("123456") + Salt_Aleatorio_B ("#zP2?") \(\rightarrow \) Gera o Hash B
Como as strings de entrada se tornam totalmente diferentes devido ao Salt exclusivo, os hashes armazenados no banco de dados serão completamente distintos. Além disso, o Salt neutraliza completamente o uso de Rainbow Tables, pois o atacante precisaria gerar uma tabela pré-computada específica para cada Salt individual existente no banco de dados, o que é computacionalmente inviável.

8. Argon2id vs Bcrypt: Por que o algoritmo Argon2id é considerado superior ao Bcrypt na proteção contra ataques de força bruta realizados por placas de vídeo (GPUs) e circuitos ASIC?
 
- O algoritmo Argon2id é superior ao Bcrypt porque ele introduz a volatilidade de memória (Memory-Hardness), enquanto o Bcrypt é limitado apenas pelo uso intensivo de processamento (CPU-bound).
Placas de vídeo (GPUs) e circuitos integrados de aplicação específica (ASICs) possuem milhares de núcleos de processamento paralelo simples. Eles conseguem quebrar o Bcrypt facilmente porque conseguem rodar milhares de tentativas de hash simultaneamente, já que o Bcrypt exige pouquíssima memória RAM para processar cada hash.
O Argon2id exige que uma quantidade configurável de memória RAM (ex: 64MB) seja alocada para computar um único hash. Como as GPUs e ASICs possuem muita velocidade de processamento, mas pouca memória dedicada compartilhada por núcleo, a exigência de RAM do Argon2id cria um "gargalo físico". Isso inviabiliza o paralelismo em massa desses hardwares, nivelando o campo de jogo e tornando os ataques de força bruta extremamente caros e lentos para o invasor.

9. Timing Attacks: Por que a verificação de senhas deve ser feita com password_verify() em vez do operador de comparação comum ===?

- O operador de comparação comum (===) realiza uma verificação caractere por caractere e adota o comportamento de atalho de execução (short-circuit). Se a string correta for segredo e o atacante testar sXXXXXX, o operador falha logo no primeiro caractere e retorna a resposta em, por exemplo, 1 microssegundo. Se o atacante testar seXXXXX, o operador falha no segundo caractere e leva 2 microssegundos. Monitorando essas variações ínfimas de tempo (Timing Attacks), um atacante consegue adivinhar a senha caractere por caractere.
A verificação de senhas deve ser feita com password_verify() (ou hash_equals()) porque essas funções implementam uma comparação em tempo constante. Não importa se o atacante errou o primeiro caractere ou o último: a função sempre processará a string inteira pelo mesmo período exato de tempo antes de retornar o resultado, ocultando do atacante qualquer pista baseada em tempo de resposta.