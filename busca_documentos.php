<!DOCTYPE html>
<html>

<head>
  <title>Busca de documentos</title>

  <meta charset="UTF-8">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-yellow-50 flex justify-center items-center">
  <div class="bg-gray-50 p-8 rounded-lg shadow-lg w-2/3 mx-auto">
    <h1 class="text-3xl uppercase text-center font-bold mb-8 text-pink-500">Busca de documentos</h1>

    <?php
    session_start();

    if (!isset($_SESSION['usuario_logado'])) {
      $_SESSION['mensagem'] = 'Você precisa estar logado para acessar esta página.';
      header('Location: login.php');
      exit;
    }
    // verifica se o usuario ta logado
    
    $conn = new mysqli('localhost', 'root', '', 'trabalho');
    if ($conn->connect_error) {
      die('Erro na conexão com o banco de dados: ' . $conn->connect_error);
    }
    // conexao
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      // recebe os critérios de busca
      $nome = $_POST['nome'];
      $dataUpload = $_POST['data_upload'];
      $proprietario = $_POST['proprietario'];

      // consulta SQL baseada nos critérios de busca
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

      // executa a consulta SQL
      $result = $conn->query($sql);

      // verifica se algum documento foi encontrado
      if ($result->num_rows > 0) {
        echo '<h2 class="text-2xl uppercase text-gray-700 mt-4">Documentos Encontrados:</h2>';

        while ($row = $result->fetch_assoc()) {
          echo '<p class="mt-4"><span class="uppercase text-blue-500 font-semibold">Título:</span> ' . $row['titulo'] . '</p>';
          echo '<p><span class=" uppercase font-semibold text-blue-500">Descrição:</span> ' . $row['descricao'] . '</p>';
          echo '<p class="mt-2"><a href="download.php?id=' . $row['id'] . '" class="flex items-center text-green-500 font-semibold hover:none"><i class="fa regular fa-sharp fa-solid fa-download" style="color: #30db00;"></i></a></p>';


          echo '<hr class="my-4">';
        }
      } else {
        echo '<p class=" text-center text-red-500">Nenhum documento encontrado.</p>';
      }
    }
    ?>
    <form action="busca_documentos.php" method="POST" class="mt-8">
      <div class="mb-6">
        <label for="nome" class="text-lg font-semibold uppercase ">Título:</label>
        <input type="text" name="nome" id="nome"
          class=" mt-2 border border-gray-300 py-2 px-4 rounded-md w-full focus:outline-none focus:ring-2 focus:ring-fuschia-200 ">
      </div>

      <div class="mb-6">
        <label for="data_upload" class="text-lg font-semibold uppercase">Data de Upload:</label>
        <input type="date" name="data_upload" id="data_upload"
          class=" mt-2 border border-gray-300 py-2 px-4 rounded-md w-full focus:outline-none focus:ring-2 focus:ring-fuschia-200">
      </div>

      <div class="mb-6">
        <label for="proprietario" class="text-lg font-semibold uppercase">Proprietário:</label>
        <select name="proprietario" id="proprietario"
          class="mt-2 border border-gray-300 py-2 px-4 rounded-md w-full focus:outline-none focus:ring-2 focus:ring-fuschia-200">
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

      <button type="submit"
        class="uppercase mt-4 bg-purple-300 text-white font-bold py-2 px-4 rounded-lg hover:bg-purple-400 w-full mb-4">
        Buscar
      </button>

      <p class="text-gray-700 text-center mt-4">Voltar para <a href="index.php"
          class="text-pink-500 font-bold hover:underline">tela inicial</a>.</p>
    </form>
  </div>
</body>

</html>