<?php
require_once 'assets/php/db_connect.php';
session_start();
$email = $_SESSION["email"];
$sql = "SELECT * FROM usuario  WHERE usu_email = '$email'";
$resultado = mysqli_query($conn, $sql);
$dados = mysqli_fetch_array($resultado);
$usu_tipo = $dados["usu_tipo"];
if ($usu_tipo != "sindico" && $usu_tipo != "admin") {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Cadastrar Condominio</title>
    <link rel="icon" type="image/png" sizes="500x500" href="assets/img/favicon.png">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>

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
                            <div class="flex-grow-1 bg-login-image" id="registerCondImage">
                            </div>
                        </div>
                        <div class="col-lg-6" id="conteudoPrincipalRegister">
                            <h4 class="d-flex justify-content-center">Cadastro de Bloco/Apto</h4>
                            <div class="p-5 mb-5">
                                <form action="assets/PHP/include_condominium.php" method="POST" class="user" id="form">
                                    <label for="email" class="d-flex ">Bloco:</label><br>
                                    <input class="form-control form-control-user" type="text" id="bloco" name="bloco"
                                        required></br>
                                    <label for="apto" class="d-flex ">Apto:</label><br>
                                    <input class="form-control form-control-user" type="text" id="apto" name="apto"
                                        required></br>
                                    <div class="d-flex justify-content-center">
                                        <div class="w-75">
                                            <label for="selectOcupado" class="form-label ">Ocupado?</label>
                                            <select class="form-select" id="selectOcupado" name="ocupado">
                                                <option value="">Selecione uma opção</option>
                                                <option value="sim">Sim</option>
                                                <option value="nao">Não</option>
                                            </select>
                                        </div>
                                    </div>
                            </div>
                            <div class="d-flex justify-content-center">
                                <button class="btn btn-primary border d-block btn-user w-75 " type="submit"
                                    id="btnEnviar" value="enviar">Enviar</button>
                            </div>
                            </form>
                            <a href="dashboard_manager.php" id="aRecovery" class=" d-flex justify-content-center mt-4">Voltar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.all.min.js"></script>
</body>
</html>