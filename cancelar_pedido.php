<?php
include("verificar_admin.php");
?>
<?php
include("conexao.php");

$id = $_GET["id"];

try {
    $conexao->begin_transaction();

    // Verifica se o pedido existe e está ativo
    $sql = "SELECT status FROM pedido WHERE cod_pedido = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $resultado = $stmt->get_result();

    if ($resultado->num_rows == 0) {
        throw new Exception("Pedido não encontrado.");
    }

    $pedido = $resultado->fetch_assoc();

    if ($pedido["status"] == "Cancelado") {
        throw new Exception("Este pedido já foi cancelado.");
    }

    // Devolve os produtos ao estoque
    $sql = "UPDATE produto
            INNER JOIN detalhes
                ON produto.cod_produto = detalhes.cod_produto
            SET produto.estoque = produto.estoque + detalhes.quantidade
            WHERE detalhes.cod_pedido = ?";

    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    // Atualiza o status do pedido
    $sql = "UPDATE pedido
            SET status = 'Cancelado'
            WHERE cod_pedido = ?";

    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $conexao->commit();

    $mensagem = "Pedido cancelado e estoque atualizado com sucesso!";

} catch (Exception $erro) {
    $conexao->rollback();
    $mensagem = $erro->getMessage();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cancelar Pedido - NEXPLAY</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>

<header>
    <h1>NEXPLAY</h1>
    <p>Área Administrativa</p>
</header>

<main>
    <h2>Cancelamento de Pedido</h2>

    <p><?php echo htmlspecialchars($mensagem); ?></p>

    <a href="listar_pedidos.php">Voltar para pedidos</a>
</main>

</body>
</html>
