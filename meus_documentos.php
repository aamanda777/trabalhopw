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
        <title>Meus Livros</title>
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    </head>
    <style>
        body {
            background-color: #EBF5FF;
        }
    </style>
    <div class="container mx-auto py-8">
        <h1 class="text-4xl font-bold mb-9 text-center text-pink-500 uppercase">Meus Livros</h1>

        <?php while ($row = $resultado->fetch_assoc()) {
            $documentoId = $row['id'];
            $titulo = $row['titulo'];
            $descricao = $row['descricao'];
            $dataUpload = $row['data_upload'];
            ?>

            <div class="bg-gray-50 rounded-lg shadow-md p-4 mb-4">
                <h3 class="text-2xl text-purple-600 mb-2 uppercase">
                    <?php echo $titulo; ?>
                </h3>
                <p class="text-gray-700 mb-2">
                    <?php echo $descricao; ?>
                </p>
                <p class="text-gray-500">Data de Upload:
                    <?php echo $dataUpload; ?>
                </p>
                <a href="download.php?id=<?php echo $documentoId; ?>"
                    class="inline-block bg-green-300 hover:bg-green-400 focus:bg-green-600 transition-colors duration-300 ease-in-out text-white font-semibold px-5 py-2 rounded-lg mr-2 mt-3">Baixar</a>
                <form method="POST" action="excluir_meusdocumentos.php" class="inline-block">
                    <input type="hidden" name="documento_id" value="<?php echo $documentoId; ?>">
                    <button type="submit"
                        class="bg-red-400 hover:bg-red-500 focus:bg-red-600 transition-colors duration-300 ease-in-out text-white font-semibold px-4 py-2 rounded-lg">Excluir</button>
                </form>
            </div>

        <?php } ?>

    </div>
    <p class="text-gray-700 text-center">Voltar para a <a href="index.php"
            class="text-pink-500 font-bold hover:underline">tela inicial</a>.</p>
    </p>
    </body>

    </html>


    <?php
} else {
    echo '<p>Nenhum documento encontrado.</p>';
}

$stmt->close();
$conn->close();
?>