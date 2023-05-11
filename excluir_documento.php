<?php
session_start();

// verifica se o usuário está logado
if (!isset($_SESSION['usuario_logado'])) {
    $_SESSION['mensagem'] = 'Você precisa estar logado para acessar esta página.';
    header('Location: login.php');
    exit;
}

// verifica se o ID do documento foi enviado
if (isset($_POST['documento_id'])) {
    $documentoId = $_POST['documento_id'];

    // conecta o banco de dados
    $conn = new mysqli('localhost', 'root', '', 'trabalho');
    if ($conn->connect_error) {
        die('Erro na conexão com o banco de dados: ' . $conn->connect_error);
    }

    // verifica se o documento pertence ao usuário
    $idUsuario = $_SESSION['id_usuario'];
    $sql = "SELECT id FROM documentos WHERE id = ? AND id_usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $documentoId, $idUsuario);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        // o documento pertence ao usuário, pode ser excluído
        $sql = "DELETE FROM documentos WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $documentoId);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $_SESSION['mensagem'] = 'Documento excluído com sucesso.';
        } else {
            $_SESSION['mensagem'] = 'Ocorreu um erro ao excluir o documento.';
        }
    } else {
        $_SESSION['mensagem'] = 'O documento não foi encontrado ou você não tem permissão para excluí-lo.';
    }

    $conn->close();
}

header('Location: documentos_compartilhados.php');
exit;
?>
