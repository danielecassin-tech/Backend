
<?php
declare(strict_types=1);

function e(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function carregarRecados(string $arquivo): array
{
    if (!is_file($arquivo)) {
        return [];
    }
    $dados = json_decode((string) file_get_contents($arquivo), true);
    return is_array($dados) ? $dados : [];
}

$arquivo = __DIR__ . '/mural.json';
$recados = carregarRecados($arquivo);
$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $mensagem = trim($_POST['mensagem'] ?? '');

    if (mb_strlen($nome) < 3 || mb_strlen($mensagem) < 5) {
        $erro = 'Nome: mínimo 3 caracteres. Mensagem: mínimo 5.';
    } else {
        $recados[] = ['nome' => $nome, 'mensagem' => $mensagem];
        $json = json_encode($recados, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        if ($json !== false && file_put_contents($arquivo, $json, LOCK_EX) !== false) {
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit;
        }
        $erro = 'Não foi possível salvar o recado.';
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Mural de Recados</title>
</head>
<body>
    <h1>Mural de Recados</h1>
    <p><?= e($erro) ?></p>

    <form method="post">
        <label>Nome:
            <input name="nome" required minlength="3">
        </label>
        <br>
        <label>Mensagem:
            <textarea name="mensagem" required minlength="5"></textarea>
        </label>
        <br>
        <button type="submit">Enviar recado</button>
    </form>

    <h2>Recados publicados</h2>
    <?php foreach ($recados as $recado): ?>
        <article>
            <h3><?= e((string) ($recado['nome'] ?? '')) ?></h3>
            <p><?= nl2br(e((string) ($recado['mensagem'] ?? ''))) ?></p>
        </article>
    <?php endforeach; ?>
</body>
</html>
