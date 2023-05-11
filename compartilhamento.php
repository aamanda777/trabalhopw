<!DOCTYPE html>
<html>

<head>
    <title>Compartilhamento de Documentos</title>
    <meta charset="UTF-8">
    <link href="https://unpkg.com/tailwindcss@2.2.15/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.tailwindcss.com" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.15/tailwind.min.css"
        integrity="sha512-y3GvPLsI1eSZJqD6kXqoUFXC6Ua8qxR1T6WX2T6zO+ODrLRGG/s23P98x9XImGXvPPpO14P8fjexM/Lry1+sDA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="bg-pink-100 flex justify-center items-center h-screen">
    <div class="bg-white p-8 rounded-lg shadow-lg w-96 mx-auto">
        <h1 class="text-3xl font-bold mb-8 text-pink-500 text-center">Compartilhamento de documentos</h1>

        <?php
        session_start();

        // verifica se o usuário está logado
        if (!isset($_SESSION['usuario_logado'])) {
            $_SESSION['mensagem'] = 'Você precisa estar logado para acessar esta página.';
            header('Location: login.php');
            exit;
        }

        // conecta o banco de dados
        $conn = new mysqli('localhost', 'root', '', 'trabalho');
        if ($conn->connect_error) {
            die('Erro na conexão com o banco de dados: ' . $conn->connect_error);
        }

        // puxa a lista de documentos cadastrados pelo usuário logado
        $idUsuario = $_SESSION['id_usuario'];
        $sql = "SELECT id, titulo FROM documentos WHERE id_usuario = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $idUsuario);
        $stmt->execute();
        $resultado = $stmt->get_result();

        // verifica se tem documentos cadastrados
        if ($resultado->num_rows > 0) {
            $documentos = $resultado->fetch_all(MYSQLI_ASSOC);
        } else {
            $documentos = [];
        }

        // puxa a lista de usuários cadastrados no sistema
        $sql = "SELECT id, nome FROM usuarios";
        $resultado = $conn->query($sql);

        // verificar se tem usuários cadastrados no sistema
        if ($resultado->num_rows > 0) {
            $usuarios = $resultado->fetch_all(MYSQLI_ASSOC);
        } else {
            $usuarios = [];
        }

        // verifica se o formulário foi enviado
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // recebe os dados do formulário
            $idDocumento = $_POST['id_documento'];
            $idUsuariosCompartilhados = $_POST['usuarios_compartilhados'];

            // prepara a instrução SQL para inserir as permissões de compartilhamento no banco de dados
            $sql = "INSERT INTO permissoes (id_documento, id_usuario, permissao) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);

            // realiza a inserção das permissoes no banco de dados prara cada usuario selecionada
            foreach ($idUsuariosCompartilhados as $idUsuarioCompartilhado) {
                // verifica se as permissões foram selecionadas e executar a inserção dela
                if (isset($_POST['permissao_visualizar'])) {
                    $permissaoVisualizar = $_POST['permissao_visualizar'];
                    $stmt->bind_param("iis", $idDocumento, $idUsuarioCompartilhado, $permissaoVisualizar);
                    $stmt->execute();
                }

                if (isset($_POST['permissao_editar'])) {
                    $permissaoEditar = $_POST['permissao_editar'];
                    $stmt->bind_param("iis", $idDocumento, $idUsuarioCompartilhado, $permissaoEditar);
                    $stmt->execute();
                }

                if (isset($_POST['permissao_excluir'])) {
                    $permissaoExcluir = $_POST['permissao_excluir'];
                    $stmt->bind_param("iis", $idDocumento, $idUsuarioCompartilhado, $permissaoExcluir);
                    $stmt->execute();
                }
            }

            // verificar se a inserção deu certo
            if ($stmt->affected_rows > 0) {
                echo '<p class="text-green-500 mb-4">Permissões de compartilhamento adicionadas com sucesso.</p>';
            } else {
                echo '<p class="text-red-500 mb-4">Ocorreu um erro ao adicionar as permissões de compartilhamento.</p>';
            }
        }
        ?>

        <form method="POST" action="" class="mb-4">
            <label for="id_documento" class="block text-gray-700 font-bold mb-2">Selecione o documento:</label>
            <select name="id_documento" id="id_documento"
                class="border-2 border-gray-400 p-2 w-full rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500">

                <?php foreach ($documentos as $documento): ?>
                    <option value="<?php echo $documento['id']; ?>"><?php echo $documento['titulo']; ?></option>
                <?php endforeach; //mostra os documentos que o usuario cadastrou ?>

            </select>
            <br>

            <label for="usuarios_compartilhados" class="block text-gray-700 font-bold mb-2 mt-4">Selecione o usuário
                para compartilhar:</label>
            <select name="usuarios_compartilhados[]" id="usuarios_compartilhados" multiple
                class="border-2 border-gray-400 p-2 w-full rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500">

                <?php foreach ($usuarios as $usuario): ?>
                    <option value="<?php echo $usuario['id']; ?>"><?php echo $usuario['nome']; ?></option>
                <?php endforeach; ?>

            </select>
            <br>

            <label for="permissao_visualizar" class="block text-gray-700 font-bold mb-2 mt-4">Permissão de
                visualização:</label>
            <input type="checkbox" name="permissao_visualizar" value="visualizar" class="mr-2">

            <label for="permissao_editar" class="block text-gray-700 font-bold mb-2">Permissão de edição:</label>
            <input type="checkbox" name="permissao_editar" value="editar" class="mr-2">

            <label for="permissao_excluir" class="block text-gray-700 font-bold mb-2">Permissão de exclusão:</label>
            <input type="checkbox" name="permissao_excluir" value="excluir" class="mr-2">
            <br>
            <input type="submit" value="Compartilhar"
                class="bg-pink-500 text-white font-semibold py-2 px-4 rounded-md hover:bg-pink-600 w-full">
            <p class="text-gray-700 text-center mt-4">Voltar para <a href="index.php"
                    class="text-pink-500 font-bold hover:underline">tela inicial</a>.</p>
        </form>
    </div>
</body>

</html>