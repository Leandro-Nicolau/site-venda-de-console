
<?php
session_start();
include("conexao.php");

$erro = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST["email"];
    $senha = $_POST["senha"];

    $sql = "SELECT * FROM clientes WHERE email = ? AND senha IS NOT NULL";

    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {

        $cliente = $resultado->fetch_assoc();

        if (password_verify($senha, $cliente["senha"])) {

            $_SESSION["cod_cliente"] = $cliente["cod_cliente"];
            $_SESSION["nome_cliente"] = $cliente["nome"];

            header("Location: index.php");
            exit;

        } else {
            $erro = "E-mail ou senha incorretos.";
        }

    } else {
        $erro = "E-mail ou senha incorretos.";
    }

    $stmt->close();
    $conexao->close();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - NEXPLAY</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <header>
        <img src="logo.png" alt="Logo da NEXPLAY" width="350">
        <nav>
            <a href="index.php">Início</a>
            <a href="catalogo.php">Produtos</a>
            <a href="cadastro_usuario.php">Criar conta</a>
        </nav>
    </header>

    <main>
        <h1>Entrar na NEXPLAY</h1>

        <?php if ($erro != "") { ?>
            <p><?php echo $erro; ?></p>
        <?php } ?>

        <form method="POST" action="login.php">

            <label>E-mail:</label>
            <input type="email" name="email" required>

            <label>Senha:</label>
            <input type="password" name="senha" required>

            <button type="submit">Entrar</button>

        </form>

        <p>Ainda não tem conta?
            <a href="cadastro_usuario.php">Cadastre-se</a>
        </p>
    </main>

</body>
</html>
