
<?php
include("conexao.php");

$id = (int) $_GET["id"];

$sql = "SELECT * FROM clientes WHERE cod_cliente = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

$resultado = $stmt->get_result();
$cliente = $resultado->fetch_assoc();

$stmt->close();
$conexao->close();

if (!$cliente) {
    die("Cliente não encontrado!");
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cliente - NEXPLAY</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>

    <header>
        <h1>NEXPLAY</h1>
        <p>Área Administrativa</p>
    </header>

    <main>
        <h2>Editar Cliente</h2>

        <form action="atualizar_cliente.php" method="POST">

            <input type="hidden" name="cod_cliente"
                   value="<?php echo $cliente["cod_cliente"]; ?>">

            <label>Nome:</label>
            <input type="text" name="nome"
                   value="<?php echo htmlspecialchars($cliente["nome"]); ?>" required>

            <label>CPF:</label>
            <input type="text" name="CPF"
                   value="<?php echo htmlspecialchars($cliente["CPF"]); ?>" required>

            <label>Telefone:</label>
            <input type="text" name="telefone"
                   value="<?php echo htmlspecialchars($cliente["telefone"]); ?>" required>

            <label>E-mail:</label>
            <input type="email" name="email"
                   value="<?php echo htmlspecialchars($cliente["email"]); ?>" required>

            <button type="submit">Salvar alterações</button>

        </form>

        <a href="listar_clientes.php">Voltar para clientes</a>
    </main>

</body>
</html>
