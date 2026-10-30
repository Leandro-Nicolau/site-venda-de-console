
<?php

include("conexao.php");

$nome = $_POST["nome"];
$CPF = $_POST["CPF"];
$telefone = $_POST["telefone"];
$email = $_POST["email"];

$sql = "INSERT INTO clientes (nome, CPF, telefone, email)
        VALUES ('$nome', '$CPF', '$telefone', '$email')";

if ($conexao->query($sql) === TRUE) {
    echo "Cliente cadastrado com sucesso!";
} else {
    echo "Erro ao cadastrar cliente: " . $conexao->error;
}

$conexao->close();

?>
