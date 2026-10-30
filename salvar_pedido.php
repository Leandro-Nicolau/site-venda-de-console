
<?php

include("conexao.php");

$cod_cliente = $_POST["cod_cliente"];
$cod_produto = $_POST["cod_produto"];
$quantidade = $_POST["quantidade"];

$conexao->begin_transaction();

try {

    $data = date("Y-m-d");

    $sql = "INSERT INTO pedido (data, cod_cliente)
            VALUES ('$data', '$cod_cliente')";

    if (!$conexao->query($sql)) {
        throw new Exception($conexao->error);
    }

    $cod_pedido = $conexao->insert_id;

    $sql = "SELECT preco FROM produto
            WHERE cod_produto = '$cod_produto'";

    $resultado = $conexao->query($sql);
    $produto = $resultado->fetch_assoc();

    $preco_venda = $produto["preco"];

    $sql = "INSERT INTO detalhes
            (cod_pedido, cod_produto, quantidade, preco_venda)
            VALUES ('$cod_pedido', '$cod_produto',
                    '$quantidade', '$preco_venda')";

    if (!$conexao->query($sql)) {
        throw new Exception($conexao->error);
    }

    $sql = "UPDATE produto
            SET estoque = estoque - $quantidade
            WHERE cod_produto = '$cod_produto'
            AND estoque >= $quantidade";

    if (!$conexao->query($sql) || $conexao->affected_rows == 0) {
        throw new Exception("Estoque insuficiente!");
    }

    $conexao->commit();

    echo "Pedido cadastrado com sucesso!";

} catch (Exception $erro) {

    $conexao->rollback();

    echo "Erro ao cadastrar pedido: " . $erro->getMessage();

}

$conexao->close();

?>
