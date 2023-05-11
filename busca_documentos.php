<!DOCTYPE html>
<html>

<head>
  <title>Busca de Documentos</title>

  <meta charset="UTF-8">
  <link href="https://unpkg.com/tailwindcss@2.2.15/dist/tailwind.min.css" rel="stylesheet">
  <link href="https://cdn.tailwindcss.com" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.15/tailwind.min.css"
    integrity="sha512-y3GvPLsI1eSZJqD6kXqoUFXC6Ua8qxR1T6WX2T6zO+ODrLRGG/s23P98x9XImGXvPPpO14P8fjexM/Lry1+sDA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="bg-pink-100">
  <div class="bg-white p-8 rounded-lg shadow-lg w-96 mx-auto">
    <h1 class="text-3xl font-bold mb-8 text-pink-500">Busca de Documentos</h1>

    <?php
    session_start();

    // Verificar se o usuário está logado
    if (!isset($_SESSION['usuario_logado'])) {
      $_SESSION['mensagem'] = 'Você precisa estar logado para acessar esta página.';
      header('Location: login.php');
      exit;
    }

    // Conectar ao banco de dados
    $conn = new mysqli('localhost', 'root', '', 'trabalho');

    // Verificar se houve erros na conexão
    if ($conn->connect_error) {
      die('Erro na conexão com o banco de dados: ' . $conn->connect_error);
    }

    // Verificar se o formulário foi enviado
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      // Receber os critérios de busca
      $nome = $_POST['nome'];
      $dataUpload = $_POST['data_upload'];
      $proprietario = $_POST['proprietario'];

      // Construir a consulta SQL baseada nos critérios de busca
      $sql = "SELECT * FROM documentos WHERE 1=1";

      if (!empty($nome)) {
        $sql .= " AND titulo LIKE '%$nome%'";
      }

      if (!empty($dataUpload)) {
        $sql .= " AND DATE(data_upload) = '$dataUpload'";
      }

      if (!empty($proprietario)) {
        $sql .= " AND id_usuario = $proprietario";
      }

      // Executar a consulta SQL
      $result = $conn->query($sql);

      // Verificar se há documentos encontrados
      if ($result->num_rows > 0) {
        echo '<h2 class="text-2xl font-bold mt-4">Documentos Encontrados:</h2>';

        while ($row = $result->fetch_assoc()) {
          echo '<p class="mt-2"><span class="font-semibold">Título:</span> ' . $row['titulo'] . '</p>';
          echo '<p><span class="font-semibold">Descrição:</span> ' . $row['descricao'] . '</p>';
          echo '<p><span class="font-semibold">Proprietário:</span> ' . $row['id_usuario'] . '</p>';
          echo '<p class="mt-2"><a href="download.php?id=' . $row['id'] . '" class="text-blue-500 font-semibold hover:underline">Baixar</a></p>';
          echo '<hr class="my-4">';
        }
      } else {
        echo '<p class="text-red-500">Nenhum documento encontrado.</p>';
      }
    }
    ?>

    <form action="busca_documentos.php" method="POST" class="mt-8">
      <div class="mb-4">
        <label for="nome" class="text-lg font-semibold">Nome:</label>
        <input type="text" name="nome" id="nome" class="border border-gray-300 py-2 px-4 rounded-md">
      </div>

      <div class="mb-4">
        <label for="data_upload" class="text-lg font-semibold">Data de Upload:</label>
        <input type="date" name="data_upload" id="data_upload" class="border border-gray-300 py-2 px-4 rounded-md">
      </div>

      <div class="mb-4">
        <label for="proprietario" class="text-lg font-semibold">Proprietário:</label>
        <select name="proprietario" id="proprietario" class="border border-gray-300 py-2 px-4 rounded-md">
          <option value="">Todos</option>
          <?php
          $sql = "SELECT id, nome FROM usuarios";
          $result = $conn->query($sql);

          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              echo '<option value="' . $row['id'] . '">' . $row['nome'] . '</option>';
            }
          }
          ?>
        </select>
      </div>

      <button type="submit" class="bg-pink-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-pink-600 w-full">
        Buscar
      </button>

      <p class="text-gray-700 text-center mt-4">Voltar para <a href="index.php"
          class="text-pink-500 font-bold hover:underline">tela inicial</a>.</p>
    </form>
  </div>
</body>

</html>