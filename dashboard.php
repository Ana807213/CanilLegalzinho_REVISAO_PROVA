<?php
// Inclui o arquivo de conexão com o banco de dados
include 'C:\xampp\htdocs\Canil\admin\banco.php'; // Inclua sua conexão com o banco de dados

// Verifica se o formulário foi enviado via método POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recebe o valor do campo 'categoria' enviado pelo formulário
    $categoria = $_POST['categoria'];
    // Recebe o valor do campo 'produto' enviado pelo formulário
    $produto = $_POST['produto'];
    // Recebe e converte o valor do campo 'quantidade' para inteiro
    $quantidade = (int) $_POST['quantidade'];
    // Recebe e converte o valor do campo 'valor_unitario' para float
    $valor_unitario = (float) $_POST['valor_unitario'];
    // Calcula o valor total multiplicando quantidade pelo valor unitário
    $valor_total = $quantidade * $valor_unitario;

    // Verifica se o arquivo de foto foi enviado e não houve erro no upload
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        // Caminho temporário do arquivo enviado
        $fotoTmp = $_FILES['foto']['tmp_name'];
        // Nome original do arquivo enviado
        $fotoNome = basename($_FILES['foto']['name']);
        // Caminho de destino para salvar o arquivo na pasta uploads
        $fotoDestino = "uploads/" . $fotoNome;

        // Cria o diretório de uploads, se não existir
        if (!is_dir("uploads")) {
            mkdir("uploads", 0777, true);
        }

        // Move o arquivo do local temporário para o destino final
        if (move_uploaded_file($fotoTmp, $fotoDestino)) {
            // Monta a query SQL para inserir o produto no banco de dados
            $sql = "INSERT INTO PRODUTOS (CATEGORIA, PRODUTO, QUANTIDADE, VALOR_UNITARIO, VALOR_TOTAL, FOTO) VALUES (?, ?, ?, ?, ?, ?)";
            // Prepara a query para evitar SQL Injection
            $stmt = $con->prepare($sql);

            if ($stmt) {
                // Associa os parâmetros à query preparada
                $stmt->bind_param("ssidds", $categoria, $produto, $quantidade, $valor_unitario, $valor_total, $fotoDestino);

                // Executa a query de inserção
                if ($stmt->execute()) {
                    // Se der certo, exibe mensagem de sucesso e redireciona
                    echo "<script>
                        alert('Produto cadastrado com sucesso!');
                        window.location.href = 'categorias/index.php';
                    </script>";
                } else {
                    // Se der erro na execução, exibe mensagem de erro
                    echo "<script>
                        alert('Erro ao cadastrar produto: " . $stmt->error . "');
                        window.location.href = 'categorias/index.php';
                    </script>";
                }

                // Fecha o statement para liberar recursos
                $stmt->close();
            } else {
                // Se der erro ao preparar a query, exibe mensagem de erro
                echo "<script>
                    alert('Erro na preparação da consulta: " . $con->error . "');
                    window.location.href = 'categorias/index.php';
                </script>";
            }
        } else {
            // Se der erro ao mover o arquivo, exibe mensagem de erro
            echo "<script>
                alert('Erro ao fazer upload da foto.');
                window.location.href = 'categorias/index.php';
            </script>";
        }
    } else {
        // Se nenhum arquivo foi enviado ou ocorreu erro, exibe mensagem de erro
        echo "<script>
            alert('Nenhuma foto foi enviada ou ocorreu um erro.');
            window.location.href = 'categorias/index.php';
        </script>";
    }

    // Fecha a conexão com o banco de dados
    $con->close();
}
?>