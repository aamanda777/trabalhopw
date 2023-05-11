<?php
  // Verificar se o ID do documento foi fornecido
  if (isset($_GET['id'])) {
    $documentoId = $_GET['id'];

    // Conectar ao banco de dados
    $conn = new mysqli('localhost', 'root', '', 'trabalho');

    // Verificar se houve erros na conexão
    if ($conn->connect_error) {
      die('Erro na conexão com o banco de dados: ' . $conn->connect_error);
    }

    // Consultar o documento no banco de dados
    $sql = "SELECT titulo, arquivo, extensao FROM documentos WHERE id = $documentoId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      $titulo = $row['titulo'];
      $arquivo = $row['arquivo'];
      $extensao = $row['extensao'];

      // Definir os cabeçalhos para o download
      header("Content-Type: application/octet-stream");
      header("Content-Disposition: attachment; filename=\"$titulo.$extensao\"");
      header("Content-Length: " . strlen($arquivo));

      // Enviar o conteúdo do arquivo para o navegador
      echo $arquivo;
    } else {
      echo 'Documento não encontrado.';
    }

    // Fechar a conexão com o banco de dados
    $conn->close();
  } else {
    echo 'ID do documento não fornecido.';
  }
?>
