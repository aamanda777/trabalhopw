<!DOCTYPE html>
<html>

<head>
    <title>Documentos Compartilhados</title>
    <meta charset="UTF-8">
    <link href="https://cdn.tailwindcss.com" rel="stylesheet">
</head>

<body>
    <div class="container">
        <h1>Documentos Compartilhados</h1>

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

        // puxa a lista de documentos compartilhados com o usuário
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

        // verifica se tem documentos compartilhados
        if ($resultado->num_rows > 0) {
            while ($row = $resultado->fetch_assoc()) {
                $documentoId = $row['id'];
                $titulo = $row['titulo'];
                $descricao = $row['descricao'];

                echo '<div class="document">';
                echo '<h3>' . $titulo . '</h3>';
                echo '<p>' . $descricao . '</p>';
                echo '<a href="download.php?id=' . $documentoId . '">Baixar</a>';
                echo '<form method="POST" action="excluir_documento.php">';
                echo '<input type="hidden" name="documento_id" value="' . $documentoId . '">';
                echo '<button type="submit">Excluir</button>';
                echo '</form>';
                echo '</div>';
            }
        } else {
            echo '<p>Nenhum documento compartilhado encontrado.</p>';
        }

        $conn->close();
        ?>

        <p><a href="index.php">Voltar para a página inicial</a></p>
    </div>
</body>

</html>
