<?php
// Conectar ao banco de dados
$conn = new mysqli('localhost', 'root', '', 'trabalho');

// Verificar se houve erros na conexão
if ($conn->connect_error) {
  die('Erro na conexão com o banco de dados: ' . $conn->connect_error);
}

// Receber os dados do formulário
$email = $_POST['email'];
$senha = $_POST['senha'];

// Verificar se o e-mail e a senha correspondem a um usuário cadastrado
$sql = "SELECT * FROM usuarios WHERE email = '$email'";
$resultado = $conn->query($sql);

if ($resultado->num_rows == 0) {
  die('E-mail ou senha inválidos.');
}

$usuario = $resultado->fetch_assoc();

if (!password_verify($senha, $usuario['senha'])) {
  die('E-mail ou senha inválidos.');
}

// Iniciar a sessão e armazenar os dados do usuário logado
session_start();
$_SESSION['id_usuario'] = $usuario['id'];
$_SESSION['nome_usuario'] = $usuario['nome'];
$_SESSION['email_usuario'] = $usuario['email'];

// Redirecionar para a página principal do sistema
header('Location: index.php');
?>
