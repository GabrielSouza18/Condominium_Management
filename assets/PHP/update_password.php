<?php
require_once 'db_connect.php';

$id = $_POST['id'];
$senhaprincipal = $_POST['updatePassword'];
$senha = password_hash($senhaprincipal, PASSWORD_DEFAULT);

// Usa uma declaração preparada para evitar a injeção de SQL
$stmt = $conn->prepare("UPDATE usuario SET usu_senha=? WHERE usu_id=?");
$stmt->bind_param("si", $senha, $id);

// Executa a consulta
if ($stmt->execute()) {
    header('Location:../../update_password.php');
    $_SESSION['successUpdate'] = "Senha atualizada com sucesso";
} else {
    $_SESSION['errorUpdate'] = "Oops.. Houve algum erro, Tente Novamente!" . mysqli_error($conn);
}

$stmt->close();
$conn->close();
?>