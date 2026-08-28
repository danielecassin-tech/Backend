<?php
$nomeUsuario = "Ana Clara Silva";

function gerarIniciais(string $nome): string
{
    $partes = explode(" ", trim($nome));

    $iniciais = "";

    foreach ($partes as $parte) {
        if ($parte !== "") {
            $iniciais .= strtoupper($parte[0]);
        }
    }

    return substr($iniciais, 0, 3);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Teste de Funções - CRM</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #ecf0f1;
            padding: 20px;
        }

        .card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            max-width: 400px;
        }

        .avatar {
            width: 50px;
            height: 50px;
            background: #3498db;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 20px;
        }
    </style>
</head>

<body>

<div class="card">

    <h2>Perfil do Cliente</h2>
    <hr>

    <div class="avatar">
        <?php echo gerarIniciais($nomeUsuario); ?>
    </div>

    <p><strong>Nome:</strong> Ana Clara Silva</p>

    <p><strong>CPF para o Banco:</strong> 12345678900</p>

    <p><strong>Total Bruto:</strong> R$ 150,00</p>

    <p><strong>Total com Desconto (10%):</strong> R$ 135,00</p>

</div>

</body>
</html>