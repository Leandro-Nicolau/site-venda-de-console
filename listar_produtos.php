
<?php
include("conexao.php");

$sql = "SELECT * FROM produto";
$resultado = $conexao->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos - NEXPLAY</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>

    <header>
        <h1>NEXPLAY</h1>
        <p>Área Administrativa</p>
    </header>

    <main>
        <h2>Produtos cadastrados</h2>

        <table>
            <tr>
                <th>Código</th>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Preço</th>
                <th>Estoque</th>
                <th>Ações</th>
            </tr>

            <?php while ($produto = $resultado->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $produto["cod_produto"]; ?></td>
                    <td><?php echo htmlspecialchars($produto["nome"]); ?></td>
                    <td><?php echo htmlspecialchars($produto["descricao"]); ?></td>
                    <td>R$ <?php echo number_format($produto["preco"], 2, ",", "."); ?></td>
                    <td><?php echo $produto["estoque"]; ?></td>
                    <td>
                        <a href="editar_produto.php?id=<?php echo $produto["cod_produto"]; ?>">Editar</a>

                        <a href="excluir_produto.php?id=<?php echo $produto["cod_produto"]; ?>"
                           onclick="return confirm('Tem certeza que deseja excluir este produto?');">
                            Excluir
                        </a>
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
