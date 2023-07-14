<?php
require_once 'db_connect.php';

// Consulta para obter as mensagens mais recentes
$stmtMensagens = $conn->prepare("SELECT m.men_id, m.men_cha_id, m.men_usu_id, m.men_mensagem, m.men_data, u.usu_nome 
    FROM mensagem m
    INNER JOIN usuario u ON m.men_usu_id = u.usu_id
    INNER JOIN chamado c ON m.men_cha_id = c.cha_id
    WHERE u.usu_tipo = 'morador' AND c.cha_status = 'em_andamento'
    ORDER BY m.men_data DESC");


$stmtMensagens->execute();
$resultMensagens = $stmtMensagens->get_result();

$novasMensagens = array();
while ($rowMensagens = $resultMensagens->fetch_assoc()) {
    $novasMensagens[] = array(
        'men_id' => $rowMensagens['men_id'],
        'men_cha_id' => $rowMensagens['men_cha_id'],
        'men_usu_id' => $rowMensagens['men_usu_id'],
        'men_mensagem' => $rowMensagens['men_mensagem'],
        'men_data' => $rowMensagens['men_data'],
        'usu_nome' => $rowMensagens['usu_nome']
    );
}

$stmtMensagens->close();
$conn->close();

// Retornar os resultados como JSON
header('Content-Type: application/json');
echo json_encode($novasMensagens);