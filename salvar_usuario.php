
<?php
include("conexao.php");

$nome = $_POST["nome"];
$CPF = $_POST["CPF"];
$telefone = $_POST["telefone"];
$email = $_POST["email"];
$senha = $_POST["senha"];
$confirmarSenha = $_POST["confirmar_senha"];

// Verifica se as senhas são iguais
if ($senha !== $confirmarSenha) {
    die("As senhas não coincidem. <a href='cadastro_usuario.php'>Voltar</a>");
}

// Verifica se o CPF ou e-mail já estão cadastrados
$sql = "SELECT cod_cliente FROM clientes WHERE CPF = ? OR email = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("ss", $CPF, $email);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {

    $stmt->close();
    $conexao->close();

    ?>

    <!DOCTYPE html>
    <html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Cadastro - NEXPLAY</title>
        <link rel="stylesheet" href="style.css">

        <style>
            .confirmacao-conta {
                max-width: 500px;
                margin: 60px auto;
                padding: 40px 25px;
                text-align: center;
                background: #17152b;
                border: 1px solid #7040c5;
                border-radius: 15px;
                box-shadow: 0 0 25px rgba(112, 64, 197, 0.2);
            }

            .icone-erro {
                width: 75px;
                height: 75px;
                margin: 0 auto 20px;
                border-radius: 50%;
                background: #472b32;
                color: #ff7777;
                font-size: 45px;
                line-height: 75px;
            }

            .confirmacao-conta h1 {
                color: white;
                margin-bottom: 15px;
            }

            .confirmacao-conta p {
                color: #cccccc;
                margin-bottom: 25px;
            }

            .confirmacao-conta a {
                display: block;
                padding: 13px;
                border-radius: 8px;
                text-decoration: none;
                font-weight: bold;
                background: #7040c5;
                color: white;
            }

            .confirmacao-conta a:hover {
                background: #8958df;
            }
        </style>
    </head>

    <body>

        <header>
            <a href="index.php">
                <img src="logo.png" alt="Logo da NEXPLAY" width="350">
            </a>
        </header>

        <main>

            <div class="confirmacao-conta">

                <div class="icone-erro">!</div>

                <h1>Cadastro não realizado</h1>

                <p>
                    Este CPF ou e-mail já está cadastrado em nossa loja.
                    Verifique os dados ou tente entrar na sua conta.
                </p>

                <a href="cadastro_usuario.php">Voltar ao cadastro</a>

                <br>

                <a href="login.php">Fazer login</a>

            </div>

        </main>

    </body>
    </html>

    <?php
    exit;
}

$stmt->close();

// Protege a senha
$senhaHash = password_hash($senha, PASSWORD_DEFAULT);

// Salva o novo usuário
$sql = "INSERT INTO clientes (nome, CPF, telefone, email, senha)
        VALUES (?, ?, ?, ?, ?)";

$stmt = $conexao->prepare($sql);
$stmt->bind_param("sssss", $nome, $CPF, $telefone, $email, $senhaHash);

$sucesso = $stmt->execute();

$stmt->close();
$conexao->close();

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - NEXPLAY</title>
    <link rel="stylesheet" href="style.css">

    <style>
        .confirmacao-conta {
            max-width: 500px;
            margin: 60px auto;
            padding: 40px 25px;
            text-align: center;
            background: #17152b;
            border: 1px solid #7040c5;
            border-radius: 15px;
            box-shadow: 0 0 25px rgba(112, 64, 197, 0.2);
        }

        .icone-sucesso {
            width: 75px;
            height: 75px;
            margin: 0 auto 20px;
            border-radius: 50%;
            background: #263d32;
            color: #55df91;
            font-size: 45px;
            line-height: 75px;
        }

        .confirmacao-conta h1 {
            color: #ffffff;
            margin-bottom: 15px;
        }

        .confirmacao-conta p {
            color: #cccccc;
            margin-bottom: 25px;
        }

        .botoes-confirmacao {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .botoes-confirmacao a {
            display: block;
            padding: 13px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            background: #7040c5;
            color: white;
        }

        .botoes-confirmacao a:hover {
            background: #8958df;
        }

        .botoes-confirmacao .botao-secundario {
            background: transparent;
            border: 1px solid #7040c5;
        }
    </style>
</head>

<body>

    <header>
        <a href="index.php">
            <img src="logo.png" alt="Logo da NEXPLAY" width="350">
        </a>
    </header>

    <main>

        <div class="confirmacao-conta">

            <?php if ($sucesso) { ?>

                <div class="icone-sucesso">✓</div>

                <h1>Conta criada com sucesso!</h1>

                <p>
                    Seja bem-vindo à NEXPLAY!
                    Sua conta está pronta. Agora você já pode aproveitar nossa loja.
                </p>

                <div class="botoes-confirmacao">
                    <a href="login.php">Fazer login</a>
                    <a href="index.php" class="botao-secundario">Voltar ao início</a>
                </div>

            <?php } else { ?>

                <h1>Ops! Algo deu errado.</h1>

                <p>Não foi possível realizar seu cadastro. Tente novamente.</p>

                <div class="botoes-confirmacao">
                    <a href="cadastro_usuario.php">Tentar novamente</a>
                </div>

            <?php } ?>

        </div>

    </main>

</body>
</html>
