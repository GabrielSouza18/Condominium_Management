<?php

// Configurações do banco de dados
define('DB_HOST', 'sql202.infinityfree.com');
define('DB_USER', 'if0_34614409');
define('DB_PASS', '5vl3KdbUuT8');
define('DB_NAME', 'if0_34614409_condominio');

// Criar conexão
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Verificar conexão
if (!$conn) {
    die("A conexão falhou: " . mysqli_connect_error());
}
?>