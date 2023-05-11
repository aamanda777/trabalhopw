<?php
session_start();

// verifica se o usuário está logado e redireciona para a página de login se não estiver
if (!isset($_SESSION['usuario_logado'])) {
    header('Location: login.php');
    exit;
}
?>


<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página inicial</title>
    <link href="https://unpkg.com/tailwindcss@2.2.15/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  </head>
  <body class="bg-pink-100">
    <div class="container mx-auto px-4 py-10 flex flex-col items-center">
      <h1 class="text-3xl font-bold mb-4 text-center text-pink-500">Olá, o que deseja fazer?</h1>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <a href="formulario_upload.php" class="bg-pink-500 hover:bg-pink-600 focus:bg-pink-600 transition-colors duration-300 ease-in-out py-4 px-6 rounded-lg block text-center text-white font-semibold text-lg">Upload de documento</a>
        <a href="meus_documentos.php" class="bg-pink-500 hover:bg-pink-600 focus:bg-pink-600 transition-colors duration-300 ease-in-out py-4 px-6 rounded-lg block text-center text-white font-semibold text-lg">Meus documentos</a>
        <a href="compartilhamento.php" class="bg-pink-500 hover:bg-pink-600 focus:bg-pink-600 transition-colors duration-300 ease-in-out py-4 px-6 rounded-lg block text-center text-white font-semibold text-lg">Compartilhar documento</a>
        <a href="busca_documentos.php" class="bg-pink-500 hover:bg-pink-600 focus:bg-pink-600 transition-colors duration-300 ease-in-out py-4 px-6 rounded-lg block text-center text-white font-semibold text-lg">Buscar documento</a>
        <a href="documentos_compartilhados.php" class="bg-pink-500 hover:bg-pink-600 focus:bg-pink-600 transition-colors duration-300 ease-in-out py-4 px-6 rounded-lg block text-center text-white font-semibold text-lg">Documentos compartilhados</a>
        <a href="logout.php" class="bg-pink-500 hover:bg-pink-600 focus:bg-pink-600 transition-colors duration-300 ease-in-out py-4 px-6 rounded-lg block text-center text-white font-semibold text-lg">Sair</a>
      </div>
    </div>
  </body>
</html>
