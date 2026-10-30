
<?php

include("conexao.php");

$cod_cliente = (int) $_POST["cod_cliente"];
$cod_produto = (int) $_POST["cod_produto"];
$quantidade = (int) $_POST["quantidade"];

// Verifica se os dados são válidos
if ($cod_cliente <= 0 || $cod_produto <= 0 || $quantidade <= 0) {
    die("Dados inválidos para realizar o pedido!");
}

$conexao->begin_transaction();

try {

    // Verifica se existe estoque suficiente
    $sql = "UPDATE produto
            SET estoque = estoque - ?
            WHERE cod_produto = ?
            AND estoque >= ?";

    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("iii", $quantidade, $cod_produto, $quantidade);
    $stmt->execute();

    if ($stmt->affected_rows == 0) {
        throw new Exception("Produto não encontrado ou estoque insuficiente!");
    }

    $stmt->close();

    // Registra o pedido
    $data = date("Y-m-d");

    $sql = "INSERT INTO pedido (data, cod_cliente)
            VALUES (?, ?)";

    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("si", $data, $cod_cliente);
    $stmt->execute();

    $cod_pedido = $conexao->insert_id;
    $stmt->close();

    // Busca o preço do produto
    $sql = "SELECT preco FROM produto
            WHERE cod_produto = ?";

    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $cod_produto);
    $stmt->execute();

    $resultado = $stmt->get_result();
    $produto = $resultado->fetch_assoc();
    $stmt->close();

    if (!$produto) {
        throw new Exception("Produto não encontrado!");
    }

    $preco_venda = $produto["preco"];

    // Registra os detalhes do pedido
    $sql = "INSERT INTO detalhes
            (cod_pedido, cod_produto, quantidade, preco_venda)
            VALUES (?, ?, ?, ?)";

    $stmt = $conexao->prepare($sql);
    $stmt->bind_param(
        "iiid",
        $cod_pedido,
        $cod_produto,
        $quantidade,
        $preco_venda
    );

    $stmt->execute();
    $stmt->close();

    $conexao->commit();

    echo "Pedido cadastrado com sucesso!";

} catch (Exception $erro) {

    $conexao->rollback();

    echo "Erro ao cadastrar pedido: " . $erro->getMessage();

}

$conexao->close();

?>
