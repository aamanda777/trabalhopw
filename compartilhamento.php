<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compartilhamento de documentos</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>


<body class="bg-yellow-50 flex justify-center items-center h-screen">
    <div class="bg-gray-50 p-8 rounded-lg  shadow-lg w-2/3 mx-auto">
        <h1 class="text-3xl font-bold mb-8 text-pink-500 text-center uppercase">Compartilhamento de documentos</h1>
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

        // puxa a lista de usuários cadastrados no sistema, excluindo o usuário atualmente logado
        $sql = "SELECT id, nome FROM usuarios WHERE id != ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $idUsuario);
        $stmt->execute();
        $resultado = $stmt->get_result();

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
            $sql = "INSERT INTO permissoes (id_documento, id_usuario, permissao) VALUES (?, ?, 'visualizar')";
            $stmt = $conn->prepare($sql);

            // realiza a inserção das permissões no banco de dados para cada usuário selecionado
            foreach ($idUsuariosCompartilhados as $idUsuarioCompartilhado) {
                $stmt->bind_param("ii", $idDocumento, $idUsuarioCompartilhado);
                $stmt->execute();
            }

            // verificar se a inserção deu certo
            if ($stmt->affected_rows > 0) {
                echo '<p class="text-green-500 mb-4">O documento foi compartilhado com sucesso.</p>';
            } else {
                echo '<p class="text-red-500 mb-4">Ocorreu um erro ao compartilhar o documento.</p>';
            }
        }
        ?>


        <form method="POST" action="" class="mb-4">
            <label for="id_documento" class="block text-blue-400 font-bold mb-2 uppercase">Selecione o
                documento:</label>
            <select name="id_documento" id="id_documento"
                class="border-2 border-gray-400 p-2 w-full rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-200">

                <?php foreach ($documentos as $documento): ?>
                    <option value="<?php echo $documento['id']; ?>"><?php echo $documento['titulo']; ?></option>
                <?php endforeach; ?>

            </select>
            <br>

            <label for="usuarios_compartilhados" class="block text-blue-400 font-bold mb-2 mt-4 uppercase">Selecione o
                usuário
                para compartilhar:</label>
            <select name="usuarios_compartilhados[]" id="usuarios_compartilhados" multiple
                class="border-2 border-gray-400 p-2 py-3 w-full rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-200">

                <?php foreach ($usuarios as $usuario): ?>
                    <option value="<?php echo $usuario['id']; ?>"><?php echo $usuario['nome']; ?></option>
                <?php endforeach; ?>

            </select>
            <br>

            <input type="submit" value="Compartilhar" class="uppercase mt-4 bg-purple-300 text-white font-bold py-2 px-4 rounded-lg hover:bg-purple-400 w-full mb-4">
            <p class="text-gray-700 text-center mt-4">Voltar para <a href="index.php"
                    class="text-pink-500 font-bold hover:underline">tela inicial</a>.</p>
        </form>
    </div>
</body>

</html>