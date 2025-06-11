<?php
// Caminho do arquivo para referência (comentário informativo)
// filepath: c:\xampp\htdocs\Canil\admin\produtos\processar_login.php

// Inicia a sessão para manipular variáveis de sessão
session_start();

// Inclui o arquivo de conexão com o banco de dados
require_once __DIR__ . '/../banco.php'; // Caminho correto para o arquivo de conexão

// Verifica se a conexão foi estabelecida corretamente
if (!$conn) {
    // Se não houver conexão, exibe mensagem de erro e encerra o script
    die("Erro: Conexão com o banco de dados não foi estabelecida.");
}

// Recebe o valor do campo 'email' enviado pelo formulário via método POST
$email = $_POST['email'];
// Recebe o valor do campo 'senha' enviado pelo formulário via método POST
$senha = $_POST['senha'];

// Monta a consulta SQL para buscar o usuário pelo email
$sql = "SELECT * FROM usuarios WHERE email = ?";
// Prepara a consulta para evitar SQL Injection
$stmt = $conn->prepare($sql);
// Associa o parâmetro $email à consulta
$stmt->bind_param("s", $email);
// Executa a consulta
$stmt->execute();
// Obtém o resultado da consulta
$result = $stmt->get_result();

// Se não encontrar nenhum usuário com o email informado
if ($result->num_rows === 0) {
    // Exibe alerta de erro e redireciona para a tela de login/cadastro
    echo "<script>alert('Email ou senha inválidos.'); window.location.href='login_cadastro.php';</script>";
    exit; // Encerra o script
}

// Obtém os dados do usuário encontrado
$usuario = $result->fetch_assoc();

// Verifica se a senha informada confere com a senha criptografada do banco
if (password_verify($senha, $usuario['senha'])) {
    // Se a senha estiver correta, armazena o ID do usuário na sessão
    $_SESSION['usuario'] = $usuario['id'];

    // Verifica se existe uma página para redirecionar após o login
    $redirect = isset($_SESSION['redirect_after_login']) ? $_SESSION['redirect_after_login'] : 'pagamento.php';
    // Remove a variável de redirecionamento da sessão
    unset($_SESSION['redirect_after_login']);
    // Redireciona o usuário para a página desejada
    header("Location: $redirect");
    exit;
} else {
    // Se a senha estiver incorreta, exibe alerta e redireciona para login/cadastro
    echo "<script>alert('Email ou senha inválidos.'); window.location.href='login_cadastro.php';</script>";
}
?>
