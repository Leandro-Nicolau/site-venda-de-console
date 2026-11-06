
<?php
include("verificar_login.php");
include("conexao.php");

$cod_cliente = $_SESSION["cod_cliente"];

$sql = "SELECT nome, CPF, telefone, email
        FROM clientes
        WHERE cod_cliente = ?";

$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $cod_cliente);
$stmt->execute();

$resultado = $stmt->get_result();
$cliente = $resultado->fetch_assoc();

$stmt->close();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar meus dados - NEXPLAY</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <header>
        <img src="logo.png" alt="Logo da NEXPLAY" width="350">
    </header>

    <main>

        <h1>Editar meus dados</h1>

        <form method="POST" action="atualizar_meus_dados.php">

            <label for="nome">Nome:</label>
            <input
                type="text"
                id="nome"
                name="nome"
                value="<?php echo htmlspecialchars($cliente["nome"]); ?>"
                required
            >

            <br><br>

            <label for="CPF">CPF:</label>
            <input
                type="text"
                id="CPF"
                name="CPF"
                value="<?php echo htmlspecialchars($cliente["CPF"]); ?>"
                required
            >

            <br><br>

            <label for="telefone">Telefone:</label>
            <input
                type="text"
                id="telefone"
                name="telefone"
                value="<?php echo htmlspecialchars($cliente["telefone"]); ?>"
                required
            >

            <br><br>

            <label for="email">E-mail:</label>
            <input
                type="email"
                id="email"
                name="email"
                value="<?php echo htmlspecialchars($cliente["email"]); ?>"
                required
            >

            <br><br>

            <h3>Alterar senha</h3>
            <p>Deixe os campos abaixo vazios caso não queira trocar sua senha.</p>

            <label for="senha">Nova senha:</label>
            <input
                type="password"
                id="senha"
                name="senha"
            >

            <br><br>

            <label for="confirmar_senha">Confirmar nova senha:</label>
            <input
                type="password"
                id="confirmar_senha"
                name="confirmar_senha"
            >

            <br><br>

            <button type="submit">Salvar alterações</button>

        </form>

        <br>

        <a href="minha_conta.php">Voltar para minha conta</a>

    </main>

</body>
</html>

<?php
$conexao->close();
?>
