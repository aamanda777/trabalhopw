<?php
// conectar ao banco de dados
$conn = new mysqli('localhost', 'root', '', 'trabalho');

if ($conn->connect_error) {
  die('Erro na conexão com o banco de dados: ' . $conn->connect_error);
}

// recebe os dados do formulário
$email = $_POST['email'];
$senha = $_POST['senha'];

// verificar se o e-mail e a senha são de um usuário cadastrado
$sql = "SELECT * FROM usuarios WHERE email = '$email'";
$resultado = $conn->query($sql);

if ($resultado->num_rows == 0) {
  session_start();
  $_SESSION['mensagem'] = 'E-mail ou senha inválidos.';
  header('Location: login.php');
  exit();
}

$usuario = $resultado->fetch_assoc();

if (!password_verify($senha, $usuario['senha'])) {
  session_start();
  $_SESSION['mensagem'] = 'E-mail ou senha inválidos.';
  header('Location: login.php');
  exit();
}

// inicia a sessão e armazena os dados do usuário logado
session_start();
$_SESSION['id_usuario'] = $usuario['id'];
$_SESSION['nome_usuario'] = $usuario['nome'];
$_SESSION['email_usuario'] = $usuario['email'];
$_SESSION['usuario_logado'] = true;

// redirecionar para a página inicial
header('Location: index.php');
?>
