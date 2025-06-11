
<?php
include '../banco.php'; // Inclui a conexão com o banco de dados

// Verificar se o ID foi passado pela URL
if (isset($_GET['id'])) {
    $id = (int) $_GET['id']; // Obtém o ID do produto

    // Buscar os dados do produto no banco
    $sql = "SELECT * FROM PRODUTOS WHERE ID = ?";
    $stmt = $con->prepare($sql); // Prepara a consulta
    $stmt->bind_param("i", $id); // Define o parâmetro ID
    $stmt->execute(); // Executa a consulta
    $result = $stmt->get_result(); // Obtém o resultado

    if ($result->num_rows > 0) {
        $produto = $result->fetch_assoc(); // Pega os dados do produto
    } else {
        // Se não encontrar o produto, exibe alerta e redireciona
        echo "<script>
            alert('Produto não encontrado.');
            window.location.href = 'index.php';
        </script>";
        exit;
    }
} else {
    // Se não passar o ID, exibe alerta e redireciona
    echo "<script>
        alert('ID do produto não informado.');
        window.location.href = 'index.php';
    </script>";
    exit;
}

// Atualizar os dados do produto se o formulário for enviado via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $categoria = $_POST['categoria']; // Obtém a categoria do formulário
    $produto = $_POST['produto']; // Obtém o nome do produto do formulário
    $quantidade = (int) $_POST['quantidade']; // Obtém a quantidade do formulário
    $valor_unitario = (float) $_POST['valor_unitario']; // Obtém o valor unitário do formulário
    $id = (int) $_POST['id']; // Obtém o ID do produto do formulário

    $sql = "UPDATE PRODUTOS SET CATEGORIA = ?, PRODUTO = ?, QUANTIDADE = ?, VALOR_UNITARIO = ? WHERE ID = ?";
    $stmt = $con->prepare($sql); // Prepara a consulta de atualização
    $stmt->bind_param("ssidi", $categoria, $produto, $quantidade, $valor_unitario, $id); // Define os parâmetros

    if ($stmt->execute()) {
        // Se atualizar com sucesso, exibe alerta e redireciona
        echo "<script>
            alert('Produto atualizado com sucesso!');
            window.location.href = 'index.php';
        </script>";
    } else {
        // Se der erro, exibe alerta
        echo "<script>
            alert('Erro ao atualizar o produto.');
        </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8"> <!-- Define o charset da página -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Responsividade -->
    <title>Editar Produto</title> <!-- Título da página -->
</head>
<body>
    <h1>Editar Produto</h1> <!-- Título principal -->
    <form action="editar_produto.php" method="POST"> <!-- Formulário de edição -->
        <input type="hidden" name="id" value="<?php echo $produto['ID']; ?>"> <!-- Campo oculto com o ID -->

        <label for="categoria">Categoria:</label>
        <input type="text" id="categoria" name="categoria" value="<?php echo $produto['CATEGORIA']; ?>" required> <!-- Campo de categoria -->

        <label for="produto">Produto:</label>
        <input type="text" id="produto" name="produto" value="<?php echo $produto['PRODUTO']; ?>" required> <!-- Campo de produto -->

        <label for="quantidade">Quantidade:</label>
        <input type="number" id="quantidade" name="quantidade" value="<?php echo $produto['QUANTIDADE']; ?>" required> <!-- Campo de quantidade -->

        <label for="valor_unitario">Valor Unitário:</label>
        <input type="number" step="0.01" id="valor_unitario" name="valor_unitario" value="<?php echo $produto['VALOR_UNITARIO']; ?>" required> <!-- Campo de valor unitário -->

        <button type="submit">Salvar Alterações</button> <!-- Botão de salvar -->
    </form>
</body>
</html>