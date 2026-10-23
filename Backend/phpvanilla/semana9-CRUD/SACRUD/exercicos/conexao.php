<?php
declare(strict_types=1);

// Configura a conexão com o PostgreSQL.
function conectar(): PDO
{
    $host = '127.0.0.1';
    $porta = '5432';
    $banco = 'banco.sql';
    $usuario = 'postgres';
    $senha = '123456';

    $dsn = "pgsql:host=$host;port=$porta;dbname=$banco";

    return new PDO($dsn, $usuario, $senha, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
}
