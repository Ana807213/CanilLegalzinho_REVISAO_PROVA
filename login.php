
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8"> <!-- Define o charset da página -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Responsividade -->
    <title>Acesse sua conta</title> <!-- Título da página -->
    <style>
        body {
            font-family: Arial, sans-serif; /* Fonte principal */
            background-color: #f8f3f6; /* Cor de fundo */
            color: #333; /* Cor do texto */
            display: flex; /* Layout flexível */
            justify-content: center; /* Centraliza horizontalmente */
            align-items: center; /* Centraliza verticalmente */
            height: 100vh; /* Altura total da tela */
            margin: 0; /* Remove margens */
        }
        .login-container {
            background: #fff; /* Fundo branco */
            padding: 20px; /* Espaçamento interno */
            border-radius: 8px; /* Borda arredondada */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Sombra */
            text-align: center; /* Centraliza texto */
            max-width: 400px; /* Largura máxima */
            width: 100%; /* Ocupa toda a largura disponível */
        }
        .login-container h1 {
            font-size: 1.5rem; /* Tamanho do título */
            color: #333; /* Cor do título */
            margin-bottom: 20px; /* Espaço abaixo do título */
        }
        .login-container button {
            display: block; /* Exibe como bloco */
            width: 100%; /* Ocupa toda a largura */
            padding: 10px; /* Espaçamento interno */
            margin: 10px 0; /* Espaço acima e abaixo */
            font-size: 1rem; /* Tamanho da fonte */
            color: white; /* Cor do texto */
            background-color: #007bff; /* Cor de fundo do botão */
            border: none; /* Sem borda */
            border-radius: 5px; /* Borda arredondada */
            cursor: pointer; /* Cursor de clique */
            transition: background-color 0.3s ease; /* Transição suave */
        }
        .login-container button:hover {
            background-color: #0056b3; /* Cor ao passar o mouse */
        }
        .login-container a {
            display: block; /* Exibe como bloco */
            margin-top: 10px; /* Espaço acima */
            color: #007bff; /* Cor do link */
            text-decoration: none; /* Remove sublinhado */
            font-size: 0.9rem; /* Tamanho da fonte */
        }
        .login-container a:hover {
            text-decoration: underline; /* Sublinha ao passar o mouse */
        }
        .create-account {
            background-color: #ff9800; /* Cor de fundo do botão de criar conta */
        }
        .create-account:hover {
            background-color: #e68900; /* Cor ao passar o mouse no botão de criar conta */
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>Acesse sua conta</h1> <!-- Título do formulário -->
        <form action="processar_login.php" method="POST"> <!-- Formulário de login -->
            <input type="email" name="email" placeholder="Email" required> <!-- Campo de email -->
            <input type="password" name="senha" placeholder="Senha" required> <!-- Campo de senha -->
            <button type="submit">Entrar</button> <!-- Botão de login -->
        </form>
        <a href="criar_conta.php" class="create-account">Crie sua conta</a> <!-- Link para criar conta -->
    </div>
</body>
</html>