<?php
session_start();

$conn = new mysqli('localhost', 'root', '', 'trabalho');
if ($conn->connect_error) {
  die('Erro na conexão com o banco de dados: ' . $conn->connect_error);
} //conecta ao banco de dados

// recebe os dados do formulário
$nome = $_POST['nome'];
$email = $_POST['email'];
$senha = $_POST['senha'];

// valida os dados do formulário
if (empty($nome) || empty($email) || empty($senha)) {
  $_SESSION['erro_cadastro'] = 'Por favor, preencha todos os campos.';
  header('Location: cadastro.php');
  exit();
}

// verifica se o e-mail já está cadastrado
$sql = "SELECT COUNT(*) AS total FROM usuarios WHERE email = '$email'";
$resultado = $conn->query($sql);
$linha = $resultado->fetch_assoc();

if ($linha['total'] > 0) {
  $_SESSION['erro_cadastro'] = 'O e-mail informado já está cadastrado.';
  header('Location: cadastro.php');
  exit();
}

// criptografar a senha
$senhaCriptografada = password_hash($senha, PASSWORD_DEFAULT);

// insere o novo usuário no banco de dados
$sql = "INSERT INTO usuarios (nome, email, senha) VALUES ('$nome', '$email', '$senhaCriptografada')";

if ($conn->query($sql) === TRUE) {
  header('Location: login.php');
  exit();
} else {
  $_SESSION['erro_cadastro'] = 'Erro ao cadastrar usuário: ' . $conn->error;
  header('Location: cadastro.php');
  exit();
}

// fecha a conexão com o banco de dados
$conn->close();