
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Conta - NEXPLAY</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <header>
        <img src="logo.png" alt="Logo da NEXPLAY" width="350">
        <nav>
            <a href="index.html">Início</a>
            <a href="catalogo.php">Produtos</a>
            <a href="login.php">Login</a>
        </nav>
    </header>

    <main>
        <h1>Crie sua conta</h1>
        <p>Cadastre-se para aproveitar a NEXPLAY!</p>

        <form action="salvar_usuario.php" method="POST">

            <label>Nome completo:</label>
            <input type="text" name="nome" required>

            <label>CPF:</label>
            <input type="text" name="CPF" maxlength="11" required>

            <label>Telefone:</label>
            <input type="text" name="telefone" required>

            <label>E-mail:</label>
            <input type="email" name="email" required>

            <label>Senha:</label>
            <input type="password" name="senha" required>

            <label>Confirmar senha:</label>
            <input type="password" name="confirmar_senha" required>

            <button type="submit">Criar minha conta</button>

        </form>

        <p>Já possui uma conta? <a href="login.php">Faça login</a></p>
    </main>

</body>
</html>
