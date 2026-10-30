
<?php

include("conexao.php");

$nome = $_POST["nome"];
$descricao = $_POST["descricao"];
$preco = $_POST["preco"];
$estoque = $_POST["estoque"];

$sql = "INSERT INTO produto (nome, descricao, preco, estoque)
        VALUES ('$nome', '$descricao', '$preco', '$estoque')";

if ($conexao->query($sql) === TRUE) {
    echo "Produto cadastrado com sucesso!";
} else {
    echo "Erro ao cadastrar produto: " . $conexao->error;
}

$conexao->close();

?>
