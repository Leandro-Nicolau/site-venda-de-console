
<?php
include("verificar_login.php");
include("conexao.php");

$cod_cliente = $_SESSION["cod_cliente"];

// Busca os dados do cliente
$sql = "SELECT nome, CPF, telefone, email
        FROM clientes
        WHERE cod_cliente = ?";

$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $cod_cliente);
$stmt->execute();

$resultado = $stmt->get_result();
$cliente = $resultado->fetch_assoc();

$stmt->close();

// Busca os pedidos do cliente
$sql = "SELECT
            p.cod_pedido,
            p.data,
            p.status,
            COALESCE(SUM(d.quantidade * d.preco_venda), 0) AS total
        FROM pedido p
        LEFT JOIN detalhes d ON p.cod_pedido = d.cod_pedido
        WHERE p.cod_cliente = ?
        GROUP BY p.cod_pedido, p.data, p.status
        ORDER BY p.cod_pedido DESC";

$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $cod_cliente);
$stmt->execute();

$pedidos = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minha Conta - NEXPLAY</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <header>
        <img src="logo.png" alt="Logo da NEXPLAY" width="350">

        <nav>
            <a href="index.php">Início</a>
            <a href="catalogo.php">Produtos</a>
            <a href="carrinho.php">Carrinho</a>
            <a href="logout.php">Sair</a>
        </nav>
    </header>

    <main>

        <h1>Minha Conta</h1>

        <h2>Meus dados</h2>

        <a href="editar_meus_dados.php">Editar meus dados</a>
<br><br>

        <p><strong>Nome:</strong>
            <?php echo htmlspecialchars($cliente["nome"]); ?>
        </p>

        <p><strong>CPF:</strong>
            <?php echo htmlspecialchars($cliente["CPF"]); ?>
        </p>

        <p><strong>Telefone:</strong>
            <?php echo htmlspecialchars($cliente["telefone"]); ?>
        </p>

        <p><strong>E-mail:</strong>
            <?php echo htmlspecialchars($cliente["email"]); ?>
        </p>

        <h2>Meus pedidos</h2>

        <?php if ($pedidos->num_rows > 0) { ?>

            <?php while ($pedido = $pedidos->fetch_assoc()) { ?>

                <div class="item-confirmacao">

                    <h3>Pedido Nº <?php echo $pedido["cod_pedido"]; ?></h3>

                    <p>Data:
                        <?php echo date("d/m/Y", strtotime($pedido["data"])); ?>
                    </p>

                    <p>Status:
                        <?php echo htmlspecialchars($pedido["status"]); ?>
                    </p>

                    <p>Total:
                        R$ <?php echo number_format($pedido["total"], 2, ",", "."); ?>
                    </p>

                    <a href="detalhes_pedido.php?id=<?php echo $pedido["cod_pedido"]; ?>">
                        Ver detalhes
                    </a>

                </div>

            <?php } ?>

        <?php } else { ?>

            <p>Você ainda não realizou nenhuma compra.</p>

        <?php } ?>

        <br>
        <a href="catalogo.php">Continuar comprando</a>

    </main>

</body>
</html>

<?php
$stmt->close();
$conexao->close();
?>
