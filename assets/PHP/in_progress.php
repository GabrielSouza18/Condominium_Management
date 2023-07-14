<?php
require_once 'db_connect.php';

$stmt = $conn->prepare("SELECT COUNT(cha_id) AS totalChamadosAndamento FROM chamado WHERE cha_status = 'em_andamento'");
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

$totalChamadosAndamento = $row['totalChamadosAndamento'];

$stmt->close();
$conn->close();

// Retornar o resultado como JSON
header('Content-Type: application/json');
echo json_encode(array('totalChamadosAndamento' => $totalChamadosAndamento));
?>