
<?php
session_start();
include("conexao.php");

// Verifica se é administrador ou cliente
$eh_admin = isset($_SESSION["admin_logado"]) &&
            $_SESSION["admin_logado"] === true;

$eh_cliente = isset($_SESSION["cod_cliente"]);

if (!$eh_admin && !$eh_cliente) {
    header("Location: login.php");
    exit;
}

// Verifica o ID do pedido
if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    header("Location: " . ($eh_admin ? "listar_pedidos.php" : "minha_conta.php"));
    exit;
}

$id = (int) $_GET["id"];

try {
    $conexao->begin_transaction();

    // Busca o pedido e verifica quem é o proprietário
    $sql = "SELECT status, cod_cliente
            FROM pedido
            WHERE cod_pedido = ?
            FOR UPDATE";

    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $resultado = $stmt->get_result();

    if ($resultado->num_rows == 0) {
        throw new Exception("Pedido não encontrado.");
    }

    $pedido = $resultado->fetch_assoc();
    $stmt->close();

    // Cliente só pode cancelar o próprio pedido
    if (!$eh_admin && $pedido["cod_cliente"] != $_SESSION["cod_cliente"]) {
        throw new Exception("Você não tem permissão para cancelar este pedido.");
    }

    // Verifica se já foi cancelado
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
    $stmt->close();

    // Atualiza o status do pedido
    $sql = "UPDATE pedido
            SET status = 'Cancelado'
            WHERE cod_pedido = ?";

    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    $conexao->commit();

    $mensagem = "Pedido cancelado e estoque atualizado com sucesso!";

} catch (Exception $erro) {

    $conexao->rollback();
    $mensagem = $erro->getMessage();
}

$conexao->close();

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cancelar Pedido - NEXPLAY</title>

    <link rel="stylesheet" href="<?php echo $eh_admin ? 'admin.css' : 'style.css'; ?>">
</head>

<body>

    <main>
        <h1>Cancelamento de Pedido</h1>

        <p><?php echo htmlspecialchars($mensagem); ?></p>

        <?php if ($eh_admin) { ?>
            <a href="listar_pedidos.php">Voltar para pedidos</a>
        <?php } else { ?>
            <a href="minha_conta.php">Voltar para minha conta</a>
        <?php } ?>
    </main>

</body>
</html>
