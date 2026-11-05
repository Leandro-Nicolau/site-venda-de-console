<?php
session_start();

include("conexao.php");

$sql = "SELECT * FROM produto ORDER BY cod_produto DESC";
$resultado = $conexao->query($sql);
?>

<?php
include("conexao.php");

$sql = "SELECT * FROM produto ORDER BY cod_produto DESC";
$resultado = $conexao->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NEXPLAY - Produtos</title>

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
    <a href="contato.html">Contato</a>
    <a href="carrinho.html">
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

    <h1>Produtos</h1>

    <section>
        <h2>Consoles</h2>

        <div id="catalogo">

            <?php while ($produto = $resultado->fetch_assoc()) { ?>

                <div class="produto">

                    <h3><?php echo htmlspecialchars($produto["nome"]); ?></h3>

                    <p><?php echo htmlspecialchars($produto["descricao"]); ?></p>

                    <p>
                        R$ <?php echo number_format($produto["preco"], 2, ",", "."); ?>
                    </p>

                    <?php if ($produto["estoque"] > 0) { ?>

                        <button onclick="adicionarAoCarrinho(
                            <?php echo (int)$produto['cod_produto']; ?>,
                            '<?php echo htmlspecialchars(addslashes($produto['nome']), ENT_QUOTES); ?>',
                            <?php echo (float)$produto['preco']; ?>
                        )">
                            Adicionar ao carrinho
                        </button>

                    <?php } else { ?>

                        <p>Produto indisponível</p>

                    <?php } ?>

                </div>

            <?php } ?>

        </div>
    </section>

    <footer>
        <h3>Entre em contato</h3>
        <p>E-mail: contato@nexplay.com.br</p>
        <p>Telefone: (19) 99999-9999</p>
        <p>&copy; 2026 NEXPLAY - Todos os direitos reservados.</p>
    </footer>

</body>
</html>

<?php
$conexao->close();
?>
