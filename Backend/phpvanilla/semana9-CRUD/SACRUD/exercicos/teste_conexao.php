<?php
declare(strict_types=1);

require_once 'conexao.php';

try {
    $pdo = conectar();
    echo "Conexão realizada com sucesso!";
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}