<?php
<?php
session_start(); // Inicia a sessão para acessar os dados do usuário

// Verifica se o botão "Comprar" foi clicado
if (isset($_POST['comprar'])) { // Se o usuário clicou em "Comprar"
    // Redireciona para a página de login/cadastro se o usuário não estiver logado
    if (!isset($_SESSION['usuario'])) { // Se não existe usuário logado
        $_SESSION['redirect_after_login'] = 'pagamento.php'; // Salva a página de destino após o login
        header("Location: login_cadastro.php"); // Redireciona para login/cadastro
        exit; // Encerra o script
    }

    // Usuário está logado, redireciona para a página de pagamento
    header("Location: pagamento.php"); // Redireciona para pagamento
    exit; // Encerra o script
}

// Verifica se há itens no carrinho
$carrinho = isset($_SESSION['carrinho']) ? $_SESSION['carrinho'] : []; // Recupera o carrinho da sessão ou inicializa vazio

// Calcula o total de produtos no carrinho
$totalProdutos = 0; // Inicializa o total
foreach ($carrinho as $item) { // Percorre cada item do carrinho
    $totalProdutos += $item['preco'] * $item['quantidade']; // Soma o valor total de cada item
}

// Salva o total da compra na sessão
$_SESSION['total_compra'] = $totalProdutos; // Armazena o total da compra na sessão
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8"> <!-- Define o charset da página -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Responsividade -->
    <title>Seu Carrinho</title> <!-- Título da página -->
    <style>
        body {
            font-family: Arial, sans-serif; // Define a fonte da página
            background-color: #f8f3f6; // Cor de fundo
            color: #333; // Cor do texto
            padding: 20px; // Espaçamento interno
        }
        h1 {
            text-align: center; // Centraliza o título
            color: #da70d6; // Cor do título
        }
        .cart-item {
            display: flex; // Usa flexbox para os itens do carrinho
            justify-content: space-between; // Espaço entre os itens
            align-items: center; // Alinha os itens ao centro
            background: #fff; // Fundo branco
            border-radius: 8px; // Borda arredondada
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); // Sombra
            margin: 10px 0; // Espaço entre os itens
            padding: 15px; // Espaçamento interno
        }
        .cart-item img {
            width: 80px; // Largura da imagem
            height: 80px; // Altura da imagem
            object-fit: cover; // Corta a imagem para caber
            border-radius: 8px; // Borda arredondada na imagem
        }
        .cart-item h3 {
            margin: 0; // Remove margem
            font-size: 1rem; // Tamanho da fonte
            color: #da70d6; // Cor do nome do produto
        }
        .cart-item p {
            margin: 5px 0; // Espaçamento dos parágrafos
            font-size: 0.9rem; // Tamanho da fonte
            color: #555; // Cor do texto
        }
        .frete-container {
            margin-top: 20px; // Espaço acima do container de frete
            padding: 15px; // Espaçamento interno
            background: #fff; // Fundo branco
            border-radius: 8px; // Borda arredondada
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); // Sombra
        }
        .frete-container input {
            width: 200px; // Largura do campo de CEP
            padding: 10px; // Espaçamento interno
            border: 1px solid #ccc; // Borda cinza clara
            border-radius: 5px; // Borda arredondada
            font-size: 1rem; // Tamanho da fonte
        }
        .frete-container button {
            background-color: #da70d6; // Cor de fundo do botão
            color: white; // Cor do texto do botão
            border: none; // Sem borda
            padding: 10px 15px; // Espaçamento interno
            border-radius: 5px; // Borda arredondada
            cursor: pointer; // Cursor de clique
            font-size: 1rem; // Tamanho da fonte
            margin-left: 10px; // Espaço à esquerda do botão
            transition: background-color 0.3s ease; // Transição suave de cor
        }
        .frete-container button:hover {
            background-color: #c060c0; // Cor ao passar o mouse
        }
        .frete-result {
            margin-top: 10px; // Espaço acima do resultado do frete
            font-size: 1rem; // Tamanho da fonte
            color: #555; // Cor do texto
        }
        .resumo-container {
            margin-top: 20px; // Espaço acima do resumo
            padding: 15px; // Espaçamento interno
            background: #fff; // Fundo branco
            border-radius: 8px; // Borda arredondada
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); // Sombra
            max-width: 400px; // Largura máxima do resumo
            margin-left: auto; // Centraliza o resumo
            margin-right: auto; // Centraliza o resumo
        }
        .resumo-container h3 {
            margin: 0 0 10px; // Espaçamento do título do resumo
            font-size: 1.2rem; // Tamanho da fonte
            color: #333; // Cor do texto
        }
        .resumo-container p {
            margin: 5px 0; // Espaçamento dos parágrafos
            font-size: 1rem; // Tamanho da fonte
            color: #555; // Cor do texto
        }
        .resumo-container .total {
            font-weight: bold; // Negrito para o total
            font-size: 1.2rem; // Tamanho maior para o total
            color: #333; // Cor do texto
        }
        .resumo-container button {
            background-color: #28a745; // Cor de fundo do botão de comprar
            color: white; // Cor do texto
            border: none; // Sem borda
            padding: 10px 15px; // Espaçamento interno
            border-radius: 5px; // Borda arredondada
            cursor: pointer; // Cursor de clique
            font-size: 1rem; // Tamanho da fonte
            margin-top: 10px; // Espaço acima do botão
            width: 100%; // Botão ocupa toda a largura
            transition: background-color 0.3s ease; // Transição suave de cor
        }
        .resumo-container button:hover {
            background-color: #218838; // Cor ao passar o mouse
        }
        .resumo-container a {
            display: block; // Exibe como bloco
            text-align: center; // Centraliza o link
            margin-top: 10px; // Espaço acima do link
            color: #555; // Cor do link
            text-decoration: none; // Remove sublinhado
            font-size: 0.9rem; // Tamanho da fonte
        }
        .resumo-container a:hover {
            text-decoration: underline; // Sublinha ao passar o mouse
        }
    </style>
