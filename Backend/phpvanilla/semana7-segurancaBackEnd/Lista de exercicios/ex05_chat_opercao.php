
<?php
declare(strict_types=1);

function e(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function carregarMensagens(string $arquivo): array
{
    if (!is_file($arquivo)) return [];
    $dados = json_decode((string) file_get_contents($arquivo), true);
    return is_array($dados) ? $dados : [];
}

function salvarMensagens(string $arquivo, array $mensagens): bool
{
    $json = json_encode($mensagens, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    return $json !== false && file_put_contents($arquivo, $json, LOCK_EX) !== false;
}

$arquivo = __DIR__ . '/chat.json';
$mensagens = carregarMensagens($arquivo);
$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $operador = trim($_POST['operador'] ?? '');
    $mensagem = trim($_POST['mensagem'] ?? '');

    if ($operador === '' || $mensagem === '') {
        $erro = 'Preencha o nome e a mensagem.';
    } elseif (mb_strlen($mensagem, 'UTF-8') > 250) {
        $erro = 'A mensagem não pode ultrapassar 250 caracteres.';
    } else {
        $mensagens[] = ['operador' => $operador, 'mensagem' => $mensagem];
        if (salvarMensagens($arquivo, $mensagens)) {
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit;
        }
        $erro = 'Erro ao salvar a mensagem.';
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Chat Industrial</title>
</head>
<body>
    <h1>Chat da Operação</h1>
    <p><?= e($erro) ?></p>

    <form method="post">
        <label>Operador ou supervisor:
            <input name="operador" required>
        </label>
        <br>
        <label>Mensagem:
            <textarea name="mensagem" maxlength="250" required></textarea>
        </label>
        <br>
        <button type="submit">Enviar</button>
    </form>

    <h2>Histórico</h2>
    <?php foreach ($mensagens as $item): ?>
        <article>
            <strong><?= e((string) ($item['operador'] ?? '')) ?></strong>
            <p><?= nl2br(e((string) ($item['mensagem'] ?? ''))) ?></p>
        </article>
    <?php endforeach; ?>
</body>
</html>
