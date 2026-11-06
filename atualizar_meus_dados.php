
<?php
include("verificar_login.php");
include("conexao.php");

$cod_cliente = $_SESSION["cod_cliente"];

$nome = trim($_POST["nome"]);
$CPF = trim($_POST["CPF"]);
$telefone = trim($_POST["telefone"]);
$email = trim($_POST["email"]);

$senha = $_POST["senha"];
$confirmar_senha = $_POST["confirmar_senha"];

// Verifica se CPF ou e-mail já pertencem a outro cliente
$sql = "SELECT cod_cliente FROM clientes
        WHERE (CPF = ? OR email = ?)
        AND cod_cliente <> ?";

$stmt = $conexao->prepare($sql);
$stmt->bind_param("ssi", $CPF, $email, $cod_cliente);
$stmt->execute();

$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {
    echo "<script>
            alert('Este CPF ou e-mail já está cadastrado!');
            window.location.href = 'editar_meus_dados.php';
          </script>";
    exit;
}

$stmt->close();

// Verifica se o cliente deseja alterar a senha
if ($senha != "" || $confirmar_senha != "") {

    if ($senha != $confirmar_senha) {
        echo "<script>
                alert('As senhas não coincidem!');
                window.location.href = 'editar_meus_dados.php';
              </script>";
        exit;
    }

    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    $sql = "UPDATE clientes
            SET nome = ?, CPF = ?, telefone = ?, email = ?, senha = ?
            WHERE cod_cliente = ?";

    $stmt = $conexao->prepare($sql);
    $stmt->bind_param(
        "sssssi",
        $nome,
        $CPF,
        $telefone,
        $email,
        $senha_hash,
        $cod_cliente
    );

} else {

    // Atualiza os dados sem alterar a senha
    $sql = "UPDATE clientes
            SET nome = ?, CPF = ?, telefone = ?, email = ?
            WHERE cod_cliente = ?";

    $stmt = $conexao->prepare($sql);
    $stmt->bind_param(
        "ssssi",
        $nome,
        $CPF,
        $telefone,
        $email,
        $cod_cliente
    );
}

if ($stmt->execute()) {

    $_SESSION["nome_cliente"] = $nome;

    echo "<script>
            alert('Seus dados foram atualizados com sucesso!');
            window.location.href = 'minha_conta.php';
          </script>";

} else {

    echo "<script>
            alert('Erro ao atualizar seus dados!');
            window.location.href = 'editar_meus_dados.php';
          </script>";
}

$stmt->close();
$conexao->close();
?>
