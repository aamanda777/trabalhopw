<!DOCTYPE html>
<html>

<head>
    <title>Livros Compartilhados</title>
    <meta charset="UTF-8">

    <link href="https://unpkg.com/tailwindcss@2.2.15/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.tailwindcss.com" rel="stylesheet">
</head>

<style>
    body {
        background-color: #EBF5FF;
    }
</style>

<body>
    <div class="container mx-auto px-4 py-10">
        <h1 class="text-3xl font-bold mb-4 text-center text-pink-500 uppercase">Livros Compartilhados comigo</h1>

        <?php
        session_start();

        // Verifica se o usuário está logado
        if (!isset($_SESSION['usuario_logado'])) {
            $_SESSION['mensagem'] = 'Você precisa estar logado para acessar esta página.';
            header('Location: login.php');
            exit;
        }

        // Conecta ao banco de dados
        $conn = new mysqli('localhost', 'root', '', 'trabalho');
        if ($conn->connect_error) {
            die('Erro na conexão com o banco de dados: ' . $conn->connect_error);
        }

        // Puxa a lista de documentos compartilhados com o usuário
        $idUsuario = $_SESSION['id_usuario'];
        $sql = "SELECT documentos.id, documentos.titulo, documentos.descricao
                FROM documentos
                INNER JOIN permissoes ON documentos.id = permissoes.id_documento
                INNER JOIN usuarios ON permissoes.id_usuario = usuarios.id
                WHERE permissoes.id_usuario = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $idUsuario);
        $stmt->execute();
        $resultado = $stmt->get_result();

        // Verifica se há documentos compartilhados
        if ($resultado->num_rows > 0) {
            echo '<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">';
            while ($row = $resultado->fetch_assoc()) {
                $documentoId = $row['id'];
                $titulo = $row['titulo'];
                $descricao = $row['descricao'];

                echo '<div class="bg-gray-50 rounded-lg shadow-md p-4 mb-4">';
                echo '<h3 class="text-2xl text-purple-600 mb-2 uppercase">' . $titulo . '</h3>';
                echo '<p class="text-gray-700 mb-2">' . $descricao . '</p>';
                echo '<a href="download.php?id=' . $documentoId . '" class="inline-block bg-green-300 hover:bg-green-400 focus:bg-green-600 transition-colors duration-300 ease-in-out text-white font-semibold px-5 py-2 rounded-lg mr-2 mt-3">Baixar</a>';
                echo '<form method="POST" action="excluir_documento.php" class="inline-block">';
                echo '<input type="hidden" name="documento_id" value="' . $documentoId . '">';
                echo '<button type="submit" class=" bg-red-400 hover:bg-red-500 focus:bg-red-600 transition-colors duration-300 ease-in-out text-white font-semibold px-4 py-2 rounded-lg">Excluir</button>';
                echo '</form>';
                echo '</div>';
            }
            echo '</div>';
        } else {
            echo '<p class="text-gray-700">Nenhum documento compartilhado encontrado.</p>';
        }

        $conn->close();
        ?>

        <p class="text-gray-700 text-center">Voltar para a <a href="index.php"
                class="text-pink-500 font-bold hover:underline">tela inicial</a>.</p>
    </div>
</body>

</html>
