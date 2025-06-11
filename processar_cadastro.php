<?php
// Caminho do arquivo para referência (comentário informativo)
// filepath: c:\xampp\htdocs\Canil\admin\produtos\processar_cadastro.php

// Inclui o arquivo de conexão com o banco de dados
require_once __DIR__ . '/../banco.php'; // Caminho correto para o arquivo de conexão

// Recebe o valor do campo 'nome' enviado pelo formulário via método POST
$nome = $_POST['nome'];
// Recebe o valor do campo 'email' enviado pelo formulário via método POST
$email = $_POST['email'];
// Recebe o valor do campo 'senha' enviado pelo formulário via método POST
$senha = $_POST['senha'];

// Verifica se o email já está cadastrado no banco de dados
$sql = "SELECT * FROM usuarios WHERE email = ?"; // Monta a consulta SQL com parâmetro
$stmt = $con->prepare($sql); // Prepara a consulta para evitar SQL Injection
$stmt->bind_param("s", $email); // Associa o parâmetro $email à consulta
$stmt->execute(); // Executa a consulta
$result = $stmt->get_result(); // Obtém o resultado da consulta

// Se o número de linhas retornadas for maior que 0, o email já existe
if ($result->num_rows > 0) {
    // Exibe um alerta informando que o email já está cadastrado e redireciona para a tela de cadastro/login
    echo "<script>alert('Este email já está cadastrado. Tente outro.'); window.location.href='login_cadastro.php';</script>";
    exit; // Encerra o script para não continuar o cadastro
}

// Criptografa a senha informada pelo usuário usando o algoritmo padrão do PHP
$senhaHash = password_hash($senha, PASSWORD_DEFAULT); // Criptografa a senha

// Monta a consulta SQL para inserir o novo usuário no banco de dados
$sql = "INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)";
$stmt = $con->prepare($sql); // Prepara a consulta de inserção
$stmt->bind_param("sss", $nome, $email, $senhaHash); // Associa os parâmetros nome, email e senha criptografada

// Executa a consulta de inserção
if ($stmt->execute()) {
    // Se a inserção for bem-sucedida, exibe mensagem de sucesso e redireciona para a tela de login/cadastro
    echo "<script>alert('Usuário cadastrado com sucesso!'); window.location.href='login_cadastro.php';</script>";
} else {
    // Se ocorrer algum erro, exibe mensagem de erro e redireciona para a tela de login/cadastro
    echo "<script>alert('Erro ao cadastrar usuário.'); window.location.href='login_cadastro.php';</script>";
}
?>