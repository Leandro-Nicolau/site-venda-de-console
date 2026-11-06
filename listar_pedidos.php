<?php
include("verificar_admin.php");
?>
<?php
include("conexao.php");

$sql = "SELECT 
            pedido.cod_pedido,
            pedido.data,
            clientes.nome AS cliente,
            produto.nome AS produto,
            detalhes.quantidade,
            detalhes.preco_venda,
            pedido.status
        FROM pedido
        INNER JOIN clientes 
            ON pedido.cod_cliente = clientes.cod_cliente
        INNER JOIN detalhes 
            ON pedido.cod_pedido = detalhes.cod_pedido
        INNER JOIN produto 
            ON detalhes.cod_produto = produto.cod_produto
        ORDER BY pedido.cod_pedido DESC";

$resultado = $conexao->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos - NEXPLAY</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>

    <header>
        <h1>NEXPLAY</h1>
        <p>Área Administrativa</p>
    </header>

    <main>
        <h2>Pedidos cadastrados</h2>

        <table>
            <tr>
                <th>Código</th>
                <th>Data</th>
                <th>Cliente</th>
                <th>Produto</th>
                <th>Quantidade</th>
                <th>Preço unitário</th>
                <th>Total</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>

            <?php while ($pedido = $resultado->fetch_assoc()) { ?>

                <tr>
                    <td><?php echo $pedido["cod_pedido"]; ?></td>
                    <td><?php echo date("d/m/Y", strtotime($pedido["data"])); ?></td>
                    <td><?php echo htmlspecialchars($pedido["cliente"]); ?></td>
                    <td><?php echo htmlspecialchars($pedido["produto"]); ?></td>
                    <td><?php echo $pedido["quantidade"]; ?></td>

                    <td>
                        R$ <?php echo number_format($pedido["preco_venda"], 2, ",", "."); ?>
                    </td>

                    <td>
                        R$ <?php echo number_format(
                            $pedido["quantidade"] * $pedido["preco_venda"],
                            2, ",", "."
                        ); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($pedido["status"]); ?>
                    </td>

                    <td>
                        <a href="detalhes_pedido.php?id=<?php echo $pedido["cod_pedido"]; ?>">
                            Ver detalhes
                        </a>

                        <?php if ($pedido["status"] == "Ativo") { ?>
                            <br><br>

                            <a href="cancelar_pedido.php?id=<?php echo $pedido["cod_pedido"]; ?>"
                            onclick="return confirm('Tem certeza que deseja cancelar este pedido?');">
                                Cancelar pedido
                            </a>
                        <?php } ?>
                    </td>
                </tr>

            <?php } ?>

        </table>

        <br>
        <a href="admin.php">Voltar para administração</a>
    </main>

</body>
</html>

<?php
$conexao->close();
?>
