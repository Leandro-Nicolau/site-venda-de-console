
<?php

include("conexao.php");

$nome = $_POST["nome"];
$CPF = $_POST["CPF"];
$telefone = $_POST["telefone"];
$email = $_POST["email"];

$sql = "INSERT INTO clientes (nome, CPF, telefone, email)
        VALUES (?, ?, ?, ?)";

$stmt = $conexao->prepare($sql);

$stmt->bind_param("ssss", $nome, $CPF, $telefone, $email);

if ($stmt->execute()) {
    echo "Cliente cadastrado com sucesso!";
} else {
    echo "Erro ao cadastrar cliente: " . $stmt->error;
}

$stmt->close();
$conexao->close();

?>
