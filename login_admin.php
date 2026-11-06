<?php
session_start();

include("config_admin.php");

$erro = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $senha = $_POST["senha"];

    if (password_verify($senha, $senha_admin_hash)) {

        session_regenerate_id(true);

        $_SESSION["admin_logado"] = true;

        header("Location: admin.php");
        exit;

    } else {

        $erro = "Senha incorreta!";

    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Administrativo - NEXPLAY</title>
    <link rel="stylesheet" href="admin.css">
</head>

<body>

    <header>
        <h1>NEXPLAY</h1>
        <p>Acesso Administrativo</p>
    </header>

    <main>

        <h2>Área Administrativa</h2>
        <p>Digite a senha para continuar.</p>

        <?php if ($erro != "") { ?>
            <p><?php echo $erro; ?></p>
        <?php } ?>

        <form method="POST">

            <label for="senha">Senha:</label>

            <input
                type="password"
                id="senha"
                name="senha"
                required
            >

            <br><br>

            <button type="submit">Entrar</button>

        </form>

        <br>

        <a href="index.php">Voltar para a loja</a>

    </main>

</body>
</html>