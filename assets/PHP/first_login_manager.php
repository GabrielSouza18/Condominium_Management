<?php
require_once 'db_connect.php';

// Recupera os dados do formulário
$id = $_POST['id'];
$email = $_POST['email'];
$senha = $_POST['password'];
$senha = password_hash($senha, PASSWORD_DEFAULT);
$cpf = $_POST['cpf'];
$foto = $_FILES['foto'];
$fixo = $_POST['telefonefixo'];
$movel = $_POST['telefonemovel'];
$nomeFinal = time() . '.jpg';
$uploads_dir = realpath(dirname(__FILE__) . '/../../assets/uploads') . '/';

if (move_uploaded_file($foto['tmp_name'], $uploads_dir . $foto['name'])) {

    $tamanhoImg = filesize($uploads_dir . $foto['name']);
    $mysqlImg = file_get_contents($uploads_dir . $foto['name']);

    // Prepara a query
    $sql_usuario = "UPDATE usuario SET usu_email = ?, usu_senha = ?, usu_cpf = ?, usu_foto = ?, usu_telFixo = ?, usu_telMovel = ? WHERE usu_id = ?";
    $stmt = mysqli_prepare($conn, $sql_usuario);
    // Bind dos parâmetros
    mysqli_stmt_bind_param($stmt, 'ssssssi', $email, $senha, $cpf, $mysqlImg, $fixo, $movel, $id);

    // Executa a consulta
    if (mysqli_stmt_execute($stmt)) {
        // Recupera os dados da imagem do banco de dados
        $sql_imagem = "SELECT usu_foto FROM usuario WHERE usu_id = $id";
        $resultado_imagem = mysqli_query($conn, $sql_imagem);
        $dados_imagem = mysqli_fetch_assoc($resultado_imagem);
        $imagem_codificada = base64_encode($dados_imagem['usu_foto']);
        $src_imagem = 'data:image/jpeg;base64,' . $imagem_codificada;

        // Redireciona para a página de dashboard
        header('Location:../../dashboard_manager.php');
        unlink($uploads_dir . $foto['name']);
    } else {
        echo "Erro ao criar registro: " . mysqli_error($conn);
    }

    // Fecha o statement e a conexão
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}