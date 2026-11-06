<?php
include("verificar_admin.php");
?>
<?php

include("conexao.php");

$id = (int) $_POST["cod_produto"];
$nome = $_POST["nome"];
$descricao = $_POST["descricao"];
$preco = $_POST["preco"];
$estoque = $_POST["estoque"];

$sql = "UPDATE produto SET nome = ?, descricao = ?, preco = ?, estoque = ? WHERE cod_produto = ?";

$stmt = $conexao->prepare($sql);
$stmt->bind_param("ssdii", $nome, $descricao, $preco, $estoque, $id);

$sucesso = $stmt->execute();

$stmt->close();
$conexao->close();

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atualização de Produto - NEXPLAY</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>

    <header>
        <h1>NEXPLAY</h1>
        <p>Área Administrativa</p>
    </header>

    <main>
        <?php if ($sucesso) { ?>
            <h2>✓ Produto atualizado!</h2>
            <p>As informações foram atualizadas com sucesso.</p>
        <?php } else { ?>
            <h2>Erro ao atualizar</h2>
            <p>Não foi possível atualizar o produto.</p>
        <?php } ?>

        <br>
        <a href="listar_produtos.php">Voltar para produtos</a>
        <a href="admin.php">Voltar ao painel</a>
    </main>

</body>
</html>
