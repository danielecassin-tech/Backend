##  Parte A: Exercícios Teóricos de Fixação

1. Definição de CRUD

CRUD é um acrônimo formado pelas palavras Create, Read, Update e Delete. Ele representa as quatro operações básicas realizadas em um banco de dados. No SQL, o Create corresponde ao INSERT, utilizado para inserir dados; o Read corresponde ao SELECT, utilizado para consultar dados; o Update corresponde ao UPDATE, utilizado para alterar dados; e o Delete corresponde ao DELETE, utilizado para excluir dados.

2. Anatomia do SQL Injection

O SQL Injection acontece quando a aplicação coloca diretamente dados fornecidos pelo usuário, como valores recebidos por `$_GET` ou `$_POST`, dentro de uma consulta SQL usando concatenação de strings. Dessa forma, o banco pode interpretar parte do que o usuário digitou como código SQL, e não apenas como um valor. Com isso, um atacante pode modificar a lógica original da consulta e fazer com que ela execute uma operação diferente daquela planejada pelo programador. Por esse motivo, não é recomendado concatenar diretamente dados do usuário nas consultas SQL.

3. Mecanismo das Prepared Statements

As Prepared Statements impedem que os dados digitados pelo usuário sejam interpretados como comandos SQL porque a consulta e os valores são tratados separadamente. Primeiro, a aplicação prepara a estrutura da consulta com prepare() e depois envia os valores por meio de execute(). Assim, o banco entende que o conteúdo enviado pelo usuário é apenas um dado que deve ser utilizado pela consulta, e não uma parte da instrução SQL. Isso reduz significativamente o risco de SQL Injection.

4. Marcadores Nomeados

Os marcadores nomeados, como :sku e :preco, tornam a consulta mais fácil de entender e manter. Em consultas complexas com vários parâmetros, eles permitem identificar claramente qual valor pertence a cada campo. Já os pontos de interrogação (?) dependem da posição dos parâmetros, o que pode dificultar a manutenção e aumentar a possibilidade de erros quando a consulta possui muitos valores.

5. Diferença entre bindValue() e bindParam()

A principal diferença está na forma como o valor é associado ao parâmetro. O método bindValue() vincula o valor no momento em que o método é chamado. Já o bindParam() vincula uma variável por referência, fazendo com que o valor da variável seja utilizado posteriormente, normalmente quando o execute() for realizado. Por isso, bindValue() costuma ser mais simples quando queremos apenas passar um valor específico para a consulta.

6. Tipagem no PDO

Quando um valor deveria ser obrigatoriamente numérico, como um valor utilizado em uma cláusula LIMIT, é importante informar corretamente seu tipo ao PDO, utilizando, por exemplo, PDO::PARAM_INT. Se o tipo não for informado, o PDO pode tratar o valor como uma string. Isso pode causar problemas de interpretação da consulta ou comportamento diferente do esperado. Além disso, a aplicação deve validar se o valor recebido realmente é um número inteiro válido antes de utilizá-lo.

7. Padrão DAO

O padrão DAO, que significa Data Access Object, tem como objetivo separar o código responsável pelo acesso ao banco de dados do restante da aplicação. Dessa maneira, as consultas SQL e operações de persistência ficam concentradas em classes específicas. Isso facilita a manutenção do sistema, pois uma alteração no acesso ao banco pode ser feita em um único lugar. O DAO também ajuda a seguir o princípio da responsabilidade única do SOLID, pois cada classe fica responsável por uma função específica.

8. Operações de UPDATE

A ausência de uma cláusula WHERE em um comando UPDATE é considerada muito grave porque o comando poderá alterar todas as linhas da tabela. Por exemplo, se uma aplicação executar UPDATE produtos SET preco = 10, o preço de todos os produtos poderá ser alterado para 10. Em um ambiente de produção, isso pode causar uma grande perda ou alteração indevida de dados, podendo exigir a restauração de backups e causar prejuízos para a organização.

9. Impacto da LGPD

Caso uma falha de SQL Injection provoque o vazamento de dados pessoais de clientes, a organização poderá sofrer consequências previstas na LGPD. Dependendo da situação, pode ser necessário comunicar o incidente à Autoridade Nacional de Proteção de Dados (ANPD) e aos titulares afetados. A organização também pode estar sujeita a sanções administrativas, como advertência, multa, publicização da infração, bloqueio ou eliminação dos dados envolvidos e outras medidas previstas na legislação. Além das sanções legais, a empresa pode sofrer prejuízos financeiros, operacionais e de reputação. A gravidade das consequências depende das características do incidente e dos dados envolvidos.