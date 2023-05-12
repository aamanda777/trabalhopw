<?php
session_start();

// verifica se o usuário está logado
if (!isset($_SESSION['usuario_logado'])) {
    $_SESSION['mensagem'] = 'Você precisa estar logado para acessar esta página.';
    header('Location: login.php');
    exit;
}

// verifica se o formulário de exclusão foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['documento_id'])) {
    $documentoId = $_POST['documento_id'];

    // conecta ao banco de dados
    $conn = new mysqli('localhost', 'root', '', 'trabalho');
    if ($conn->connect_error) {
        die('Erro na conexão com o banco de dados: ' . $conn->connect_error);
    }

    // exclui os registros da tabela 'permissoes' associados ao documento
    $sqlPermissoes = "DELETE FROM permissoes WHERE id_documento = ?";
    $stmtPermissoes = $conn->prepare($sqlPermissoes);
    $stmtPermissoes->bind_param("i", $documentoId);
    $stmtPermissoes->execute();
    $stmtPermissoes->close();

    // exclui o documento do banco de dados
    $sqlDocumento = "DELETE FROM documentos WHERE id = ?";
    $stmtDocumento = $conn->prepare($sqlDocumento);
    $stmtDocumento->bind_param("i", $documentoId);
    if ($stmtDocumento->execute()) {
        $_SESSION['mensagem'] = 'Documento excluído com sucesso.';
    } else {
        $_SESSION['mensagem'] = 'Ocorreu um erro ao excluir o documento.';
    }

    $stmtDocumento->close();
    $conn->close();

    header('Location: documentos_compartilhados.php');
    exit;
} else {
    // se não houver documento_id no POST, redireciona de volta para a página de documentos compartilhados
    header('Location: documentos_compartilhados.php');
    exit;
}
?>
