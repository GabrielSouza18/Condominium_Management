<?php
require_once 'db_connect.php';
session_start();
$chamado_id = $_POST['chamado_id'];
$resposta = $_POST['mensagem'];
$status = $_POST['status'];

// Prepare a declaração SQL para atualizar o chamado
$sql = "UPDATE chamado SET cha_resposta = ?, cha_status = ? WHERE cha_id = ?";

// Crie uma declaração preparada
$stmt = $conn->prepare($sql);

// Verifique se a declaração preparada foi criada com sucesso
if ($stmt === false) {
    die(mysqli_error($conn));
}

// Vincule as variáveis de parâmetro às placeholders da declaração preparada
$stmt->bind_param("ssi", $resposta, $status, $chamado_id);

// Execute a declaração preparada
if ($stmt->execute()) {
    // Insira a nova mensagem na tabela de mensagens
    $remetente_id = $_SESSION['id'];
    $mensagem = $resposta;

    // Prepare a declaração SQL para inserir a nova mensagem
    $stmtMensagem = $conn->prepare("INSERT INTO mensagem (men_cha_id,men_usu_id, men_mensagem) VALUES (?, ?, ?)");
    $stmtMensagem->bind_param("iis", $chamado_id, $remetente_id, $mensagem);

    // Verifique se a declaração preparada foi criada com sucesso
    if ($stmtMensagem === false) {
        die(mysqli_error($conn));
    }

    // Execute a declaração preparada para inserir a nova mensagem
    if ($stmtMensagem->execute()) {
        header('Location:../../dashboard_manager.php');
    } else {
        echo "Erro ao inserir a mensagem: " . mysqli_error($conn);
    }

    $stmtMensagem->close();
} else {
    echo "Erro ao atualizar o chamado: " . mysqli_error($conn);
}

$stmt->close();
$conn->close();

?>