<?php
session_start();

// Verifica se o usuário está logado, redireciona para a página de login se não estiver
if (!isset($_SESSION['usuario_logado'])) {
  header('Location: login.html');
  exit;
}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Página Inicial</title>
    
    <link href="https://unpkg.com/tailwindcss@2.2.15/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.tailwindcss.com" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.15/tailwind.min.css" integrity="sha512-y3GvPLsI1eSZJqD6kXqoUFXC6Ua8qxR1T6WX2T6zO+ODrLRGG/s23P98x9XImGXvPPpO14P8fjexM/Lry1+sDA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  </head>
  <body class="bg-pink-100 flex justify-center items-center h-screen">
    <h1 class="text-3xl font-bold mb-8 text-pink-500 text-center">Bem-vindo à página inicial</h1>
    <p>Conteúdo exclusivo para usuários logados</p>
    <a href="logout.php">Sair</a>
  </body>
</html>
