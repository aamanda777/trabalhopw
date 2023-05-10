<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Upload de Documentos</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
  </head>
  <body class="bg-pink-50 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded-lg shadow-lg">
      <h1 class="text-3xl font-bold mb-8 text-pink-500 text-center">Upload de Documentos</h1>
      <form action="processa_upload.php" method="POST" enctype="multipart/form-data" class="space-y-4">
        <div>
          <label for="titulo" class="block font-medium text-gray-700">Título:</label>
          <input type="text" name="titulo" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pink-500 focus:ring focus:ring-pink-500 focus:ring-opacity-50">
        </div>
        <div>
          <label for="descricao" class="block font-medium text-gray-700">Descrição:</label>
          <textarea name="descricao" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pink-500 focus:ring focus:ring-pink-500 focus:ring-opacity-50"></textarea>
        </div>
        <div>
          <label for="arquivo" class="block font-medium text-gray-700">Arquivo:</label>
          <input type="file" name="arquivo" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pink-500 focus:ring focus:ring-pink-500 focus:ring-opacity-50">
        </div>
        <div>
          <label for="email" class="block font-medium text-gray-700">Seu e-mail:</label>
          <input type="email" name="email" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pink-500 focus:ring focus:ring-pink-500 focus:ring-opacity-50">
        </div>
        <div>
          <input type="submit" value="Enviar" class="w-full bg-pink-500 text-white py-2 px-4 rounded-md hover:bg-pink-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500 focus:ring-opacity-50">
        </div>
      </form>
    </div>
  </body>
</html>
