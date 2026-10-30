
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
    <link rel="stylesheet" href="admin.css">
</head>
<body>

    <h1>Cadastro de Pedidos</h1>

    <form action="salvar_pedido.php" method="POST">

        <label>Cliente:</label>
        <select name="cod_cliente" required>
            <option value="">Selecione um cliente</option>

            <?php
            while ($cliente = $clientes->fetch_assoc()) {
            ?>
                <option value="<?php echo $cliente["cod_cliente"]; ?>">
                    <?php echo htmlspecialchars($cliente["nome"]); ?>
                </option>
            <?php
            }
            ?>

        </select>

        <label>Produto:</label>
        <select name="cod_produto" required>
            <option value="">Selecione um produto</option>

            <?php
            while ($produto = $produtos->fetch_assoc()) {
            ?>
                <option value="<?php echo $produto["cod_produto"]; ?>">
                    <?php
                    echo htmlspecialchars($produto["nome"]);
                    echo " - R$ " . number_format($produto["preco"], 2, ",", ".");
                    echo " (Estoque: " . $produto["estoque"] . ")";
                    ?>
                </option>
            <?php
            }
            ?>

        </select>

        <label>Quantidade:</label>
        <input type="number" name="quantidade" min="1" required>

        <button type="submit">Registrar Pedido</button>

    </form>

    <br>

    <a href="admin.php">Voltar para administração</a>

</body>
</html>

<?php
$conexao->close();
?>
