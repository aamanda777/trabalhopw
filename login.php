<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Login</title>
    
    <link href="https://unpkg.com/tailwindcss@2.2.15/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.tailwindcss.com" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.15/tailwind.min.css" integrity="sha512-y3GvPLsI1eSZJqD6kXqoUFXC6Ua8qxR1T6WX2T6zO+ODrLRGG/s23P98x9XImGXvPPpO14P8fjexM/Lry1+sDA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  </head>
  <body class="bg-pink-100 flex justify-center items-center h-screen">
    <div class="bg-white p-8 rounded-lg shadow-lg w-96">
      <h1 class="text-3xl font-bold mb-8 text-pink-500 text-center">Faça seu login</h1>
      
      <?php
        session_start();
        if (isset($_SESSION['mensagem'])) {
          echo '<p class="text-red-500 mb-4">' . $_SESSION['mensagem'] . '</p>';
          unset($_SESSION['mensagem']);
        }
      ?>
      
      <form action="processa_login.php" method="post">
        <div class="mb-4">
          <label for="email" class="block text-gray-700 font-bold mb-2">E-mail:</label>
          <input type="email" id="email" name="email" required class="border-2 border-gray-400 p-2 w-full rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500">
        </div>
        <div class="mb-4">
          <label for="senha" class="block text-gray-700 font-bold mb-2">Senha:</label>
          <input type="password" id="senha" name="senha" required class="border-2 border-gray-400 p-2 w-full rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500">
        </div>
        <div class="mb-4">
          <button type="submit" class="bg-pink-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-pink-600 w-full">Entrar</button>
        </div>
      </form>
      <p class="text-gray-700 text-center">Não tem uma conta? <a href="cadastro_usuario.php" class="text-pink-500 font-bold hover:underline">Crie uma aqui</a>.</p>
    </div>
  </body>
</html>
