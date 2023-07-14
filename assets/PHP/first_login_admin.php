<?php

require_once 'db_connect.php';

// Recupera os dados do formulário
$id = $_POST['id'];
$senha = $_POST['password'];
$senha = password_hash($senha, PASSWORD_DEFAULT);

// Prepara a query
$sql_admin = "UPDATE usuario SET usu_senha = ? WHERE usu_id = ?";
$stmt = mysqli_prepare($conn, $sql_admin);

// Bind dos parâmetros
mysqli_stmt_bind_param($stmt, 'si', $senha, $id);

// Executa a query
if (mysqli_stmt_execute($stmt)) {
    header('Location:../../admin.php');
} else {
    echo "Erro ao atualizar registro: " . mysqli_error($conn);
}

// Fecha o statement e a conexão
mysqli_stmt_close($stmt);
mysqli_close($conn);