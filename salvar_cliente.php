<?php
include("verificar_admin.php");
?>
<?php
include("conexao.php");

$nome = $_POST["nome"];
$CPF = $_POST["CPF"];
$telefone = $_POST["telefone"];
$email = $_POST["email"];

$sql = "INSERT INTO clientes (nome, CPF, telefone, email) VALUES (?, ?, ?, ?)";

$stmt = $conexao->prepare($sql);
$stmt->bind_param("ssss", $nome, $CPF, $telefone, $email);

$sucesso = $stmt->execute();

$stmt->close();
$conexao->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Cliente - NEXPLAY</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>

    <header>
        <h1>NEXPLAY</h1>
        <p>Área Administrativa</p>
    </header>

    <main>
        <?php if ($sucesso) { ?>
            <h2>✓ Cadastro realizado!</h2>
            <p>O cliente foi cadastrado com sucesso.</p>
        <?php } else { ?>
            <h2>Erro no cadastro</h2>
            <p>Não foi possível cadastrar o cliente.</p>
        <?php } ?>

        <br>
        <a href="clientes.php">Cadastrar outro cliente</a>
        <a href="admin.php">Voltar ao painel</a>
    </main>

</body>
</html>
