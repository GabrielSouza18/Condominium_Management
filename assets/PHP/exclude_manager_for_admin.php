<?php

require_once 'db_connect.php';

// Recupera o id do usuário a ser excluído
$id = $_GET['id'];

// Recupera o nome do arquivo de imagem do usuário a ser excluído
$sql_imagem = "SELECT usu_foto FROM usuario WHERE usu_id = $id";
$resultado_imagem = mysqli_query($conn, $sql_imagem);
$dados_imagem = mysqli_fetch_assoc($resultado_imagem);
$nome_imagem = $dados_imagem['usu_foto'];

// Prepara a consulta SQL para liberar o apartamento para outros moradores, constatando-o como livre
$query_updt = "UPDATE apartamento SET ap_ocupado= 'nao' WHERE ap_id = (SELECT usu_ap_id FROM usuario WHERE usu_id = ?)";
$stmt_updt = mysqli_prepare($conn, $query_updt);
mysqli_stmt_bind_param($stmt_updt, 'i', $id);

// Prepara a consulta SQL para excluir os dados do usuário da tabela "usuario"
$sql_usuario = "DELETE FROM usuario WHERE usu_id = ?";
$stmt_usuario = mysqli_prepare($conn, $sql_usuario);
mysqli_stmt_bind_param($stmt_usuario, 'i', $id);

// Exclui o arquivo de imagem do usuário, se existir
$uploads_dir = realpath(dirname(__FILE__) . '/../uploads') . '/';
$imagem_path = $uploads_dir . $nome_imagem;
if (file_exists($imagem_path)) {
    unlink($imagem_path);
}

// Executa as queries
if (mysqli_stmt_execute($stmt_updt) && mysqli_stmt_execute($stmt_usuario)) {
    header('Location:../../admin.php');
} else {
    echo "Erro ao excluir registro: " . mysqli_error($conn);
}

// Fecha as statements
mysqli_stmt_close($stmt_updt);
mysqli_stmt_close($stmt_del);
mysqli_stmt_close($stmt_usuario);

// Fecha a conexão com o banco de dados
mysqli_close($conn);

?>
