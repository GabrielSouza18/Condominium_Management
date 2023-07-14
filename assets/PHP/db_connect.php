<?php

// Configurações do banco de dados
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'condominio');

// Criar conexão
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Verificar conexão
if (!$conn) {
    die("A conexão falhou: " . mysqli_connect_error());
}
?>