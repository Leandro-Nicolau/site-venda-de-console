
<?php

include("conexao.php");

$sql = "SELECT 
            pedido.cod_pedido,
            pedido.data,
            clientes.nome,
            produto.nome AS produto,
            detalhes.quantidade,
            detalhes.preco_venda
        FROM pedido
        INNER JOIN clientes
            ON pedido.cod_cliente = clientes.cod_cliente
        INNER JOIN detalhes
            ON pedido.cod_pedido = detalhes.cod_pedido
        INNER JOIN produto
            ON detalhes.cod_produto = produto.cod_produto";

$resultado = $conexao->query($sql);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Pedidos - NEXPLAY</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>

    <h1>Pedidos cadastrados</h1>

    <table border="1">

        <tr>
            <th>Código</th>
            <th>Data</th>
            <th>Cliente</th>
            <th>Produto</th>
            <th>Quantidade</th>
            <th>Preço unitário</th>
            <th>Total</th>
        </tr>

        <?php
        while ($pedido = $resultado->fetch_assoc()) {
        ?>

        <tr>
            <td><?php echo $pedido["cod_pedido"]; ?></td>
            <td><?php echo $pedido["data"]; ?></td>
            <td><?php echo htmlspecialchars($pedido["nome"]); ?></td>
            <td><?php echo htmlspecialchars($pedido["produto"]); ?></td>
            <td><?php echo $pedido["quantidade"]; ?></td>
            <td>R$ <?php echo number_format($pedido["preco_venda"], 2, ",", "."); ?></td>
            <td>R$ <?php echo number_format($pedido["preco_venda"] * $pedido["quantidade"], 2, ",", "."); ?></td>
        </tr>

        <?php
        }
        ?>

    </table>

    <br>

    <a href="admin.php">Voltar para administração</a>

</body>
</html>

<?php
$conexao->close();
?>
