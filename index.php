<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Login - Condominium Management</title>
    <link rel="icon" type="image/png" sizes="500x500" href="assets/img/favicon.png">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/cssIcons.css">
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.all.min.js"></script>
    <style>
        #conteudo {
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            width: 100%;
        }
    </style>
</head>
<body style="background: #eef1f4; height: 100% ; overflow: hidden;">
    <!-- Tela de loader -->
    <div id="loader-container">
        <div class="d-flex flex-column justify-content-center align-items-center" style="height: 100vh;">
            <div>
                <img src="assets/img/logo.png" alt="Logo" width="300px" />
            </div>
            <div class="spinner-grow text-secondary" style="width:3rem;height:3rem;">
            </div>
        </div>
    </div>
    <div id="conteudo" style="display: none;">
        <div class="container mt-0" id="content">
            <div class="row justify-content-center">
                <div class="col-md-9 col-lg-12 col-xl-10">
                    <div class="card shadow-lg o-hidden border-0 my-5">

                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-flex">
                                <div class="flex-grow-1 bg-login-image"
                                    style="background: url(assets/img/backgroundLogin.jpg); background-repeat: no-repeat; background-position: center center; background-size: cover; ">
                                </div>
                            </div>
                            <div class="col-lg-6" style="margin-bottom: 31px;margin-top: 42px;">
                                <center>
                                    <img src="assets/img/logo.svg" alt="LogoSite" id="imgLogoIndex">
                                    <p id="pIndex">Seja-Bem Vindo de Volta</p>
                                </center>
                                <div class="p-5 mb-5">
                                    <form action="assets/PHP/login_action.php" method="POST" class="user">

                                        <input class="form-control form-control-user" type="email" id="email"
                                            aria-describedby="emailHelp" placeholder="Email" name="email"
                                            style="margin-right: -46px;" maxlength="80" required>
                                        <input class="form-control form-control-user mt-3" type="password" id="password"
                                            placeholder="Password" name="password">
                                </div>
                                <div class="d-flex justify-content-center">
                                    <button class="btn btn-primary border d-block btn-user w-75 " type="submit" id="btnEnviar">Login</button>
                                </div>
                                <a href="recovery_password.php" class="d-flex justify-content-center mt-4" id="aRecovery">Esqueci a Senha</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        window.addEventListener("load", function () {
            // Exibir o loader
            document.getElementById("loader-container").style.display = "block";

            // Ocultar o conteúdo da página
            document.getElementById("conteudo").style.display = "none";

            // Esperar 10 segundos antes de ocultar o loader e exibir o conteúdo da página
            setTimeout(function () {
                // Ocultar o loader com efeito fade out
                var loader = document.getElementById("loader-container");
                loader.style.opacity = 1;
                (function fade() {
                    if ((loader.style.opacity -= 0.1) < 0) {
                        loader.style.display = "none";
                        // Exibir o conteúdo da página com efeito fade in
                        var content = document.getElementById("conteudo");
                        content.style.opacity = 0;
                        content.style.display = "block";
                        (function fade() {
                            var val = parseFloat(content.style.opacity);
                            if (!((val += 0.1) > 1)) {
                                content.style.opacity = val;
                                requestAnimationFrame(fade);
                            }
                        })();
                    } else {
                        requestAnimationFrame(fade);
                    }
                })();
            }, 3000); // 10000 milissegundos = 10 segundos
        });
    </script>
</body>
</html>