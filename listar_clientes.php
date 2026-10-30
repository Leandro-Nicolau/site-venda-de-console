
<?php

include("conexao.php");

$sql = "SELECT * FROM clientes";
$resultado = $conexao->query($sql);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Clientes - NEXPLAY</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>

    <h1>Clientes cadastrados</h1>

    <table border="1">

        <tr>
            <th>Código</th>
            <th>Nome</th>
            <th>CPF</th>
            <th>Telefone</th>
            <th>E-mail</th>
        </tr>

        <?php
        while ($cliente = $resultado->fetch_assoc()) {
        ?>

        <tr>
            <td><?php echo $cliente["cod_cliente"]; ?></td>
            <td><?php echo htmlspecialchars($cliente["nome"]); ?></td>
            <td><?php echo htmlspecialchars($cliente["CPF"]); ?></td>
            <td><?php echo htmlspecialchars($cliente["telefone"]); ?></td>
            <td><?php echo htmlspecialchars($cliente["email"]); ?></td>
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
