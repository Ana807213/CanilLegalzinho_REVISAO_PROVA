<?php

// Arquivo PHP vazio para possíveis configurações futuras
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8"> <!-- Define o charset da página -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Responsividade -->
    <title>Login ou Cadastro</title> <!-- Título da página -->
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
        .container {
            background: #fff; /* Fundo branco */
            padding: 20px; /* Espaçamento interno */
            border-radius: 8px; /* Borda arredondada */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Sombra */
            text-align: center; /* Centraliza texto */
            max-width: 400px; /* Largura máxima */
            width: 100%; /* Ocupa toda a largura disponível */
        }
        .container h1 {
            font-size: 1.5rem; /* Tamanho do título */
            color: #333; /* Cor do título */
            margin-bottom: 20px; /* Espaço abaixo do título */
        }
        .container form {
            margin-bottom: 20px; /* Espaço abaixo do formulário */
        }
        .container input {
            width: 100%; /* Ocupa toda a largura */
            padding: 10px; /* Espaçamento interno */
            margin: 10px 0; /* Espaço acima e abaixo */
            border: 1px solid #ccc; /* Borda cinza clara */
            border-radius: 5px; /* Borda arredondada */
        }
        .container button {
            width: 100%; /* Ocupa toda a largura */
            padding: 10px; /* Espaçamento interno */
            background-color: #28a745; /* Cor de fundo do botão */
            color: white; /* Cor do texto */
            border: none; /* Sem borda */
            border-radius: 5px; /* Borda arredondada */
            cursor: pointer; /* Cursor de clique */
            font-size: 1rem; /* Tamanho da fonte */
        }
        .container button:hover {
            background-color: #218838; /* Cor ao passar o mouse */
        }
        .container a {
            display: block; /* Exibe como bloco */
            margin-top: 10px; /* Espaço acima */
            color: #007bff; /* Cor do link */
            text-decoration: none; /* Remove sublinhado */
        }
        .container a:hover {
            text-decoration: underline; /* Sublinha ao passar o mouse */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Login</h1> <!-- Título da seção de login -->
        <form action="processar_login.php" method="POST"> <!-- Formulário de login -->
            <input type="email" name="email" placeholder="Email" required> <!-- Campo de email -->
            <input type="password" name="senha" placeholder="Senha" required> <!-- Campo de senha -->
            <button type="submit">Entrar</button> <!-- Botão de login -->
        </form>
        <h1>Cadastro</h1> <!-- Título da seção de cadastro -->
        <form action="processar_cadastro.php" method="POST"> <!-- Formulário de cadastro -->
            <input type="text" name="nome" placeholder="Nome completo" required> <!-- Campo de nome -->
            <input type="email" name="email" placeholder="Email" required> <!-- Campo de email -->
            <input type="password" name="senha" placeholder="Senha" required> <!-- Campo de senha -->
            <button type="submit">Cadastrar</button> <!-- Botão de cadastro -->
        </form>
    </div>
</body>
</html>