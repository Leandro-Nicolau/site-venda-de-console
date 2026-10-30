
<?php

include("conexao.php");

$id = (int) $_POST["cod_cliente"];
$nome = $_POST["nome"];
$CPF = $_POST["CPF"];
$telefone = $_POST["telefone"];
$email = $_POST["email"];

$sql = "UPDATE clientes SET nome = ?, CPF = ?, telefone = ?, email = ? WHERE cod_cliente = ?";

$stmt = $conexao->prepare($sql);
$stmt->bind_param("ssssi", $nome, $CPF, $telefone, $email, $id);

$sucesso = $stmt->execute();

$stmt->close();
$conexao->close();

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atualização de Cliente - NEXPLAY</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>

    <header>
        <h1>NEXPLAY</h1>
        <p>Área Administrativa</p>
    </header>

    <main>
        <?php if ($sucesso) { ?>
            <h2>✓ Cliente atualizado!</h2>
            <p>As informações foram atualizadas com sucesso.</p>
        <?php } else { ?>
            <h2>Erro ao atualizar</h2>
            <p>Não foi possível atualizar o cliente.</p>
        <?php } ?>

        <br>
        <a href="listar_clientes.php">Voltar para clientes</a>
        <a href="admin.php">Voltar ao painel</a>
    </main>

</body>
</html>
