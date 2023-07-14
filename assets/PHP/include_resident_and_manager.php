<?php
require_once 'db_connect.php';

// Recupera os dados do formulário
$nome = $_POST['nome'];
$email = $_POST['email'];
$senha = $_POST['password'];
$senha = password_hash($senha, PASSWORD_DEFAULT);
$apto = $_POST['apto'];
$bloco = $_POST['bloco'];
$tipo = $_POST['tipo'];

// Modifica o e-mail para adicionar o domínio padrão
$email_parts = explode("@", $email);
$email = $email_parts[0] . "@condominium.com";

echo $bloco . "<br>" . $apto;

// Verifica se o apartamento existe na tabela "apartamento"
$sql_apto_exist = "SELECT ap_id FROM apartamento WHERE ap_bloco = ? AND ap_id = ?";
$stmt = mysqli_prepare($conn, $sql_apto_exist);
mysqli_stmt_bind_param($stmt, "ii", $bloco, $apto);
mysqli_stmt_execute($stmt);
$result_apto_exist = mysqli_stmt_get_result($stmt);

if ($result_apto_exist) {
    $row_apto_exist = mysqli_fetch_array($result_apto_exist);
    if ($row_apto_exist) {
        $ap_id = $row_apto_exist['ap_id'];

        // Insere os dados na tabela "usuario" com o ap_id
        $sql_usuario = "INSERT INTO usuario (usu_nome, usu_email, usu_senha, usu_tipo, usu_ap_id) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql_usuario);
        mysqli_stmt_bind_param($stmt, "ssssi", $nome, $email, $senha, $tipo, $ap_id);
        mysqli_stmt_execute($stmt);

        // Executa as queries
        if (mysqli_stmt_affected_rows($stmt) > 0) {
            $sql = "SELECT * FROM usuario WHERE upper(usu_email) like upper(?) LIMIT 1";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            $query = mysqli_stmt_get_result($stmt);
            $dados = mysqli_fetch_array($query);
            $sql_apto = "UPDATE apartamento SET ap_ocupado = 'sim' WHERE ap_id = ?";
            $stmt = mysqli_prepare($conn, $sql_apto);
            mysqli_stmt_bind_param($stmt, "i", $dados['usu_ap_id']);
            mysqli_stmt_execute($stmt);

            if ($tipo != 'sindico') {
                header('Location:../../list_residents.php');
            } else {
                header('Location:../../admin.php');
            }
        } else {
            echo "Erro ao criar registro: " . mysqli_error($conn);
        }
    } else {
        echo "Apartamento não encontrado na tabela 'apartamento'.";
    }
}