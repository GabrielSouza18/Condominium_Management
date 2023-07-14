<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Atualizar Senha</title>
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

<!-- Recuperar senha -->

<body class="d-flex justify-content-center align-items-center vh-100" id="bg-white">

    <div class=" container">
        <div class="row justify-content-center">
            <div class="col-md-9 col-lg-12 col-xl-10">
                <div class="card shadow-lg o-hidden border-0 my-5">
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-flex">
                            <div class="flex-grow-1 bg-login-image" id="bg-login-image"> </div>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <center>
                                <img src="assets/img/updatePass2.svg" alt="LogoSite" id="imgLogoIndex">
                                <p id="pIndex">Atualize sua Senha</p>
                            </center>
                            <div class="p-5 mb-5">
                                <form action="assets/PHP/update_password.php" method="POST" class="user">
                                    <label for="password" class="d-flex justify-content-center">Digite aqui sua nova
                                        senha</label><br>
                                    <input class="form-control form-control-user" type="password" id="password"
                                        placeholder="Nova senha" name="updatePassword" maxlength="80" required>
                                    <input type="hidden" name="id" value="<?php echo $_SESSION['id'] ?>">
                                </form>
                            </div>
                            <div class="d-flex justify-content-center">
                                <button class="btn btn-primary border d-block btn-user w-75 " type="submit"
                                    id="btnEnviar" value="updatePassword" name="Sendatualizarsenha">Enviar</button>
                            </div>
                            <a href="index.php" id="aRecovery" class=" d-flex justify-content-center mt-4">Lembrou?Faça
                                login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <?php
    session_start();
    if (isset($_SESSION["successUpdate"])) {
        // obtém a mensagem de sucesso da variável de sessão
        $updateMessage = $_SESSION["successUpdate"];
        // remove a mensagem de sucesso da variável de sessão para não exibi-la novamente
        unset($_SESSION["successUpdate"]);
        // exibe o modal do SweetAlert com a mensagem de sucesso
        echo "<script>
        swal({
            title: 'Senha atualizada com Sucesso',
            text: '$updateMessage',
            icon: 'success',
            button: 'OK',
        });
    </script>";
    } else if (isset($_SESSION["errorUpdate"])) {
        // obtém a mensagem de sucesso da variável de sessão
        $errorUpdate = $_SESSION["errorUpdate"];
        echo "<script>
        swal({
            title: 'Oops... Houve algum erro!',
            text: '$errorUpdate',
            icon: 'error',
            button: 'OK',
        });
    </script>";
    }
    ?>

</body>

</html>