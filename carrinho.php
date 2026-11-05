<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NEXPLAY - Carrinho</title>

    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
</head>

<body>

    <header>

        <img src="logo.png" alt="Logo da NEXPLAY" width="350">

        <button id="menu-toggle">☰</button>

        <nav id="menu">

    <a href="index.php">Início</a>
    <a href="catalogo.php">Produtos</a>
    <a href="contato.php">Contato</a>

    <a href="carrinho.php">
        Carrinho (<span id="contador-carrinho">0</span>)
    </a>

    <?php if (isset($_SESSION["cod_cliente"])) { ?>

        <a href="minha_conta.php">Minha Conta</a>
        <a href="logout.php">Sair</a>

    <?php } else { ?>

        <a href="login.php">Entrar</a>
        <a href="cadastro_usuario.php">Criar conta</a>

    <?php } ?>

    <a href="admin.php">Área Administrativa</a>

</nav>

    </header>

    <h1>Meu Carrinho</h1>

    <section>

        <div id="lista-carrinho"></div>

    </section>

    <section>

        <h2>Finalizar compra</h2>

       
<form id="form-compra" method="POST" action="finalizar_compra.php">

    <p>Você está comprando com sua conta NEXPLAY.</p>

    <input type="hidden" name="carrinho" id="carrinho-dados">

    <button type="submit">Finalizar compra</button>

</form>


    </section>

    <footer>

        <h3>Entre em contato</h3>

        <p>E-mail: contato@nexplay.com.br</p>
        <p>Telefone: (19) 99999-9999</p>

        <p>Siga a NEXPLAY:</p>

        <a href="#">Instagram</a>
        <a href="#">Facebook</a>
        <a href="#">TikTok</a>

        <p>&copy; 2026 NEXPLAY - Todos os direitos reservados.</p>

    </footer>

</body>
</html>
