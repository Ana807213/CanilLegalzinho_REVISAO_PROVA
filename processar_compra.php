<?php
// Inicia a sessão para acessar variáveis de sessão
session_start();

// Inclui o arquivo de conexão com o banco de dados
require_once __DIR__ . '/../banco.php'; // Inclua o arquivo de conexão com o banco de dados

// Verifica se o método da requisição é POST (formulário enviado)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica se os dados necessários estão disponíveis na sessão e no POST
    if (!isset($_SESSION['carrinho'], $_SESSION['total_compra'], $_POST['metodo_pagamento'])) {
        // Exibe um alerta de erro e redireciona para o carrinho
        echo "<script>alert('Erro ao processar a compra. Retorne ao carrinho.');</script>";
        header("Location: carrinho.php");
        exit;
    }

    // Recupera o carrinho da sessão
    $carrinho = $_SESSION['carrinho'];
    // Recupera o valor total da compra da sessão
    $totalCompra = $_SESSION['total_compra'];
    // Recupera o método de pagamento enviado pelo formulário
    $metodoPagamento = $_POST['metodo_pagamento'];
    // Define o valor fixo do frete
    $frete = 7.90; // Valor fixo do frete (pode ser dinâmico)

    // Obtém a conexão com o banco de dados usando função personalizada
    $con = getConnection(); // Função que retorna a conexão com o banco

    try {
        // Inicia uma transação no banco de dados
        $conn->beginTransaction();

        // Insere os dados da compra na tabela "compras"
        $stmt = $con->prepare("INSERT INTO compras (usuario_id, total, metodo_pagamento, frete, data_compra) VALUES (?, ?, ?, ?, NOW())");
        $stmt->execute([$_SESSION['usuario']['id'], $totalCompra + $frete, $metodoPagamento, $frete]);

        // Obtém o ID da compra recém-criada para relacionar com os itens
        $compraId = $con->lastInsertId();

        // Prepara a inserção dos itens do carrinho na tabela "itens_compra"
        $stmt = $con->prepare("INSERT INTO itens_compra (compra_id, produto_id, quantidade, preco) VALUES (?, ?, ?, ?)");
        // Para cada item do carrinho, insere um registro na tabela de itens da compra
        foreach ($carrinho as $item) {
            $stmt->execute([$compraId, $item['id'], $item['quantidade'], $item['preco']]);
        }

        // Confirma a transação, salvando todas as alterações no banco
        $con->commit();

        // Limpa o carrinho e o total da sessão após a compra ser finalizada
        unset($_SESSION['carrinho'], $_SESSION['total_compra']);

        // Redireciona para a página de confirmação, passando o ID da compra
        header("Location: confirmacao.php?compra_id=$compraId");
        exit;
    } catch (Exception $e) {
        // Em caso de erro, desfaz todas as alterações feitas na transação
        $con->rollBack();
        // Exibe mensagem de erro
        echo "Erro ao processar a compra: " . $e->getMessage();
    }
}
?>

<?php
/*O require_once da linha 6 serve para incluir o arquivo banco.php apenas uma vez no seu script.
require_once garante que, mesmo que você tente incluir o mesmo arquivo várias vezes, ele só será incluído uma vez, evitando erros de redefinição de funções ou classes.
O caminho __DIR__ . '/../banco.php' indica que o arquivo banco.php está em uma pasta acima da pasta atual do arquivo.