</head>
<body>
    <h1>Seu Carrinho</h1> <!-- Título principal da página -->
    <?php if (count($carrinho) > 0): ?> <!-- Verifica se há itens no carrinho -->
        <!-- Produtos no carrinho -->
        <?php foreach ($carrinho as $item): ?> <!-- Percorre cada item do carrinho -->
            <div class="cart-item">
                <img src="<?= htmlspecialchars($item['imagem']) ?>" alt="<?= htmlspecialchars($item['nome']) ?>"> <!-- Imagem do produto -->
                <div>
                    <h3><?= htmlspecialchars($item['nome']) ?></h3> <!-- Nome do produto -->
                    <p>Preço unitário: R$ <?= number_format($item['preco'], 2, ',', '.') ?></p> <!-- Preço unitário -->
                    <p>Total: R$ <?= number_format($item['preco'] * $item['quantidade'], 2, ',', '.') ?></p> <!-- Total do item -->
                </div>
            </div>
        <?php endforeach; ?>

        <!-- Frete e prazo -->
        <div class="frete-container">
            <h3>Frete e prazo</h3> <!-- Título da seção de frete -->
            <input type="text" id="cep" placeholder="Insira o CEP" maxlength="8"> <!-- Campo para digitar o CEP -->
            <button onclick="calcularFrete()">Buscar</button> <!-- Botão para calcular o frete -->
            <div id="frete-result" class="frete-result"></div> <!-- Resultado do frete -->
            <div id="endereco-container" style="display: none; margin-top: 10px;">
                <p><strong>Endereço:</strong> <span id="endereco"></span></p> <!-- Exibe o endereço encontrado -->
                <input type="text" id="numero" placeholder="Número da residência"> <!-- Campo para número da residência -->
            </div>
        </div>

        <!-- Resumo do pedido -->
        <div class="resumo-container">
            <h3>Resumo do pedido</h3> <!-- Título do resumo -->
            <p>Produtos (<?= count($carrinho) ?>): R$ <?= number_format($totalProdutos, 2, ',', '.') ?></p> <!-- Total de produtos -->
            <p>Frete: <span id="frete-valor">R$ 0,00</span></p> <!-- Valor do frete -->
            <p class="total">Total: <span id="total-valor">R$ <?= number_format($totalProdutos, 2, ',', '.') ?></span></p> <!-- Total geral -->
            <form method="POST" action="carrinho.php">
                <button type="submit" name="comprar">Comprar</button> <!-- Botão para finalizar compra -->
            </form>
            <a href="caes_disponiveis.php">Comprar mais produtos</a> <!-- Link para voltar à loja -->
        </div>
    <?php else: ?>
        <p>Seu carrinho está vazio.</p> <!-- Mensagem se o carrinho estiver vazio -->
    <?php endif; ?>

    <script>
        let frete = 0; // Variável para armazenar o valor do frete

        function calcularFrete() { // Função para calcular o frete
            const cep = document.getElementById('cep').value; // Obtém o valor do CEP digitado

            if (!cep || cep.length !== 8 || isNaN(cep)) { // Valida o CEP
                alert('Por favor, insira um CEP válido com 8 dígitos.'); // Alerta se o CEP for inválido
                return; // Encerra a função
            }

            // Busca o endereço usando a API ViaCEP
            fetch(`https://viacep.com.br/ws/${cep}/json/`)
                .then(response => response.json()) // Converte a resposta para JSON
                .then(data => { // Manipula os dados recebidos
                    if (data.erro) { // Se o CEP não for encontrado
                        alert('CEP não encontrado. Verifique e tente novamente.'); // Alerta o usuário
                        return; // Encerra a função
                    }

                    // Exibe o endereço
                    const enderecoContainer = document.getElementById('endereco-container'); // Seleciona o container do endereço
                    const enderecoSpan = document.getElementById('endereco'); // Seleciona o span do endereço
                    enderecoSpan.textContent = `${data.logradouro}, ${data.bairro}, ${data.localidade} - ${data.uf}`; // Mostra o endereço completo
                    enderecoContainer.style.display = 'block'; // Exibe o container do endereço
                })
                .catch(error => { // Se ocorrer erro na requisição
                    console.error('Erro ao buscar o endereço:', error); // Mostra o erro no console
                    alert('Erro ao buscar o endereço. Tente novamente mais tarde.'); // Alerta o usuário
                });

            // Calcula o frete
            fetch('calcular_frete.php', { // Faz requisição para o backend calcular o frete
                method: 'POST', // Usa o método POST
                headers: { 'Content-Type': 'application/json' }, // Define o tipo de conteúdo como JSON
                body: JSON.stringify({ cep }) // Envia o CEP digitado pelo usuário
            })
            .then(response => response.json()) // Converte a resposta para JSON
            .then(data => { // Manipula os dados recebidos
                const resultDiv = document.getElementById('frete-result'); // Seleciona o elemento para mostrar o resultado do frete
                if (data.success) { // Se o cálculo do frete foi bem-sucedido
                    frete = data.frete; // Atualiza o valor do frete
                    resultDiv.textContent = `Frete: R$ ${data.frete.toFixed(2)} - Prazo: ${data.prazo} dias`; // Mostra o valor e prazo do frete
                    document.getElementById('frete-valor').textContent = `R$ ${data.frete.toFixed(2)}`; // Atualiza o campo de frete no resumo
                    const total = <?= $totalProdutos ?> + frete; // Soma o total dos produtos com o frete
                    document.getElementById('total-valor').textContent = `R$ ${total.toFixed(2).replace('.', ',')}`; // Atualiza o total geral na tela
                } else { // Se houve erro no cálculo do frete
                    resultDiv.textContent = 'Erro ao calcular o frete. Tente novamente.'; // Mostra mensagem de erro
                }
            })
            .catch(error => { // Se ocorrer erro na requisição
                console.error('Erro ao calcular o frete:', error); // Mostra o erro no console
            });
        }
    </script>
</body>
</html>