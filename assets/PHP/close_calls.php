<?php
require_once 'db_connect.php';

$stmt = $conn->prepare("SELECT COUNT(cha_id) AS totalChamadosFechados FROM chamado WHERE cha_status = 'fechado'");
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

$totalChamadosFechados = $row['totalChamadosFechados'];

$stmt->close();
$conn->close();

// Retornar o resultado como JSON
header('Content-Type: application/json');
echo json_encode(array('totalChamadosFechados' => $totalChamadosFechados));
?>