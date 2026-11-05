
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
    die("CPF ou e-mail já cadastrado. <a href='cadastro_usuario.php'>Voltar</a>");
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

if ($sucesso) {
    echo "Cadastro realizado com sucesso! <a href='login.php'>Fazer login</a>";
} else {
    echo "Erro ao realizar cadastro.";
}
?>
