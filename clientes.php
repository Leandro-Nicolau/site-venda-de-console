
<?php
include("conexao.php");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Clientes - NEXPLAY</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>

    <h1>Cadastro de Clientes</h1>

    <form action="salvar_cliente.php" method="POST">

        <label>Nome:</label>
        <input type="text" name="nome" required>

        <label>CPF:</label>
        <input type="text" name="CPF" required>

        <label>Telefone:</label>
        <input type="text" name="telefone" required>

        <label>E-mail:</label>
        <input type="email" name="email" required>

        <button type="submit">Cadastrar Cliente</button>

    </form>

</body>
</html>
