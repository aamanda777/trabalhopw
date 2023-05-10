<!DOCTYPE html>
<html>
<head>
  <title>Meus Documentos</title>
</head>
<body>
  <h1>Meus Documentos</h1>
  <table>
    <thead>
      <tr>
        <th>Título</th>
        <th>Data de Criação</th>
        <th>Ações</th>
      </tr>
    </thead>
    <tbody>
      <?php
        // Conectar ao banco de dados
        $conn = new mysqli('localhost', 'root', '', 'trabalho');

        // Verificar se houve erros na conexão
        if ($conn->connect_error) {
          die('Erro na conexão com o banco de dados: ' . $conn->connect_error);
        }

        // Consultar os documentos do usuário logado
        $sql = "SELECT * FROM documentos WHERE id_usuario = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        $resultado = $stmt->get_result();

        // Exibir os documentos na tabela
        while ($documento = $resultado->fetch_assoc()) {
          echo '<tr>';
          echo '<td>' . $documento['titulo'] . '</td>';
          echo '<td>' . $documento['data_criacao'] . '</td>';
          echo '<td><a href="editar_documento.php?id=' . $documento['id'] . '">Editar</a> | <a href="excluir_documento.php?id=' . $documento['id'] . '">Excluir</a></td>';
          echo '</tr>';
        }

        // Fechar a conexão com o banco de dados
        $stmt->close();
        $conn->close();
      ?>
    </tbody>
  </table>
</body>
</html>
