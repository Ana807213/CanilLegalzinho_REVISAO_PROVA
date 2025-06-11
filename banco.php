<?php
// Define o endereço do servidor do banco de dados (localhost = máquina local)
$host = "localhost";
// Define o nome de usuário para acessar o banco de dados
$usuario = "root";
// Define a senha do usuário do banco de dados
$senha = "An@342035";
// Define o nome do banco de dados a ser utilizado
$banco = "CANIL";
// Define a porta de conexão com o banco de dados (3307 é comum em instalações alternativas do MySQL)
$porta = 3307;

// Cria uma nova conexão com o banco de dados usando os parâmetros definidos acima
$con = new mysqli($host, $usuario, $senha, $banco, $porta);

// Verifica se ocorreu algum erro ao tentar conectar
if ($con->connect_error) {
    // Se houver erro, exibe a mensagem e encerra o script
    die("Erro na conexão: " . $con->connect_error);
}
?>