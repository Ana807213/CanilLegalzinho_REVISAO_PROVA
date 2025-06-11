<?php
<?php
include '../banco.php'; // Inclui o arquivo de conexão com o banco de dados

if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Verifica se o formulário foi enviado via POST
    $id = isset($_POST['id']) ? (int) $_POST['id'] : null; // Obtém o ID do produto (se existir)
    $categoria = $_POST['categoria']; // Obtém a categoria do formulário
    $produto = $_POST['produto']; // Obtém o nome do produto do formulário
    $quantidade = (int) $_POST['quantidade']; // Obtém a quantidade do formulário
    $valor_unitario = (float) $_POST['valor_unitario']; // Obtém o valor unitário do formulário
    $valor_total = $quantidade * $valor_unitario; // Calcula o valor total

    // Verifica se é edição ou cadastro
    if ($id) {
        // Atualiza produto existente
        $sql = "UPDATE PRODUTOS SET CATEGORIA = ?, PRODUTO = ?, QUANTIDADE = ?, VALOR_UNITARIO = ?, VALOR_TOTAL = ? WHERE ID = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ssiddi", $categoria, $produto, $quantidade, $valor_unitario, $valor_total, $id);

        if ($stmt->execute()) {
            echo "<script>alert('Produto atualizado com sucesso!');</script>";
        } else {
            echo "<script>alert('Erro ao atualizar o produto.');</script>";
        }
    } else {
        // Cadastra novo produto
        $fotoDestino = null;
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) { // Verifica se uma foto foi enviada
            $fotoTmp = $_FILES['foto']['tmp_name']; // Caminho temporário da foto
            $fotoNome = basename($_FILES['foto']['name']); // Nome do arquivo
            $fotoDestino = "uploads/" . $fotoNome; // Caminho de destino

            if (!is_dir("uploads")) { // Cria a pasta uploads se não existir
                mkdir("uploads", 0777, true);
            }

            move_uploaded_file($fotoTmp, $fotoDestino); // Move o arquivo para o destino
        }

        $sql = "INSERT INTO PRODUTOS (CATEGORIA, PRODUTO, QUANTIDADE, VALOR_UNITARIO, VALOR_TOTAL, FOTO) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ssidds", $categoria, $produto, $quantidade, $valor_unitario, $valor_total, $fotoDestino);

        if ($stmt->execute()) {
            echo "<script>alert('Produto cadastrado com sucesso!');</script>";
        } else {
            echo "<script>alert('Erro ao cadastrar o produto.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8"> <!-- Define o charset da página -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Responsividade -->
    <title>Tabela de Categorias</title> <!-- Título da página -->
    <style>
    body {
        font-family: Arial, sans-serif; /* Fonte principal */
        background-color: pink; /* Cor de fundo */
        color: #333; /* Cor do texto */
    }
    table {
        width: 80%; /* Reduz a largura da tabela */
        margin: 20px auto; /* Centraliza a tabela horizontalmente */
        border-collapse: collapse; /* Remove espaçamento entre células */
    }
    th, td {
        border: 1px solid #ddd; /* Borda das células */
        padding: 8px; /* Espaçamento interno */
        text-align: center; /* Centraliza o texto */
    }
    th {
        background-color: #f4f4f4; /* Cor de fundo do cabeçalho */
    }
    tr:nth-child(even) {
        background-color: #f9f9f9; /* Cor de fundo das linhas pares */
    }
    tr:hover {
        background-color: #f1f1f1; /* Cor ao passar o mouse */
    }
    tfoot td {
        text-align: center; /* Centraliza o texto do rodapé */
    }
    table img {
        width: 50px; /* Largura da imagem */
        height: 50px; /* Altura da imagem */
        object-fit: cover; /* Ajusta a imagem ao tamanho */
    }

    /* Estilo do formulário */
    #form-container {
        width: 80%; /* Largura do formulário */
        margin: 20px auto; /* Centraliza o formulário */
        padding: 20px; /* Espaçamento interno */
        background-color: #fff; /* Fundo branco */
        border-radius: 8px; /* Bordas arredondadas */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Sombra */
    }

    #form-container form {
        display: grid; /* Layout em grid */
        grid-template-columns: 1fr 2fr; /* Duas colunas */
        gap: 10px; /* Espaçamento entre elementos */
        align-items: center; /* Alinha verticalmente */
    }

    #form-container label {
        text-align: right; /* Alinha o texto das labels à direita */
        margin-right: 10px;
    }

    #form-container input[type="text"],
    #form-container input[type="number"],
    #form-container input[type="file"] {
        width: 100%; /* Campos ocupam toda a largura */
        padding: 5px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }

    #form-container button {
        grid-column: span 2; /* Botão ocupa as duas colunas */
        padding: 10px;
        background-color: rgb(186, 12, 131); /* Cor do botão */
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
    }

    #form-container button:hover {
        background-color:rgba(160, 69, 130, 0.37); /* Cor ao passar o mouse */
    }
    </style>
