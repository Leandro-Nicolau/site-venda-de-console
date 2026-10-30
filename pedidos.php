
<?php
include("conexao.php");

$clientes = $conexao->query("SELECT * FROM clientes");
$produtos = $conexao->query("SELECT * FROM produto");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Pedidos - NEXPLAY</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <h1>Cadastro de Pedidos</h1>

    <form action="salvar_pedido.php" method="POST">

        <label>Cliente:</label>
        <select name="cod_cliente" required>
            <option value="">Selecione um cliente</option>

            <?php
            while ($cliente = $clientes->fetch_assoc()) {
                echo "<option value='" . $cliente["cod_cliente"] . "'>";
                echo $cliente["nome"];
                echo "</option>";
            }
            ?>

        </select>

        <label>Produto:</label>
        <select name="cod_produto" required>
            <option value="">Selecione um produto</option>

            <?php
            while ($produto = $produtos->fetch_assoc()) {
                echo "<option value='" . $produto["cod_produto"] . "'>";
                echo $produto["nome"];
                echo "</option>";
            }
            ?>

        </select>

        <label>Quantidade:</label>
        <input type="number" name="quantidade" min="1" required>

        <button type="submit">Registrar Pedido</button>

    </form>

</body>
</html>
