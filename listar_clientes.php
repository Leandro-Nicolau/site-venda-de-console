
<?php
include("conexao.php");

$sql = "SELECT * FROM clientes";
$resultado = $conexao->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes - NEXPLAY</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>

    <header>
        <h1>NEXPLAY</h1>
        <p>Área Administrativa</p>
    </header>

    <main>
        <h2>Clientes cadastrados</h2>

        <table>
            <tr>
                <th>Código</th>
                <th>Nome</th>
                <th>CPF</th>
                <th>Telefone</th>
                <th>E-mail</th>
                <th>Ações</th>
            </tr>

            <?php while ($cliente = $resultado->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $cliente["cod_cliente"]; ?></td>
                    <td><?php echo htmlspecialchars($cliente["nome"]); ?></td>
                    <td><?php echo htmlspecialchars($cliente["CPF"]); ?></td>
                    <td><?php echo htmlspecialchars($cliente["telefone"]); ?></td>
                    <td><?php echo htmlspecialchars($cliente["email"]); ?></td>
                    <td>
                        <a href="editar_cliente.php?id=<?php echo $cliente["cod_cliente"]; ?>">Editar</a>
                        <a href="excluir_cliente.php?id=<?php echo $cliente["cod_cliente"]; ?>"
                           onclick="return confirm('Tem certeza que deseja excluir este cliente?');">
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
