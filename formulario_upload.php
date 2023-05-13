<!DOCTYPE html>
<html>

<head>
  <title>Upload de livro</title>
  <meta charset="UTF-8">

  <link href="https://cdn.tailwindcss.com" rel="stylesheet">
  
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-50 flex justify-center items-center h-screen">
  <div class="bg-gray-100 p-8 rounded-lg shadow-md w-1/2">
    <h1 class="text-3xl font-bold mb-8 text-pink-500 uppercase text-center">Upload de livro</h1>

    <?php
    session_start();

    // verificar se o usuário está logado
    if (!isset($_SESSION['usuario_logado'])) {
      $_SESSION['mensagem'] = 'Você precisa estar logado para acessar esta página.';
      header('Location: login.php');
      exit;
    }

    // verificar se o formulário foi enviado
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      // verificar se o arquivo foi enviado corretamente
      if (isset($_FILES['arquivo']) && $_FILES['arquivo']['error'] === UPLOAD_ERR_OK) {
        // Obter informações do arquivo
        $arquivo = $_FILES['arquivo'];
        $nomeArquivo = $arquivo['name'];
        $caminhoArquivo = 'uploads/' . $nomeArquivo;
        $extensao = pathinfo($nomeArquivo, PATHINFO_EXTENSION);

        // mover o arquivo para o diretório de destino
        if (move_uploaded_file($arquivo['tmp_name'], $caminhoArquivo)) {

          // Conectar ao banco de dados
          $conn = new mysqli('localhost', 'root', '', 'trabalho');

          if ($conn->connect_error) {
            die('Erro na conexão com o banco de dados: ' . $conn->connect_error);
          }

          // instrução SQL para inserir os dados do arquivo no banco de dados
          $sql = "INSERT INTO documentos (id_usuario, titulo, descricao, arquivo, extensao) VALUES (?, ?, ?, ?, ?)";
          $stmt = $conn->prepare($sql);
          $stmt->bind_param("issss", $_SESSION['id_usuario'], $_POST['titulo'], $_POST['descricao'], $nomeArquivo, $extensao);

          if ($stmt->execute()) {
            echo '<p class="text-green-500 mb-4">Arquivo enviado com sucesso e informações salvas no banco de dados!</p>';
          } else {
            echo '<p class="text-red-500 mb-4">Erro ao salvar informações no banco de dados.</p>';
          }

          // fechar a conexão com o banco de dados
          $stmt->close();
          $conn->close();

          //caso nao de certo
        } else {
          echo '<p class="text-red-500 mb-4">Erro ao mover o arquivo.</p>';
        }
      } else {
        echo '<p class="text-red-500 mb-4">Erro ao enviar o arquivo.</p>';
      }
    }
    ?>
    <form action="formulario_upload.php" method="POST" enctype="multipart/form-data">
      <div class="mb-4">
        <label for="arquivo" class="block text-green-500 font-bold mb-2 uppercase">Selecione o livro:</label>
        <input type="file" name="arquivo" required class="border border-gray-300 bg-white py-2 px-4 w-full mb-4 focus:outline-none focus:ring-2 focus:ring-blue-400">
        <label for="titulo" class="block text-green-500 font-bold mb-2 uppercase">Título:</label>
        <input type="text" name="titulo" required class="border bg-white border-gray-300 py-2 px-4 w-full mb-4 focus:outline-none focus:ring-2 focus:ring-blue-400">

        <label for="descricao" class="block text-green-500 font-bold mb-2 uppercase">Descrição:</label>
        <textarea name="descricao" required class="border border-gray-300 bg-white py-2 px-4 w-full mb-4 focus:outline-none focus:ring-2 focus:ring-blue-400"></textarea>

        <input type="submit" value="Enviar" class="uppercase mt-4 bg-purple-300 text-white font-bold py-2 px-4 rounded-lg hover:bg-purple-400 w-full mb-4">
        <p class="text-gray-700 text-center">Voltar para <a href="index.php" class="text-pink-500 font-bold hover:underline">tela inicial</a>.</p>
  </div>
    </form>
  </body>
  </html>
