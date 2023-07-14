<?php
session_start();
require_once 'db_connect.php';

// Recupera os dados do formulário
$bloco = $_POST['bloco'];
$apto = $_POST['apto'];
$ocupado = $_POST['ocupado'];


// Verifica se a conexão com o banco de dados foi bem sucedida
if (!$conn) {
    die("Conexão falhou: " . mysqli_connect_error());
}

// Prepara e executa a consulta SQL
$stmt = $conn->prepare("INSERT INTO apartamento (ap_bloco, ap_num, ap_ocupado) VALUES (?,?,?)");
$stmt->bind_param("sss", $bloco, $apto, $ocupado);


if ($stmt->execute()) {
    $_SESSION["cadastrado"] = "Enviado";
    echo '<script>Swal.fire("Sucesso", "Enviado", "success");</script>';
} else {
    $_SESSION["erroCadastro"] = "Erro ao Cadastrar";
    echo 'Erro ao criar registro: ' . mysqli_error($conn);
}
header('Location: ../../register_condominium.php');
exit();
?>