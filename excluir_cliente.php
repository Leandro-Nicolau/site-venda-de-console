
<?php

include("conexao.php");

$id = (int) $_GET["id"];

// Verifica se o cliente possui pedidos
$sql = "SELECT COUNT(*) AS total FROM pedido WHERE cod_cliente = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

$resultado = $stmt->get_result();
$dados = $resultado->fetch_assoc();

$stmt->close();

if ($dados["total"] > 0) {

    $status = "bloqueado";

} else {

    // Exclui o cliente caso não tenha pedidos
    $sql = "DELETE FROM clientes WHERE cod_cliente = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $id);

    $sucesso = $stmt->execute();

    $stmt->close();

    $status = $sucesso ? "sucesso" : "erro";
}

$conexao->close();

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excluir Cliente - NEXPLAY</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>

    <header>
        <h1>NEXPLAY</h1>
        <p>Área Administrativa</p>
    </header>

    <main>

        <?php if ($status == "bloqueado") { ?>

            <h2>Não foi possível excluir!</h2>

            <p>
                Este cliente possui pedidos cadastrados no sistema.
                Para preservar o histórico de compras, ele não pode ser excluído.
            </p>

        <?php } elseif ($status == "sucesso") { ?>

            <h2>✓ Cliente excluído!</h2>

            <p>O cliente foi removido com sucesso.</p>

        <?php } else { ?>

            <h2>Erro ao excluir!</h2>

            <p>Não foi possível excluir o cliente.</p>

        <?php } ?>

        <br>

        <a href="listar_clientes.php">Voltar para clientes</a>
        <a href="admin.php">Voltar ao painel</a>

    </main>

</body>
</html>
