<?php
require_once 'db_connect.php';
session_start();

$tipoChamado = $_POST['tipoChamado'];
$problema = $_POST['problema'];
$statuschamado = $_POST['statusChamado'];
$usuid = $_SESSION['id'];

// switch ($tipoChamado) {
//     case 'infraestrutura':
//         $chaImportancia = 'grave';
//         break;
//     case 'som':
//         $chaImportancia = 'medio';
//         break;
//     case 'sugestoes':
//     case 'outros':
//     default:
//         $chaImportancia = 'comum';
//         break;
// }

// Verificando o tipo do chamado, e definindo a importancia
if ($tipoChamado === 'infraestrutura') {
    $chaImportancia = 'grave';
} else if ($tipoChamado === 'som') {
    $chaImportancia = 'medio';
} else {
    $chaImportancia = 'comum';
}


// Insere o chamado na tabela de chamados
$stmtChamado = $conn->prepare("INSERT INTO chamado (cha_tipo, cha_problema, cha_status, cha_usu_id, cha_importancia) VALUES (?, ?, ?, ?, ?)");
$stmtChamado->bind_param("sssss", $tipoChamado, $problema, $statuschamado, $usuid, $chaImportancia);

if ($stmtChamado->execute()) {
    // Obtém o ID do chamado recém-criado
    $chamadoId = $stmtChamado->insert_id;

    // Insere a mensagem inicial na tabela de mensagens
    $mensagemInicial = "Morador $problema";
    $remetenteId = $usuid;

    $stmtMensagem = $conn->prepare("INSERT INTO mensagem (men_cha_id,men_usu_id, men_mensagem) VALUES (?, ?, ?)");
    $stmtMensagem->bind_param("iis", $chamadoId, $remetenteId, $mensagemInicial);
    $stmtMensagem->execute();

    $stmtMensagem->close();
    $stmtChamado->close();

    header('Location: ../../dashboard_resident.php');
} else {
    echo "Erro ao criar registro: " . mysqli_error($conn);
}

$conn->close();
?>