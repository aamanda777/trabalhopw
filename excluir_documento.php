<?php
  session_start();

  // Verificar se o usuário está logado
  if (!isset($_SESSION['usuario_logado'])) {
    $_SESSION['mensagem'] = 'Você precisa estar logado para acessar esta página.';
    header('Location: login.php');
    exit;
  }

  // Verificar se o parâmetro de ID do documento foi fornecido
  if (!isset($_GET['id'])) {
    header('Location: meus_documentos.php');
    exit;
  }

  // Conectar ao banco de dados
  $conn = new mysqli('localhost', 'root', '', 'trabalho');

  // Verificar se houve erros na conexão
  if ($conn->connect_error) {
    die('Erro na conexão com o banco de dados: ' . $conn->connect_error);
  }

  // Obter o ID do documento a ser excluído
  $idDocumento = $_GET['id'];

  // Verificar se o documento pertence ao usuário logado
  $idUsuario = $_SESSION['id_usuario'];
  $sql = "SELECT id FROM documentos WHERE id = ? AND id_usuario = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ii", $idDocumento, $idUsuario);
  $stmt->execute();
  $resultado = $stmt->get_result();

  // Verificar se o documento existe e pertence ao usuário logado
  if ($resultado->num_rows === 0) {
    $_SESSION['mensagem'] = 'Documento não encontrado.';
    header('Location: meus_documentos.php');
    exit;
  }

  // Excluir o documento do banco de dados
  $sql = "DELETE FROM documentos WHERE id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $idDocumento);
  $stmt->execute();

  // Verificar se a exclusão foi bem-sucedida
  if ($stmt->affected_rows > 0) {
    $_SESSION['mensagem'] = 'Documento excluído com sucesso.';
  } else {
    $_SESSION['mensagem'] = 'Erro ao excluir o documento.';
  }

  header('Location: meus_documentos.php');
  exit;
?>
