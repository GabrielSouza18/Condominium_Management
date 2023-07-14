<?php
require_once 'db_connect.php';
session_start();

$chamado_id = $_POST['chamado_id'];
$respostaProblema = $_POST['resp_chamado'];
$status = $_POST['status'];

// Usa uma declaração preparada para evitar a injeção de SQL
$stmt = $conn->prepare("UPDATE chamado SET cha_problema=?, cha_status=? WHERE cha_id=?");
$stmt->bind_param("ssi", $respostaProblema, $status, $chamado_id);

// Executa a consulta
if ($stmt->execute()) {
    header('Location:../../dashboard_resident.php');
} else {
    header('Location:../../dashboard_resident.php') . mysqli_error($conn);
}

$stmt->close();
$conn->close();
?>