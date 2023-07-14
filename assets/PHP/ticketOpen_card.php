<?php
// ...
require_once 'db_connect.php';
// Consulta para obter as informações dos chamados abertos
$stmtChamadosInfo = $conn->prepare("SELECT c.cha_id, u.usu_nome, c.cha_importancia FROM chamado c
    INNER JOIN usuario u ON c.cha_usu_id = u.usu_id
    WHERE c.cha_status = 'aberto'");
$stmtChamadosInfo->execute();
$resultChamadosInfo = $stmtChamadosInfo->get_result();

$chamadosAbertos = array();
while ($rowChamadosInfo = $resultChamadosInfo->fetch_assoc()) {
    $chamadosAbertos[] = array(
        'cha_id' => $rowChamadosInfo['cha_id'],
        'usu_nome' => $rowChamadosInfo['usu_nome'],
        'cha_importancia' => $rowChamadosInfo['cha_importancia']
    );
}

$stmtChamadosInfo->close();
$conn->close();

// Retornar os resultados como JSON
header('Content-Type: application/json');
echo json_encode($chamadosAbertos);
?>