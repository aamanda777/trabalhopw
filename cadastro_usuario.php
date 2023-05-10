<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Cadastro de Usuários</title>
    
    <link href="https://unpkg.com/tailwindcss@2.2.15/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.tailwindcss.com" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.15/tailwind.min.css" integrity="sha512-y3GvPLsI1eSZJqD6kXqoUFXC6Ua8qxR1T6WX2T6zO+ODrLRGG/s23P98x9XImGXvPPpO14P8fjexM/Lry1+sDA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  </head>
  <body class="bg-pink-100 flex justify-center items-center h-screen">
    <div class="bg-white p-8 rounded-lg shadow-md w-96">
      <h1 class="text-3xl font-bold mb-8 text-pink-500 text-center">Cadastro de Usuários</h1>
      <?php if (isset($erro)): ?>
        <p><?php echo $erro; ?></p>
      <?php endif; ?>
      <form action="cadastrar_usuario.php" method="post">
        <div class="mb-4">
          <label for="nome" class="block text-gray-700 font-bold mb-2">Nome:</label>
          <input type="text" id="nome" name="nome" required class="border-2 border-gray-400 p-2 w-full rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500">
        </div>
        <div class="mb-4">
          <label for="email" class="block text-gray-700 font-bold mb-2">E-mail:</label>
          <input type="email" id="email" name="email" required class="border-2 border-gray-400 p-2 w-full rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500">
        </div>
        <div class="mb-4">
          <label for="senha" class="block text-gray-700 font-bold mb-2">Senha:</label>
          <input type="password" id="senha" name="senha" required class="border-2 border-gray-400 p-2 w-full rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500">
        </div>
        <div class="mb-4">
          <input type="submit" value="Cadastrar" class="bg-pink-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-pink-600 w-full">
        </div>
      </form>
    </div>
  </body>
</html>
