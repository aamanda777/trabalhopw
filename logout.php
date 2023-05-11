<?php
session_start();

// Encerra a sessão e remove todos os dados da sessão
session_destroy();

// Redireciona o usuário de volta para a página de login
header('Location: login.php');
exit;
?>
