
<?php
declare(strict_types=1);

class ConexaoBanco
{
    private static array $conexoes = [];

    // Impede criar objetos diretamente com new.
    private function __construct()
    {
    }

    // Retorna a conexão do ambiente solicitado.
    public static function obterConexao(
        string $arquivo,
        string $ambiente = 'development'
    ): PDO {
        $chave = realpath($arquivo) . ':' . $ambiente;

        if (isset(self::$conexoes[$chave])) {
            return self::$conexoes[$chave];
        }

        $config = parse_ini_file($arquivo, true, INI_SCANNER_TYPED);
        if (!is_array($config) || !isset($config[$ambiente])) {
            throw new RuntimeException('Configuração não encontrada.');
        }

        $dados = $config[$ambiente];
        $dsn = sprintf(
            'pgsql:host=%s;port=%s;dbname=%s',
            $dados['db_host'],
            $dados['db_port'],
            $dados['db_name']
        );

        self::$conexoes[$chave] = new PDO(
            $dsn,
            $dados['db_user'],
            $dados['db_pass'],
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );

        return self::$conexoes[$chave];
    }
}
