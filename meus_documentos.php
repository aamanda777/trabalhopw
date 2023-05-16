<?php
session_start();

// verifica se o usuário está logado
if (!isset($_SESSION['usuario_logado'])) {
    $_SESSION['mensagem'] = 'Você precisa estar logado para acessar esta página.';
    header('Location: login.php');
    exit;
}

// conecta ao banco de dados
$conn = new mysqli('localhost', 'root', '', 'trabalho');
if ($conn->connect_error) {
    die('Erro na conexão com o banco de dados: ' . $conn->connect_error);
}

// obtém o ID do usuário logado
$idUsuario = $_SESSION['id_usuario'];

// consulta os documentos do usuário
$sql = "SELECT id, titulo, descricao, data_upload FROM documentos WHERE id_usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $idUsuario);
$stmt->execute();
$resultado = $stmt->get_result();

// verifica se existem documentos
if ($resultado->num_rows > 0) {
    ?>

    <!DOCTYPE html>
    <html lang="pt-br">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Meus Documentos</title>
         <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    </head>

    <body class="bg-yellow-50">
        <div class="container mx-auto px-4 py-10">
            <h1 class="text-4xl font-bold mb-9 text-center text-pink-500 uppercase">Meus documentos</h1>

            <div class=" ml-3 grid grid-cols-1 sm:grid-cols-2 gap-4">
                <?php while ($row = $resultado->fetch_assoc()) {
                    $documentoId = $row['id'];
                    $titulo = $row['titulo'];
                    $descricao = $row['descricao'];
                    $dataUpload = $row['data_upload'];
                    ?>

                    <div class="bg-gray-50 rounded-lg shadow-md p-4 ">
                        <h3 class="text-2xl text-blue-500 mb-2 uppercase">
                            <?php echo $titulo; ?>
                        </h3>
                        <p class="text-gray-700 mb-2">
                            <?php echo $descricao; ?>
                        </p>
                        <p class="text-gray-500">Data de Upload:
                            <?php echo $dataUpload; ?>
                        </p>
                        <a href="download.php?id=<?php echo $documentoId; ?>"
                            class="inline-block bg-green-300 hover:bg-green-400 focus:bg-green-600 transition-colors duration-300 ease-in-out text-white font-semibold px-5 py-2 rounded-lg mr-2 mt-3"><i class="fa regular fa-sharp fa-solid fa-download" style="color: #1a6100;"></i></a>
                        <form method="POST" action="excluir_meusdocumentos.php" class="inline-block">
                            <input type="hidden" name="documento_id" value="<?php echo $documentoId; ?>">
                            <button type="submit"
                                class="bg-red-300 hover:bg-red-400 focus:bg-red-400 transition-colors duration-300 ease-in-out text-white font-semibold px-4 py-2 rounded-lg"><i class="fa regular fa-sharp fa-solid fa-trash" style="color: #f00000;"></i></button>
                        </form>
                    </div>

                <?php } ?>
            </div>
        </div>

        <p class="text-gray-700 text-center">Voltar para a <a href="index.php"
                class="text-pink-500 font-bold hover:underline">tela inicial</a>.</p>

    </body>

    </html>


    <?php
} else {
    echo '<p>Nenhum documento encontrado.</p>';
}

$stmt->close();
$conn->close();
?>