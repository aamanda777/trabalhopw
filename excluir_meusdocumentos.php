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

    // verifica se o documento pertence ao usuário logado
    $idUsuario = $_SESSION['id_usuario'];
    $sql = "SELECT id FROM documentos WHERE id = ? AND id_usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $documentoId, $idUsuario);
    $stmt->execute();
    $stmt->store_result();

    // excluir o documento
    if ($stmt->num_rows > 0) {
        $sqlExcluir = "DELETE FROM documentos WHERE id = ?";
        $stmtExcluir = $conn->prepare($sqlExcluir);
        $stmtExcluir->bind_param("i", $documentoId);
        $stmtExcluir->execute();

        if ($stmtExcluir->affected_rows > 0) {
            $_SESSION['mensagem'] = 'Documento excluído com sucesso.';
        } else {
            $_SESSION['mensagem'] = 'Falha ao excluir o documento.';
        }
    } else {
        $_SESSION['mensagem'] = 'Você não tem permissão para excluir este documento.';
    }

    $stmt->close();
    $stmtExcluir->close();
    $conn->close();

    header('Location: meus_documentos.php');
    exit;
} else {
    $_SESSION['mensagem'] = 'Ação inválida.';
    header('Location: meus_documentos.php');
    exit;
}
?>
