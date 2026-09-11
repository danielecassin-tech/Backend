<?php

declare(strict_types=1);

$email = $_POST['email'] ?? '';
$erro = '';
$sucesso = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $senha = $_POST['senha'] ?? '';

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erro = "E-mail inválido.";
    } elseif (strlen($senha) < 6) {
        $erro = "A senha deve ter no mínimo 6 caracteres.";
    } elseif ($email === 'admin@senai.br' && $senha === 'senhaSegura123') {
        $sucesso = true;
    } else {
        $erro = "Credenciais inválidas";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Login Seguro</title>
</head>

<body>

<h1>Login</h1>

<form method="POST">

    <label>E-mail:</label>
    <input type="email"
           name="email"
           value="<?= htmlspecialchars($email) ?>"
           required>

    <br><br>

    <label>Senha:</label>
    <input type="password"
           name="senha"
           required>

    <br><br>

    <button type="submit">Entrar</button>

</form>

<?php if ($erro !== ''): ?>

    <p style="color: red;">
        <?= htmlspecialchars($erro) ?>
    </p>

<?php endif; ?>

<?php if ($sucesso): ?>

    <div style="background-color: lightgreen; padding: 15px;">
        <h2>Bem-vindo!</h2>
        <p>Login realizado com sucesso.</p>
    </div>

<?php endif; ?>

</body>
</html>


