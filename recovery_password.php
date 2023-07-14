<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Recuperar senha</title>
    <link rel="icon" type="image/png" sizes="500x500" href="assets/img/favicon.png">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.all.min.js"></script>
    <style>
        html,
        body {
            height: 100% !important;

            overflow: hidden !important;
        }

        .container {
            height: 100% !important;
            margin: 0 !important;

        }
    </style>
</head>
<body class="d-flex justify-content-center align-items-center vh-100" id="bg-white">
    <div class=" container">
        <div class="row justify-content-center">
            <div class="col-md-9 col-lg-12 col-xl-10">
                <div class="card shadow-lg o-hidden border-0 my-5">
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-flex">
                            <div class="flex-grow-1 bg-login-image" id="recoveryPassImage">
                            </div>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <center>
                                <img src="assets/img/lock.svg" alt="LogoSite" id="imgLogoIndex">
                                <p id="pIndex">Recupere sua senha</p>
                            </center>
                            <div class="p-5 mb-5">
                                <form action="assets/PHP/recovery_password.php" method="POST" class="user">
                                    <label for="email" class="d-flex justify-content-center">Digite seu Email para
                                        recuperar a senha</label><br>
                                    <input class="form-control form-control-user" type="email" id="email"
                                        aria-describedby="emailHelp" placeholder="Email" name="email"
                                        style="margin-right: -46px;" maxlength="80" required>

                            </div>
                            <div class="d-flex justify-content-center">
                                <button class="btn btn-primary border d-block btn-user w-75" type="submit"
                                    id="btnEnviar" value="recuperar" name="SendRecupSenha">Enviar</button>
                            </div>
                            </form>
                            <a href="index.php" id="aRecovery" class=" d-flex justify-content-center mt-4">Voltar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    session_start();
    if (isset($_SESSION["successMail"])) {
        // obtém a mensagem de sucesso da variável de sessão
        $successMessage = $_SESSION["successMail"];
        // remove a mensagem de sucesso da variável de sessão para não exibi-la novamente
        unset($_SESSION["successMail"]);
        // exibe o modal do SweetAlert com a mensagem de sucesso
        echo "<script>
        swal({
            title: 'Email Enviado!',
            text: '$successMessage',
            icon: 'success',
            button: 'OK',
        });
    </script>";
    } else if (isset($_SESSION["errorMail"])) {
        // obtém a mensagem de sucesso da variável de sessão
        $errorMessage = $_SESSION["errorMail"];
        echo "<script>
        swal({
            title: 'Email Não Enviado!',
            text: '$errorMessage',
            icon: 'error',
            button: 'OK',
        });
    </script>";
    }
    ?>

</body>
</html>