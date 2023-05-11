<!DOCTYPE html>
<html>

<head>
  <title>Upload de Arquivo</title>
  <meta charset="UTF-8">
  
  <link href="https://unpkg.com/tailwindcss@2.2.15/dist/tailwind.min.css" rel="stylesheet">
  <link href="https://cdn.tailwindcss.com" rel="stylesheet">
</head>

<body class="bg-pink-100 flex justify-center items-center h-screen">
  <div class="bg-white p-8 rounded-lg shadow-lg w-96">
    <h1 class="text-3xl font-bold mb-8 text-pink-500 text-center">Upload de Arquivo</h1>

    <?php
    session_start();

    // Verificar se o usuário está logado
    if (!isset($_SESSION['usuario_logado'])) {
      $_SESSION['mensagem'] = 'Você precisa estar logado para acessar esta página.';
      header('Location: login.php');
      exit;
    }

    // Verificar se o formulário foi enviado
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      // Verificar se o arquivo foi enviado corretamente
      if (isset($_FILES['arquivo']) && $_FILES['arquivo']['error'] === UPLOAD_ERR_OK) {
        // Obter informações do arquivo
        $arquivo = $_FILES['arquivo'];
        $nomeArquivo = $arquivo['name'];
        $caminhoArquivo = 'uploads/' . $nomeArquivo;
        $extensao = pathinfo($nomeArquivo, PATHINFO_EXTENSION);

        // Mover o arquivo para o diretório de destino
        if (move_uploaded_file($arquivo['tmp_name'], $caminhoArquivo)) {
          // Conectar ao banco de dados
          $conn = new mysqli('localhost', 'root', '', 'trabalho');

          // Verificar se houve erros na conexão
          if ($conn->connect_error) {
            die('Erro na conexão com o banco de dados: ' . $conn->connect_error);
          }

          // Preparar a instrução SQL para inserir os dados do arquivo no banco de dados
          $sql = "INSERT INTO documentos (id_usuario, titulo, descricao, arquivo, extensao) VALUES (?, ?, ?, ?, ?)";
          $stmt = $conn->prepare($sql);
          $stmt->bind_param("issss", $_SESSION['id_usuario'], $_POST['titulo'], $_POST['descricao'], $nomeArquivo, $extensao);

          if ($stmt->execute()) {
            echo '<p class="text-green-500 mb-4">Arquivo enviado com sucesso e informações salvas no banco de dados!</p>';
          } else {
            echo '<p class="text-red-500 mb-4">Erro ao salvar informações no banco de dados.</p>';
          }

          // Fechar a conexão com o banco de dados
          $stmt->close();
          $conn->close();
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
        <label for="arquivo" class="block text-gray-700 font-bold mb-2">Selecione o arquivo:</label>
        <input type="file" name="arquivo" required class="border border-gray-300 py-2 px-4 w-full mb-4">

        <label for="titulo" class="block text-gray-700 font-bold mb-2">Título:</label>
        <input type="text" name="titulo" required class="border border-gray-300 py-2 px-4 w-full mb-4">

        <label for="descricao" class="block text-gray-700 font-bold mb-2">Descrição:</label>
        <textarea name="descricao" required class="border border-gray-300 py-2 px-4 w-full mb-4"></textarea>

        <input type="submit" value="Enviar" class="mt-4 bg-pink-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-pink-600 w-full mb-4">
        <p class="text-gray-700 text-center">Voltar para <a href="index.php" class="text-pink-500 font-bold hover:underline">tela inicial</a>.</p>
    </form>
  </div>
</body>

</html>
