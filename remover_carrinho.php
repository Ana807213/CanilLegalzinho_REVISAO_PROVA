<?php
// Inicia a sessão para acessar e manipular o carrinho do usuário
session_start();

// Recebe o corpo da requisição (espera um JSON via POST)
$data = json_decode(file_get_contents('php://input'), true);
// Obtém o ID do item a ser removido do carrinho, se existir
$id = $data['id'] ?? null;

// Verifica se o ID foi enviado e se o carrinho existe na sessão
if ($id !== null && isset($_SESSION['carrinho'])) {
    // Filtra os itens do carrinho, removendo o item com o ID correspondente
    $_SESSION['carrinho'] = array_filter($_SESSION['carrinho'], function ($item) use ($id) {
        // Retorna apenas os itens cujo ID é diferente do ID recebido
        return $item['id'] != $id;
    });
}

// Inicializa o total de itens restantes no carrinho
$totalItens = 0;
// Percorre todos os itens do carrinho para somar as quantidades
foreach ($_SESSION['carrinho'] as $item) {
    $totalItens += $item['quantidade'];
}
// Retorna o total de itens restantes no carrinho em formato JSON
echo json_encode(['total' => $totalItens]);