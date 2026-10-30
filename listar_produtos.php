
<?php

include("conexao.php");

$sql = "SELECT * FROM produto";
$resultado = $conexao->query($sql);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Produtos - NEXPLAY</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>

    <h1>Produtos cadastrados</h1>

    <table border="1">

        <tr>
            <th>Código</th>
            <th>Nome</th>
            <th>Descrição</th>
            <th>Preço</th>
            <th>Estoque</th>
        </tr>

        <?php
        while ($produto = $resultado->fetch_assoc()) {
        ?>

        <tr>
            <td><?php echo $produto["cod_produto"]; ?></td>
            <td><?php echo htmlspecialchars($produto["nome"]); ?></td>
            <td><?php echo htmlspecialchars($produto["descricao"]); ?></td>
            <td>R$ <?php echo number_format($produto["preco"], 2, ",", "."); ?></td>
            <td><?php echo $produto["estoque"]; ?></td>
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
