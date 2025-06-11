<?php
<?php
session_start(); // Inicia a sessão para acessar dados do usuário
require_once __DIR__ . '/../banco.php'; // Inclui o arquivo de conexão com o banco de dados

if (!isset($_GET['compra_id'])) { // Verifica se o ID da compra foi informado na URL
    echo "<script>alert('Compra não encontrada.');</script>"; // Exibe alerta se não encontrar a compra
    header("Location: carrinho.php"); // Redireciona para o carrinho
    exit; // Encerra o script
}

$compraId = $_GET['compra_id']; // Obtém o ID da compra da URL

// Conexão com o banco de dados
$con = getConnection(); // Cria a conexão com o banco

// Obtém os dados da compra e do usuário
$stmt = $con->prepare("SELECT c.total, c.metodo_pagamento, c.frete, c.data_compra, u.nome AS usuario_nome 
                        FROM compras c 
                        JOIN usuarios u ON c.usuario_id = u.id 
                        WHERE c.id = ?"); // Prepara a consulta SQL
$stmt->execute([$compraId]); // Executa a consulta passando o ID da compra
$compra = $stmt->fetch(PDO::FETCH_ASSOC); // Busca os dados da compra

// Obtém os itens da compra
$stmt = $con->prepare("SELECT p.nome, ic.quantidade, ic.preco 
                        FROM itens_compra ic 
                        JOIN produtos p ON ic.produto_id = p.id 
                        WHERE ic.compra_id = ?"); // Prepara a consulta SQL para os itens
$stmt->execute([$compraId]); // Executa a consulta passando o ID da compra
$itens = $stmt->fetchAll(PDO::FETCH_ASSOC); // Busca todos os itens da compra
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8"> <!-- Define o charset da página -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Responsividade -->
    <title>Compra Concluída</title> <!-- Título da página -->
    <style>
        body {
            font-family: Arial, sans-serif; // Define a fonte da página
            background-color: #f8f3f6; // Cor de fundo
            color: #333; // Cor do texto
            text-align: center; // Centraliza o texto
            padding: 20px; // Espaçamento interno
        }
        .container {
            background: #fff; // Fundo branco
            border-radius: 10px; // Borda arredondada
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); // Sombra
            padding: 20px; // Espaçamento interno
            max-width: 600px; // Largura máxima
            margin: 0 auto; // Centraliza o container
        }
        h1 {
            color: #28a745; // Cor do título principal
        }
        .dog-image {
            width: 150px; // Largura da imagem
            margin: 20px auto; // Espaço ao redor da imagem
        }
        .summary {
            text-align: left; // Alinha o texto à esquerda
            margin-top: 20px; // Espaço acima do resumo
        }
        .summary p {
            margin: 5px 0; // Espaçamento dos parágrafos
        }
        .btn-home {
            display: inline-block; // Exibe como bloco inline
            margin-top: 20px; // Espaço acima do botão
            padding: 10px 20px; // Espaçamento interno
            background-color: #28a745; // Cor de fundo do botão
            color: white; // Cor do texto do botão
            text-decoration: none; // Remove sublinhado
            border-radius: 5px; // Borda arredondada
            transition: background-color 0.3s ease; // Transição suave de cor
        }
        .btn-home:hover {
            background-color: #218838; // Cor ao passar o mouse
        }
    </style>
</head>
<body>
    <div class="container"> <!-- Container centralizado para o conteúdo da confirmação -->
        <h1>Compra Concluída com Sucesso!</h1> <!-- Mensagem de sucesso -->
        <img src="dog_success.png" alt="Cachorrinho feliz" class="dog-image"> <!-- Imagem de cachorro feliz -->
        <p>Obrigado por sua compra, <strong><?= htmlspecialchars($compra['usuario_nome']) ?></strong>!</p> <!-- Mensagem de agradecimento com nome do usuário -->
        <div class="summary"> <!-- Resumo da compra -->
            <h3>Resumo da Compra</h3> <!-- Título do resumo -->
            <p><strong>Data:</strong> <?= date('d/m/Y H:i', strtotime($compra['data_compra'])) ?></p> <!-- Data da compra -->
            <p><strong>Método de Pagamento:</strong> <?= htmlspecialchars($compra['metodo_pagamento']) ?></p> <!-- Método de pagamento -->
            <p><strong>Frete:</strong> R$ <?= number_format($compra['frete'], 2, ',', '.') ?></p> <!-- Valor do frete -->
            <p><strong>Total:</strong> R$ <?= number_format($compra['total'], 2, ',', '.') ?></p> <!-- Valor total da compra -->
            <h4>Itens:</h4> <!-- Título da lista de itens -->
            <ul>
                <?php foreach ($itens as $item): ?> <!-- Percorre todos os itens da compra -->
                    <li><?= htmlspecialchars($item['nome']) ?> (<?= $item['quantidade'] ?>x) - R$ <?= number_format($item['preco'], 2, ',', '.') ?></li> <!-- Exibe nome, quantidade e preço do item -->
                <?php endforeach; ?>
            </ul>
        </div>
        <a href="caes_disponiveis.php" class="btn-home">Voltar para a Loja</a> <!-- Botão para voltar à loja -->
    </div>
</body>
</html>