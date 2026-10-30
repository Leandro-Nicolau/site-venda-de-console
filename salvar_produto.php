
<?php

include("conexao.php");

$nome = $_POST["nome"];
$descricao = $_POST["descricao"];
$preco = $_POST["preco"];
$estoque = $_POST["estoque"];

$sql = "INSERT INTO produto (nome, descricao, preco, estoque)
        VALUES (?, ?, ?, ?)";

$stmt = $conexao->prepare($sql);

$stmt->bind_param("ssdi", $nome, $descricao, $preco, $estoque);

if ($stmt->execute()) {
    echo "Produto cadastrado com sucesso!";
} else {
    echo "Erro ao cadastrar produto: " . $stmt->error;
}

$stmt->close();
$conexao->close();

?>
