
<?php
include("conexao.php");

$nome = $_POST["nome"];
$descricao = $_POST["descricao"];
$preco = $_POST["preco"];
$estoque = $_POST["estoque"];

$sql = "INSERT INTO produto (nome, descricao, preco, estoque) VALUES (?, ?, ?, ?)";

$stmt = $conexao->prepare($sql);
$stmt->bind_param("ssdi", $nome, $descricao, $preco, $estoque);

$sucesso = $stmt->execute();

$stmt->close();
$conexao->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Produto - NEXPLAY</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>

    <header>
        <h1>NEXPLAY</h1>
        <p>Área Administrativa</p>
    </header>

    <main>
        <?php if ($sucesso) { ?>
            <h2>✓ Cadastro realizado!</h2>
            <p>O produto foi cadastrado com sucesso.</p>
        <?php } else { ?>
            <h2>Erro no cadastro</h2>
            <p>Não foi possível cadastrar o produto.</p>
        <?php } ?>

        <br>
        <a href="produtos.php">Cadastrar outro produto</a>
        <a href="admin.php">Voltar ao painel</a>
    </main>

</body>
</html>
