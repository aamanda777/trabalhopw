<?php
// Conectar ao banco de dados
$conn = new mysqli('localhost', 'root', '', 'trabalho');

// Verificar se houve erros na conexão
if ($conn->connect_error) {
  die('Erro na conexão com o banco de dados: ' . $conn->connect_error);
}

// Receber os dados do formulário
$titulo = $_POST['titulo'];
$descricao = $_POST['descricao'];

// Verificar se foi selecionado um arquivo válido
if ($_FILES['arquivo']['error'] != UPLOAD_ERR_OK) {
  die('Erro ao enviar arquivo.');
}

$extensao = strtolower(pathinfo($_FILES['arquivo']['name'], PATHINFO_EXTENSION));

if ($extensao != 'pdf' && $extensao != 'doc' && $extensao != 'docx') {
  die('Formato de arquivo inválido.');
}

$arquivo = file_get_contents($_FILES['arquivo']['tmp_name']);

// Verificar se o usuário está logado
session_start();
if (!isset($_SESSION['id_usuario'])) {
  die('Usuário não está logado.');
}
$id_usuario = $_SESSION['id_usuario'];

// Inserir o documento no banco de dados
$sql = "INSERT INTO documentos (id_usuario, titulo, descricao, arquivo, extensao) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("issss", $id_usuario, $titulo, $descricao, $arquivo, $extensao);
if ($stmt->execute()) {
  echo 'Documento enviado com sucesso!';
} else {
  echo 'Erro ao enviar documento: ' . $stmt->error;
}

// Fechar a conexão com o banco de dados
$stmt->close();
$conn->close();

header('Location: formulario_upload.html');
?>
