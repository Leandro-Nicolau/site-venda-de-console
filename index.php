<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NEXPLAY</title>

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

    <div class="banner">
        <h1>NEXPLAY</h1>
        <h2>Seu próximo nível começa aqui.</h2>
    </div>

    <section>
        <h2>Sobre nós</h2>

        <p>
            A NEXPLAY é uma loja especializada em videogames, consoles,
            jogos e acessórios para todos os tipos de jogadores.
        </p>

        <p>
            Nosso objetivo é oferecer produtos de qualidade e proporcionar
            a melhor experiência para os gamers.
        </p>
    </section>

    <section>
        <h2>Produtos em destaque</h2>

        <div>
            <img src="ps5.png" alt="PlayStation 5" width="200">
            <h3>PlayStation 5</h3>
            <p>
                Console de nova geração com gráficos incríveis e alta performance.
            </p>
        </div>

        <div>
            <img src="xbox.png" alt="Xbox Series X" width="200">
            <h3>Xbox Series X</h3>
            <p>
                Console poderoso para uma experiência de jogo rápida e imersiva.
            </p>
        </div>

        <div>
            <img src="nintendo.png" alt="Nintendo Switch" width="200">
            <h3>Nintendo Switch</h3>
            <p>
                Console versátil que permite jogar tanto na TV quanto no modo portátil.
            </p>
        </div>
    </section>

    <footer>

        <h3>Entre em contato</h3>

        <p>E-mail: contato@nexplay.com.br</p>
        <p>Telefone: (19) 99999-9999</p>

        <p>Siga a NEXPLAY:</p>

        <a href="https://www.instagram.com/leandrodearaujonic?igsi=MWsyZ2dtb2s0dG9ydw==" target="_blank">
            Instagram
        </a>

        <a href="#">Facebook</a>
        <a href="#">TikTok</a>

        <p>&copy; 2026 NEXPLAY - Todos os direitos reservados.</p>

    </footer>

</body>
</html>