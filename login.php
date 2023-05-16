<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.15/dist/tailwind.min.css" rel="stylesheet">
  </head>
  <body class="bg-yellow-50">
    <div class="flex justify-center items-center h-screen">
      <div class="bg-gray-50 p-8 rounded-lg flex shadow-lg w-2/3 mx-auto">
        <div class="w-2/3">
          <h1 class="text-3xl uppercase text-center font-bold mb-8 text-pink-500 mt-6">Faça seu login</h1>
          
          <?php
            session_start();
            if (isset($_SESSION['mensagem'])) {
              echo '<p class="text-red-500 mb-4">' . $_SESSION['mensagem'] . '</p>';
              unset($_SESSION['mensagem']);
            }
          ?>
          
          <form action="processa_login.php" method="post">
            <div class="mb-4">
              <label for="email" class="block text-blue-500 uppercase">E-mail:</label>
              <input type="email" id="email" name="email" required class="focus:outline-none focus:ring-2 focus:ring-blue-200 mt-3 w-full px-4 py-2 border border-gray-300 rounded">
            </div>
            <div class="mb-4">
              <label for="senha" class="block uppercase text-blue-500">Senha:</label>
              <input type="password" id="senha" name="senha" required class="focus:outline-none focus:ring-2 focus:ring-blue-200  w-full px-4 py-2 border border-gray-300 rounded mt-2">
            </div>
            <button type="submit" class="uppercase mt-4 bg-purple-300 text-white font-bold py-2 px-4 rounded-lg hover:bg-purple-400 w-full mb-4">Entrar</button>
          </form>
          
          <p class="text-gray-700 text-center mt-4">Não tem uma conta? <a href="cadastro_usuario.php" class="text-pink-500 font-bold hover:underline">Crie uma aqui</a>.</p>
        </div>
        
        <div class="w-1/2 p-8 flex items-center justify-center">
          <img src="img/book.png" class="h-full">
        </div>
      </div>
    </div>
  </body>
</html>
