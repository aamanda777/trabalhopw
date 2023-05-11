<?php
session_start();

// verifica se o usuário está logado, leva até a página de login se não estiver
if (!isset($_SESSION['usuario_logado'])) {
    header('Location: login.php');
    exit;
}

// Verifica se o formulário de exclusão foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['excluir_documento'])) {
    $idDocumento = $_POST['excluir_documento'];
    
    // Aqui você pode adicionar o código para excluir o documento do banco de dados
    // ...
    // ...

    // Exemplo de mensagem de sucesso
    $mensagem = "Documento excluído com sucesso.";
}

// Conecta ao banco de dados
$conn = new mysqli('localhost', 'root', '', 'trabalho');
if ($conn->connect_error) {
    die('Erro na conexão com o banco de dados: ' . $conn->connect_error);
}

// Obtém o ID do usuário logado
$idUsuario = $_SESSION['id_usuario'];

// Consulta os documentos do usuário
$sql = "SELECT id, titulo, descricao, data_upload FROM documentos WHERE id_usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $idUsuario);
$stmt->execute();
$resultado = $stmt->get_result();

// Verifica se há documentos cadastrados
if ($resultado->num_rows > 0) {
    $documentos = $resultado->fetch_all(MYSQLI_ASSOC);
} else {
    $documentos = [];
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Documentos</title>
    <link href="https://unpkg.com/tailwindcss@2.2.15/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-pink-100">
    <div class="container mx-auto px-4 py-10">
        <h1 class="text-3xl font-bold mb-4 text-center text-pink-500">Meus Documentos</h1>
        <?php if (!empty($mensagem)) : ?>
            <p class="text-green-500 mb-4"><?php echo $mensagem; ?></p>
        <?php endif; ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <?php foreach ($documentos as $documento) : ?>
                <div class="bg-white rounded-lg shadow-lg p-4">
                    <h2 class="text-lg font-bold text-pink-500 mb-2"><?php echo $documento['titulo']; ?></h2>
                    <p class="text-gray-600 mb-2"><?php echo $documento['descricao']; ?></p>
                    <p class="text-gray-600 mb-2">Data de Upload: <?php echo $documento['data_upload']; ?></p>
                    <div class="flex justify-between">
                        <a href="download_documento.php?id=<?php echo $documento['id']; ?>"
                            class="bg-pink-500 hover:bg-pink-600 focus:bg-pink-600 transition-colors duration-300 ease-in-out py-2 px-4 rounded-lg block text-center text-white font-semibold">Baixar</a>
                        <form action="excluir_documento.php" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este documento?');">
                            <input type="hidden" name="excluir_documento" value="<?php echo $documento['id']; ?>">
                            <button type="submit" class="bg-red-500 hover:bg-red-600 focus:bg-red-600 transition-colors duration-300 ease-in-out py-2 px-4 rounded-lg block text-center text-white font-semibold">Excluir</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>

