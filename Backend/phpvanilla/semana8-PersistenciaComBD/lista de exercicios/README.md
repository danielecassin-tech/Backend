## Parte A: Exercícios Teóricos de Fixação

1. Abstração de Dados: O que é o PDO no PHP e por que ele é preferível em relação a extensões especializadas procedurais como o antigo pgsql em projetos corporativos?

- PDO é uma interface do PHP para acessar bancos de dados. Ele facilita o uso de prepared statements, o tratamento de exceções e a troca de SGBD com menos alterações no código.

2. Ciclo do DSN: Explique o que é a string DSN e detalhe a finalidade de cada um dos parâmetros configurados para o PostgreSQL (host, port, dbname).

- DSN é a string que informa os dados necessários para estabelecer a conexão. host indica o endereço do servidor, port indica a porta de comunicação e dbname informa o nome do banco de dados.

3. Padrão de Portas: Qual é a porta padrão de escuta do SGBD PostgreSQL (5432) e como ela é referenciada dentro da string de conexão?

- A porta padrão é 5432. Ela é informada no DSN, por exemplo: pgsql:host=127.0.0.1;port=5432;dbname=senai_dev.

4. Flags de Integridade: O que acontece quando definimos o atributo PDO::ATTR_ERRMODE com o valor PDO::ERRMODE_EXCEPTION? Qual seria o comportamento padrão caso essa flag não fosse definida?

- Faz o PDO lançar exceções quando ocorrem erros, permitindo tratá-los com try-catch. Sem essa configuração, o comportamento padrão nas versões modernas do PHP é PDO::ERRMODE_EXCEPTION.

5. Fetch Mode: Qual é a vantagem de utilizar PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC para o consumo de memória RAM do servidor?

- Retorna os resultados como arrays associativos, usando os nomes das colunas como chaves, sem duplicar cada campo em índices numéricos. Isso evita dados redundantes no array e facilita a leitura.

6. Padrão Singleton: Por que abrir uma nova conexão com new PDO() a cada consulta executada no PostgreSQL pode esgotar o limite de max_connections do servidor?

- Cada nova conexão pode ocupar uma vaga no limite de conexões do PostgreSQL, consumindo memória e recursos. Criar conexões repetidamente aumenta a sobrecarga; reutilizá-las quando apropriado reduz esse custo.

7. Encapsulamento do Singleton: Por que o construtor da classe ConexaoBanco precisa ser declarado como private e quais métodos mágicos devem ser bloqueados para garantir a unicidade da instância?

- Para impedir que outras classes criem instâncias diretamente com new. Os métodos __clone() e __wakeup() também devem ser bloqueados para impedir a clonagem e a reconstrução de outra instância por desserialização.

8. Segurança de Credenciais: Por que nunca devemos deixar o usuário e senha do banco de dados salvos de forma estática (hardcoded) dentro dos scripts PHP do projeto?

- Porque elas podem ser expostas em repositórios, cópias de segurança ou compartilhamentos de código. É mais seguro manter as credenciais em arquivos de configuração protegidos ou variáveis de ambiente, fora do controle de versão.

9. Tratamento de Exceções & LGPD: Por que a exibição direta de $e->getMessage() de uma PDOException na tela do navegador é considerada uma falha grave de segurança (Information Disclosure)?

- Porque a mensagem pode revelar nomes de tabelas, endereços internos, consultas SQL e outros detalhes úteis para um invasor. O ideal é registrar o erro técnico em um log protegido e mostrar ao usuário uma mensagem genérica.
