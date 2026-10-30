
<?php
include("conexao.php");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Produtos - NEXPLAY</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <h1>Cadastro de Produtos</h1>

    <form action="salvar_produto.php" method="POST">

        <label>Nome do produto:</label>
        <input type="text" name="nome" required>

        <label>Descrição:</label>
        <input type="text" name="descricao" required>

        <label>Preço:</label>
        <input type="number" name="preco" step="0.01" min="0" required>

        <label>Estoque:</label>
        <input type="number" name="estoque" min="0" required>

        <button type="submit">Cadastrar Produto</button>

    </form>

</body>
</html>
