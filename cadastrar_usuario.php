<?php
// Iniciar sessão
session_start();

// Conectar ao banco de dados
$conn = new mysqli('localhost', 'root', '', 'trabalho');

// Verificar se houve erros na conexão
if ($conn->connect_error) {
  die('Erro na conexão com o banco de dados: ' . $conn->connect_error);
}

// Receber os dados do formulário
$nome = $_POST['nome'];
$email = $_POST['email'];
$senha = $_POST['senha'];

// Validar os dados do formulário
if (empty($nome) || empty($email) || empty($senha)) {
  $_SESSION['erro_cadastro'] = 'Por favor, preencha todos os campos.';
  header('Location: cadastro.php');
  exit();
}

// Verificar se o e-mail já está cadastrado
$sql = "SELECT COUNT(*) AS total FROM usuarios WHERE email = '$email'";
$resultado = $conn->query($sql);
$linha = $resultado->fetch_assoc();

if ($linha['total'] > 0) {
  $_SESSION['erro_cadastro'] = 'O e-mail informado já está cadastrado.';
  header('Location: cadastro.php');
  exit();
}

// Criptografar a senha
$senhaCriptografada = password_hash($senha, PASSWORD_DEFAULT);

// Inserir o novo usuário no banco de dados
$sql = "INSERT INTO usuarios (nome, email, senha) VALUES ('$nome', '$email', '$senhaCriptografada')";

if ($conn->query($sql) === TRUE) {
  header('Location: inicial.html');
  exit();
} else {
  $_SESSION['erro_cadastro'] = 'Erro ao cadastrar usuário: ' . $conn->error;
  header('Location: cadastro.php');
  exit();
}

// Fechar a conexão com o banco de dados
$conn->close();
