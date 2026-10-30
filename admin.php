
<?php
include("conexao.php");

// Total de clientes
$sql = "SELECT COUNT(*) AS total FROM clientes";
$resultado = $conexao->query($sql);
$clientes = $resultado->fetch_assoc()["total"];

// Total de produtos
$sql = "SELECT COUNT(*) AS total FROM produto";
$resultado = $conexao->query($sql);
$produtos = $resultado->fetch_assoc()["total"];

// Pedidos ativos
$sql = "SELECT COUNT(*) AS total FROM pedido WHERE status = 'Ativo'";
$resultado = $conexao->query($sql);
$pedidos = $resultado->fetch_assoc()["total"];

// Pedidos cancelados
$sql = "SELECT COUNT(*) AS total FROM pedido WHERE status = 'Cancelado'";
$resultado = $conexao->query($sql);
$cancelados = $resultado->fetch_assoc()["total"];

// Faturamento dos pedidos ativos
$sql = "SELECT SUM(detalhes.quantidade * detalhes.preco_venda) AS total
        FROM detalhes
        INNER JOIN pedido
        ON detalhes.cod_pedido = pedido.cod_pedido
        WHERE pedido.status = 'Ativo'";

$resultado = $conexao->query($sql);
$faturamento = $resultado->fetch_assoc()["total"] ?? 0;

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - NEXPLAY</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>

<header>
    <h1>NEXPLAY</h1>
    <p>Área Administrativa</p>
</header>

<main>

    <h2>Painel de Administração</h2>
    <p>Visão geral da sua loja</p>

    <div class="dashboard">

        <div class="card-dashboard">
            <h3>Clientes</h3>
            <p><?php echo $clientes; ?></p>
        </div>

        <div class="card-dashboard">
            <h3>Produtos</h3>
            <p><?php echo $produtos; ?></p>
        </div>

        <div class="card-dashboard">
            <h3>Pedidos ativos</h3>
            <p><?php echo $pedidos; ?></p>
        </div>

        <div class="card-dashboard">
            <h3>Pedidos cancelados</h3>
            <p><?php echo $cancelados; ?></p>
        </div>

        <div class="card-dashboard">
            <h3>Faturamento</h3>
            <p>R$ <?php echo number_format($faturamento, 2, ",", "."); ?></p>
        </div>

    </div>

    <h3>Cadastros</h3>

    <a href="clientes.php">Cadastrar Clientes</a>
    <br><br>

    <a href="produtos.php">Cadastrar Produtos</a>
    <br><br>

    <a href="pedidos.php">Cadastrar Pedidos</a>
    <br><br>

    <h3>Consultas</h3>

    <a href="listar_clientes.php">Listar Clientes</a>
    <br><br>

    <a href="listar_produtos.php">Listar Produtos</a>
    <br><br>

    <a href="listar_pedidos.php">Listar Pedidos</a>
    <br><br>

    <a href="index.html">Voltar para a loja</a>

</main>

</body>
</html>

<?php
$conexao->close();
?>

