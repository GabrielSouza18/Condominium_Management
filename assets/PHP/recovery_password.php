<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require '../lib/vendor/autoload.php';

include '../PHP/db_connect.php';

session_start();

if (isset($_POST['email']) && !empty($_POST['email'])) {
    // Recuperar o email digitado pelo usuário
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    // Validar o email digitado pelo usuário
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION["error"] = "Endereço de e-mail inválido.";
        header("Location: ../../recovery_password.php");
        exit;
    }

    // Consultar o banco de dados para recuperar o id e nome da pessoa com base no email
    $stmt = $conn->prepare("SELECT usu_id, usu_nome FROM usuario WHERE usu_email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $linha = $resultado->fetch_assoc();

    // Verificar se o email existe no banco de dados
    if ($linha) {
        $id = $linha['usu_id'];
        $nome = $linha['usu_nome'];
        $emailbanco = $email;

        $mail = new PHPMailer(true);

        try {
            // Configurações do servidor de email
            $mail->isSMTP();
            $mail->CharSet = 'UTF-8';
            $mail->Host = 'sandbox.smtp.mailtrap.io';
            $mail->Port = 2525;
            $mail->SMTPAuth = true;
            $mail->Username = '0b315d31788d57';
            $mail->Password = 'c8f90fde801da3';
            $mail->setFrom('atendimento@condominio.com.br', 'Atendimento');
            $mail->addAddress($email, $nome);
            $mail->isHTML(true);
            $mail->Subject = 'Recuperação de senha';

            // Imagem com bordas arredondadas
            $mail->Body = '<div style="text-align: center;"><img src="https://uploaddeimagens.com.br/images/004/448/168/full/logo.png?1682727999" alt="Logo da Empresa" style="max-width: 150px; border-radius: 50%;"></div>';

            // Texto e botão
            $mail->Body .= "<br><br><p style='text-align: center;font-family: Poppins;'>Olá $nome Recebemos sua solicitação de alteração de senha<br>Clique no Botão abaixo para redefini-la</p><br>";
            $mail->Body .= "<p style='text-align: center;font-family: Poppins;'><a href='http://localhost/condominio/update_password.php?email=$emailbanco&id=$id'><button style='background-color: #353535; border: none; color: white; padding: 10px 20px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; border-radius: 5px;cursor:pointer;'>Redefinir senha</button></a></p>";

            $mail->send();
            $_SESSION["successMail"] = "Seu e-mail de redefinição de senha foi enviado com sucesso!";
            header("Location: ../../recovery_password.php");
            exit;

        } catch (Exception $e) {
            $_SESSION["errorMail"] = "Ops, Email não enviado {$mail->ErrorInfo}";
            header("Location: ../../recovery_password.php");
            exit;
        }

    }
}