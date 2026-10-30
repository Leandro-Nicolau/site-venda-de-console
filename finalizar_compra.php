
<?php
include("conexao.php");

// Recebe os dados do formulário
$nome = trim($_POST["nome"]);
$CPF = trim($_POST["CPF"]);
$telefone = trim($_POST["telefone"]);
$email = trim($_POST["email"]);

$carrinho = json_decode($_POST["carrinho"], true);

echo "<pre>";
var_dump($_POST);
echo "</pre>";
exit;


// Verifica se os dados foram recebidos
if (
    $nome == "" ||
    $CPF == "" ||
    $telefone == "" ||
    $email == "" ||
    !is_array($carrinho) ||
    count($carrinho) == 0
) {
    die("Dados inválidos. Volte ao carrinho e tente novamente.");
}

try {

    $conexao->begin_transaction();

    // Verifica se o cliente já está cadastrado pelo CPF
    $sql = "SELECT cod_cliente FROM clientes WHERE CPF = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("s", $CPF);
    $stmt->execute();

    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {

        $cliente = $resultado->fetch_assoc();
        $cod_cliente = $cliente["cod_cliente"];

        // Atualiza os dados do cliente
        $sql = "UPDATE clientes
                SET nome = ?, telefone = ?, email = ?
                WHERE cod_cliente = ?";

        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("sssi", $nome, $telefone, $email, $cod_cliente);
        $stmt->execute();

    } else {

        // Cadastra um novo cliente
        $sql = "INSERT INTO clientes (nome, CPF, telefone, email)
                VALUES (?, ?, ?, ?)";

        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("ssss", $nome, $CPF, $telefone, $email);
        $stmt->execute();

        $cod_cliente = $conexao->insert_id;
    }

    // Cria o pedido
    $data = date("Y-m-d");

    $sql = "INSERT INTO pedido (data, cod_cliente, status)
            VALUES (?, ?, 'Ativo')";

    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("si", $data, $cod_cliente);
    $stmt->execute();

    $cod_pedido = $conexao->insert_id;

    // Prepara os comandos dos produtos
    $sqlEstoque = "UPDATE produto
                   SET estoque = estoque - ?
                   WHERE cod_produto = ? AND estoque >= ?";

    $sqlPreco = "SELECT preco FROM produto WHERE cod_produto = ?";

    $sqlDetalhes = "INSERT INTO detalhes
                    (cod_pedido, cod_produto, quantidade, preco_venda)
                    VALUES (?, ?, ?, ?)";

    $stmtEstoque = $conexao->prepare($sqlEstoque);
    $stmtPreco = $conexao->prepare($sqlPreco);
    $stmtDetalhes = $conexao->prepare($sqlDetalhes);

    // Agrupa produtos iguais e conta as quantidades
$quantidades = [];

foreach ($carrinho as $item) {

    $id = intval($item["id"]);

    if ($id <= 0) {
        throw new Exception("Produto inválido.");
    }

    if (!isset($quantidades[$id])) {
        $quantidades[$id] = 0;
    }

    $quantidades[$id]++;
}

// Registra cada produto do carrinho
foreach ($quantidades as $id => $quantidade) {

        if ($id <= 0) {
            throw new Exception("Produto inválido.");
        }

        // Consulta o preço diretamente no banco
        $stmtPreco->bind_param("i", $id);
        $stmtPreco->execute();

        $resultadoPreco = $stmtPreco->get_result();

        if ($resultadoPreco->num_rows == 0) {
            throw new Exception("Produto não encontrado.");
        }

        $produto = $resultadoPreco->fetch_assoc();
        $preco = $produto["preco"];

        // Atualiza o estoque
        $stmtEstoque->bind_param("iii", $quantidade, $id, $quantidade);
        $stmtEstoque->execute();

        if ($stmtEstoque->affected_rows == 0) {
            throw new Exception("Estoque insuficiente para um dos produtos.");
        }

        // Registra o produto no pedido
        $stmtDetalhes->bind_param(
            "iiid",
            $cod_pedido,
            $id,
            $quantidade,
            $preco
        );

        $stmtDetalhes->execute();
    }

    // Confirma a compra
    $conexao->commit();

    // Limpa o carrinho do navegador
    $mensagem = "Compra realizada com sucesso! Pedido Nº " . $cod_pedido;

} catch (Exception $erro) {

    $conexao->rollback();
    $mensagem = "Não foi possível finalizar a compra: " . $erro->getMessage();

}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Compra - NEXPLAY</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <h1>NEXPLAY</h1>

    <main>
        <h2><?php echo htmlspecialchars($mensagem); ?></h2>

        <a href="index.html">Voltar para a loja</a>
    </main>

</body>
</html>

<?php
$conexao->close();
?>
