<?php
include("verificar_admin.php");
?>
<?php
include("conexao.php");

$cod_cliente = (int) $_POST["cod_cliente"];
$cod_produto = (int) $_POST["cod_produto"];
$quantidade = (int) $_POST["quantidade"];

if ($cod_cliente <= 0 || $cod_produto <= 0 || $quantidade <= 0) {
    die("Dados inválidos para realizar o pedido!");
}

$conexao->begin_transaction();

try {
    $sql = "UPDATE produto SET estoque = estoque - ? WHERE cod_produto = ? AND estoque >= ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("iii", $quantidade, $cod_produto, $quantidade);
    $stmt->execute();

    if ($stmt->affected_rows == 0) {
        throw new Exception("Produto não encontrado ou estoque insuficiente!");
    }

    $stmt->close();

    $data = date("Y-m-d");

    $sql = "INSERT INTO pedido (data, cod_cliente) VALUES (?, ?)";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("si", $data, $cod_cliente);
    $stmt->execute();

    $cod_pedido = $conexao->insert_id;
    $stmt->close();

    $sql = "SELECT preco FROM produto WHERE cod_produto = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $cod_produto);
    $stmt->execute();

    $resultado = $stmt->get_result();
    $produto = $resultado->fetch_assoc();
    $stmt->close();

    if (!$produto) {
        throw new Exception("Produto não encontrado!");
    }

    $preco_venda = $produto["preco"];

    $sql = "INSERT INTO detalhes (cod_pedido, cod_produto, quantidade, preco_venda) VALUES (?, ?, ?, ?)";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("iiid", $cod_pedido, $cod_produto, $quantidade, $preco_venda);
    $stmt->execute();
    $stmt->close();

    $conexao->commit();
    $sucesso = true;

} catch (Exception $erro) {
    $conexao->rollback();
    $mensagem = $erro->getMessage();
    $sucesso = false;
}

$conexao->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedido - NEXPLAY</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>

    <header>
        <h1>NEXPLAY</h1>
        <p>Área Administrativa</p>
    </header>

    <main>
        <?php if ($sucesso) { ?>
            <h2>✓ Pedido realizado!</h2>
            <p>O pedido foi cadastrado com sucesso.</p>
            <p>O estoque do produto foi atualizado.</p>
        <?php } else { ?>
            <h2>Erro ao realizar pedido</h2>
            <p><?php echo htmlspecialchars($mensagem); ?></p>
        <?php } ?>

        <br>
        <a href="pedidos.php">Cadastrar outro pedido</a>
        <a href="listar_pedidos.php">Consultar pedidos</a>
        <a href="admin.php">Voltar ao painel</a>
    </main>

</body>
</html>
