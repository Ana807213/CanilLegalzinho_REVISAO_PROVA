<?php
// Inicia a sessão para acessar variáveis de sessão
session_start();

// Verifica se o total da compra está definido na sessão
if (!isset($_SESSION['total_compra'])) {
    // Exibe um alerta em JavaScript caso o total não esteja definido
    echo "<script>alert('Erro: Total da compra não definido. Retornando ao carrinho.');</script>";
    // Redireciona o usuário para a página do carrinho
    header("Location: carrinho.php");
    // Encerra a execução do script
    exit;
}

// Obtém o valor total da compra da variável de sessão
$totalCompra = $_SESSION['total_compra'];
?>

<!DOCTYPE html>
<!-- Define o tipo do documento como HTML5 -->
<html lang="pt-BR">
<!-- Define o idioma da página como português do Brasil -->
<head>
    <!-- Define o conjunto de caracteres como UTF-8 -->
    <meta charset="UTF-8">
    <!-- Define a viewport para responsividade em dispositivos móveis -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Define o título da página exibido na aba do navegador -->
    <title>Meios de Pagamento</title>
    <!-- Importa a biblioteca de ícones Font Awesome via CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Define a fonte padrão, cor de fundo e centraliza o conteúdo na tela */
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f3f6;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        /* Estiliza o container principal do formulário */
        .container {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 500px;
            width: 100%;
        }
        /* Estiliza o título */
        h1 {
            text-align: center;
            color: #da70d6;
            margin-bottom: 20px;
        }
        /* Espaçamento entre métodos de pagamento */
        .payment-method {
            margin-bottom: 15px;
        }
        /* Estiliza o label dos métodos de pagamento */
        .payment-method label {
            display: flex;
            align-items: center;
            cursor: pointer;
            background: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
            transition: background-color 0.3s ease;
        }
        /* Efeito ao passar o mouse sobre o método de pagamento */
        .payment-method label:hover {
            background-color: #f0f0f0;
        }
        /* Estiliza os ícones dos métodos de pagamento */
        .payment-method i {
            font-size: 24px;
            margin-right: 10px;
            color: #555;
        }
        /* Estiliza o resumo da compra */
        .summary {
            margin-top: 20px;
            font-size: 16px;
            background: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
        }
        /* Espaçamento entre os parágrafos do resumo */
        .summary p {
            margin: 5px 0;
        }
        /* Destaque para o valor total */
        .summary strong {
            font-size: 18px;
            color: #333;
        }
        /* Estiliza o botão de envio */
        .btn-submit {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
            margin-top: 20px;
            transition: background-color 0.3s ease;
        }
        /* Efeito ao passar o mouse sobre o botão */
        .btn-submit:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <!-- Container principal do conteúdo -->
    <div class="container">
        <!-- Título da página -->
        <h1>Meios de Pagamento</h1>
        <!-- Formulário para envio dos dados de pagamento -->
        <form method="POST" action="processar_compra.php">
            <!-- Opção de pagamento: Cartão de Crédito -->
            <div class="payment-method">
                <label>
                    <!-- Input do tipo radio para selecionar o método Cartão de Crédito (obrigatório) -->
                    <input type="radio" name="metodo_pagamento" value="Cartão de Crédito" required>
                    <!-- Ícone de cartão de crédito -->
                    <i class="fas fa-credit-card"></i> Cartão de Crédito
                </label>
            </div>
            <!-- Opção de pagamento: Nubank -->
            <div class="payment-method">
                <label>
                    <!-- Input do tipo radio para selecionar o método Nubank -->
                    <input type="radio" name="metodo_pagamento" value="Nubank">
                    <!-- Ícone de banco/universidade -->
                    <i class="fas fa-university"></i> Nubank
                </label>
            </div>
            <!-- Opção de pagamento: Pix -->
            <div class="payment-method">
                <label>
                    <!-- Input do tipo radio para selecionar o método Pix -->
                    <input type="radio" name="metodo_pagamento" value="Pix">
                    <!-- Ícone de QR Code -->
                    <i class="fas fa-qrcode"></i> Pix
                </label>
            </div>
            <!-- Opção de pagamento: Pix Parcelado -->
            <div class="payment-method">
                <label>
                    <!-- Input do tipo radio para selecionar o método Pix Parcelado -->
                    <input type="radio" name="metodo_pagamento" value="Pix Parcelado">
                    <!-- Ícone de QR Code -->
                    <i class="fas fa-qrcode"></i> Pix Parcelado
                </label>
            </div>
            <!-- Resumo da compra -->
            <div class="summary">
                <!-- Exibe a quantidade de produtos no carrinho e o valor total dos produtos -->
                <p>Produtos (<?= count($_SESSION['carrinho']) ?>): R$ <?= number_format($totalCompra, 2, ',', '.') ?></p>
                <!-- Exibe o valor fixo do frete -->
                <p>Frete: R$ 7,90</p>
                <!-- Exibe o valor total da compra (produtos + frete) -->
                <p><strong>Total: R$ <?= number_format($totalCompra + 7.90, 2, ',', '.') ?></strong></p>
            </div>
            <!-- Campo oculto para enviar o valor total da compra no formulário -->
            <input type="hidden" name="total_compra" value="<?= $totalCompra ?>">
            <!-- Botão para enviar o formulário e concluir o pagamento -->
            <button type="submit" name="comprar" class="btn-submit">Concluir Pagamento</button>
        </form>
    </div>
</body>
</html>


<?php
/* O !isset em PHP é usado para verificar se uma variável não está definida ou é nula.
isset($variavel) retorna true se a variável existe e não é null.
!isset($variavel) retorna true se a variável não existe ou é null.
No seu código:
Isso significa:
Se a variável de sessão total_compra não estiver definida, execute o bloco de código dentro do if
Dessa forma, você impede que o usuário acesse a página de pagamento sem ter um valor de compra definido, evitando possíveis erros ou manipulações indevidas no fluxo de compra.