</head>
<body>
    <h1>Cadastro de Categorias</h1> <!-- Título principal -->

    <!-- Formulário para cadastro/edição de produtos -->
    <div id="form-container" class="form-container">
        <form action="" method="POST" enctype="multipart/form-data">
            <input type="hidden" id="id" name="id"> <!-- Campo oculto para ID do produto (edição) -->

            <label for="foto">Foto:</label>
            <input type="file" id="foto" name="foto" accept="image/*"> <!-- Campo para upload de foto -->

            <label for="categoria">Categoria:</label>
            <input type="text" id="categoria" name="categoria" required> <!-- Campo de categoria -->

            <label for="produto">Produto:</label>
            <input type="text" id="produto" name="produto" required> <!-- Campo de produto -->

            <label for="quantidade">Quantidade:</label>
            <input type="number" id="quantidade" name="quantidade" required> <!-- Campo de quantidade -->

            <label for="valor_unitario">Valor Unitário:</label>
            <input type="number" step="0.01" id="valor_unitario" name="valor_unitario" required> <!-- Campo de valor unitário -->

            <button type="submit" id="submit-button">➕ Cadastrar Produto</button> <!-- Botão de cadastro/edição -->
        </form>
    </div>

    <!-- Tabela de Produtos -->
    <table>
        <thead> 
            <tr>
                <th>📷 Foto</th>
                <th>🏷️ Categoria</th>
                <th>📦 Produto</th>
                <th>🔢 Quantidade</th>
                <th>💲 Valor Unitário</th>
                <th>💰 Valor Total</th>
                <th>✏️ Editar</th>
            </tr>
        </thead>
        <tbody>
<?php
include '../banco.php'; // Inclui novamente a conexão com o banco de dados

$sql = "SELECT * FROM PRODUTOS"; // Seleciona todos os produtos
$result = $con->query($sql); // Executa a consulta

if ($result->num_rows > 0) { // Se houver produtos cadastrados
    while ($row = $result->fetch_assoc()) { // Percorre cada produto
        echo "<tr>
            <td><img src='../{$row['FOTO']}' alt='Foto do Produto' width='100' height='100'></td>
            <td>{$row['CATEGORIA']}</td>
            <td>{$row['PRODUTO']}</td>
            <td>{$row['QUANTIDADE']}</td>
            <td>R$ " . number_format($row['VALOR_UNITARIO'], 2, ',', '.') . "</td>
            <td>R$ " . number_format($row['VALOR_TOTAL'], 2, ',', '.') . "</td>
            <td>
                <button type='button' class='btn-editar' 
                    onclick=\"editarProduto(
                        {$row['ID']}, 
                        '" . addslashes($row['CATEGORIA']) . "', 
                        '" . addslashes($row['PRODUTO']) . "', 
                        {$row['QUANTIDADE']}, 
                        {$row['VALOR_UNITARIO']}
                    )\">
                    ✏️ Editar
                </button>
            </td>
        </tr>";
    }
} else { // Se não houver produtos
    echo "<tr><td colspan='7'>Nenhum produto cadastrado.</td></tr>";
}
$con->close(); // Fecha a conexão com o banco
?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="7"><a href="../index.php">Voltar para o Menu Principal</a></td> <!-- Link para voltar ao menu -->
            </tr>
        </tfoot>
    </table>

    <script>
    // Função para preencher o formulário com os dados do produto ao clicar em editar
    function editarProduto(id, categoria, produto, quantidade, valorUnitario) {
        document.getElementById('id').value = id;
        document.getElementById('categoria').value = categoria;
        document.getElementById('produto').value = produto;
        document.getElementById('quantidade').value = quantidade;
        document.getElementById('valor_unitario').value = valorUnitario;
        document.getElementById('submit-button').textContent = '✏️ Atualizar Produto';
    }
    </script>
</body>
</html>