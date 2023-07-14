<?php
session_start(); // iniciando a sessão

// encerrando a sessão
session_destroy();

// adicionando cabeçalhos para evitar armazenamento em cache da página de logout
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

// redirecionando o usuário para a página de login
header("Location: ../../index.php");
exit();
?>
