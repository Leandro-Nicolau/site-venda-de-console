
<?php

include("conexao.php");

$id = (int) $_GET["id"];

$sql = "SELECT * FROM produto WHERE cod_produto = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

$resultado = $stmt->get_result();
$produto = $resultado->fetch_assoc();

$stmt->close();
$conexao->close();

if (!$produto) {
    die("Produto não encontrado!");
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Produto - NEXPLAY</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>

    <header>
        <h1>NEXPLAY</h1>
        <p>Área Administrativa</p>
    </header>

    <main>
        <h2>Editar Produto</h2>

        <form action="atualizar_produto.php" method="POST">

            <input type="hidden" name="cod_produto"
                   value="<?php echo $produto["cod_produto"]; ?>">

            <label>Nome:</label>
            <input type="text" name="nome"
                   value="<?php echo htmlspecialchars($produto["nome"]); ?>" required>

            <label>Descrição:</label>
            <input type="text" name="descricao"
                   value="<?php echo htmlspecialchars($produto["descricao"]); ?>" required>

            <label>Preço:</label>
            <input type="number" name="preco" step="0.01" min="0"
                   value="<?php echo $produto["preco"]; ?>" required>

            <label>Estoque:</label>
            <input type="number" name="estoque" min="0"
                   value="<?php echo $produto["estoque"]; ?>" required>

            <button type="submit">Salvar alterações</button>

        </form>

        <a href="listar_produtos.php">Voltar para produtos</a>
    </main>

</body>
</html>
