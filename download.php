<?php
// verificar se o ID do documento foi fornecido
if (isset($_GET['id'])) {
  $documentoId = $_GET['id'];

  // C=conecta o banco de dados
  $conn = new mysqli('localhost', 'root', '', 'trabalho');

  if ($conn->connect_error) {
    die('Erro na conexão com o banco de dados: ' . $conn->connect_error);
  }

  // consulta o documento no banco de dados
  $sql = "SELECT titulo, arquivo, extensao FROM documentos WHERE id = $documentoId";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $titulo = $row['titulo'];
    $arquivo = $row['arquivo'];
    $extensao = $row['extensao'];

    // coisas de dowmload
    header("Content-Type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"$titulo.$extensao\"");
    header("Content-Length: " . strlen($arquivo));

    // enviar o conteúdo do arquivo para o navegador
    echo $arquivo;
  } else {
    echo 'Documento não encontrado.';
  }

  $conn->close();

  // se o documento nao existir
} else {
  echo 'ID do documento não fornecido.';
}
?>