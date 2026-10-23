
<?php
declare(strict_types=1);

function e(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function validarLink(string $url): bool
{
    if (filter_var($url, FILTER_VALIDATE_URL) === false) {
        return false;
    }
    return str_starts_with($url, 'http://')
        || str_starts_with($url, 'https://');
}

$nome = trim($_POST['nome'] ?? '');
$url = trim($_POST['url'] ?? '');
$valido = $_SERVER['REQUEST_METHOD'] === 'POST'
    && $nome !== ''
    && validarLink($url);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Portfólio</title>
</head>
<body>
    <h1>Cadastrar portfólio</h1>
    <form method="post">
        <label>Nome:
            <input name="nome" required>
        </label>
        <br>
        <label>Link do perfil:
            <input name="url" type="url" required>
        </label>
        <br>
        <button type="submit">Cadastrar</button>
    </form>

    <?php if ($valido): ?>
        <p>Perfil de <?= e($nome) ?>:</p>
        <a href="<?= e($url) ?>" target="_blank"
           rel="noopener noreferrer">Visitar Portfólio</a>
    <?php elseif ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
        <p>Nome obrigatório e URL HTTP/HTTPS válida são necessários.</p>
    <?php endif; ?>
</body>
</html>
