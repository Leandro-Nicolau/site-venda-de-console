
<?php
include("conexao.php");

$id = $_GET["id"];

$sql = "SELECT 
            pedido.cod_pedido,
            pedido.data,
            clientes.nome AS cliente,
            clientes.CPF,
            clientes.email,
            produto.nome AS produto,
            detalhes.quantidade,
            detalhes.preco_venda
        FROM pedido
        INNER JOIN clientes
            ON pedido.cod_cliente = clientes.cod_cliente
        INNER JOIN detalhes
            ON pedido.cod_pedido = detalhes.cod_pedido
        INNER JOIN produto
            ON detalhes.cod_produto = produto.cod_produto
        WHERE pedido.cod_pedido = ?";

$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

$resultado = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Pedido - NEXPLAY</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>

<header>
    <h1>NEXPLAY</h1>
    <p>Área Administrativa</p>
</header>

<main>
    <h2>Detalhes do Pedido</h2>

    <?php if ($resultado->num_rows > 0) { ?>

        <?php
        $total = 0;
        $primeiro = true;
        ?>

        <?php while ($pedido = $resultado->fetch_assoc()) { ?>

            <?php if ($primeiro) { ?>
                <h3>Pedido Nº <?php echo $pedido["cod_pedido"]; ?></h3>

                <p><strong>Data:</strong>
                    <?php echo date("d/m/Y", strtotime($pedido["data"])); ?>
                </p>

                <p><strong>Cliente:</strong>
                    <?php echo htmlspecialchars($pedido["cliente"]); ?>
                </p>

                <p><strong>CPF:</strong>
                    <?php echo htmlspecialchars($pedido["CPF"]); ?>
                </p>

                <p><strong>E-mail:</strong>
                    <?php echo htmlspecialchars($pedido["email"]); ?>
                </p>

                <h3>Produtos do pedido</h3>

                <table>
                    <tr>
                        <th>Produto</th>
                        <th>Quantidade</th>
                        <th>Preço unitário</th>
                        <th>Subtotal</th>
                    </tr>

                <?php $primeiro = false; ?>
            <?php } ?>

            <?php
            $subtotal = $pedido["quantidade"] * $pedido["preco_venda"];
            $total += $subtotal;
            ?>

            <tr>
                <td><?php echo htmlspecialchars($pedido["produto"]); ?></td>
                <td><?php echo $pedido["quantidade"]; ?></td>
                <td>
                    R$ <?php echo number_format($pedido["preco_venda"], 2, ",", "."); ?>
                </td>
                <td>
                    R$ <?php echo number_format($subtotal, 2, ",", "."); ?>
                </td>
            </tr>

        <?php } ?>

        </table>

        <h3>
            Total do pedido:
            R$ <?php echo number_format($total, 2, ",", "."); ?>
        </h3>

    <?php } else { ?>

        <p>Pedido não encontrado.</p>

    <?php } ?>

    <br>
    <a href="listar_pedidos.php">Voltar para pedidos</a>

</main>

</body>
</html>

<?php
$stmt->close();
$conexao->close();
?>
