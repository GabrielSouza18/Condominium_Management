<?php
require_once 'db_connect.php';

$stmt = $conn->prepare("SELECT COUNT(cha_id) AS totalChamadosAbertos FROM chamado WHERE cha_status = 'aberto'");
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

$totalChamadosAbertos = $row['totalChamadosAbertos'];

$stmt->close();
$conn->close();

// Retornar o resultado como JSON
header('Content-Type: application/json');
echo json_encode(array('totalChamadosAbertos' => $totalChamadosAbertos));
?>

