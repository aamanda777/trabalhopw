<?php
session_start();

// verifica se o usuário está logado e redireciona para a página de login se não estiver
if (!isset($_SESSION['usuario_logado'])) {
    header('Location: login.php');
    exit;
}

$nomeUsuario = $_SESSION['nome_usuario'];
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página inicial</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f6f6f9;
        }
    </style>
</head>

<body>
    <div class="flex flex-col items-center justify-start h-screen py-12">
        <h1 class="text-3xl font-bold mb-9 text-center text-pink-500 mt-20">Olá
            <?php echo $nomeUsuario; ?>,
            o que deseja fazer?
        </h1>
        <div class="grid grid-cols-2 gap-8">
            <a href="meus_documentos.php"
                class="bg-blue-200 hover:bg-blue-300 text-blue-700 hover:text-blue-800 font-semibold py-6 px-12 rounded block text-center uppercase">Ver
                meus documentos</a>
            <a href="documentos_compartilhados.php"
                class="bg-purple-200 hover:bg-purple-300 text-purple-700 hover:text-purple-800 font-semibold py-6 px-12 rounded block text-center uppercase">Ver
                documentos compartilhados</a>
            <a href="formulario_upload.php"
                class="bg-pink-200 hover:bg-pink-300 text-pink-700 hover:text-pink-800 font-semibold py-6 px-12 rounded block text-center uppercase">Fazer
                upload de documentos</a>
            <a href="compartilhamento.php"
                class="bg-yellow-200 hover:bg-yellow-300 text-yellow-700 hover:text-yellow-800 font-semibold py-6 px-12 rounded block text-center uppercase">Compartilhar
                documentos</a>
            <a href="busca_documentos.php"
                class="bg-green-200 hover:bg-green-300 text-green-700 hover:text-green-800 font-semibold py-6 px-12 rounded block text-center uppercase">Buscar
                documentos</a>
            <a href="logout.php"
                class="bg-red-200 hover:bg-red-300 text-red-700 hover:text-red-800 font-semibold py-6 px-12 rounded block text-center uppercase">Sair</a>
        </div>

    </div>
</body>

</html>