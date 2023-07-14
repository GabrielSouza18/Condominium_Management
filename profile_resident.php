<?php
require_once 'assets/PHP/db_connect.php';
session_start();

$email = $_SESSION["email"];
$email = mysqli_real_escape_string($conn, $email); // escapando caracteres especiais

$sql = "SELECT * FROM usuario LEFT JOIN apartamento ON ap_id = usu_ap_id WHERE usu_email = '$email'";
$resultado = mysqli_query($conn, $sql);
$dados = mysqli_fetch_array($resultado);

$usu_tipo = $dados["usu_tipo"];

// redirecionando para a página apropriada
if ($usu_tipo != "morador" && $usu_tipo != "admin") {
    header("Location: index.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Perfil - CM</title>
    <link rel="shortcut icon" href="assets/img/favicon.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/cssIcons.css">
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.all.min.js"></script>
</head>

<body>
    <div id="wrapper">
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
                <nav class="navbar navbar-expand-sm navbar-dark " style="height: 80px; background-color:#353535;">
                    <div class="container-fluid h-100">
                        <a class="navbar-brand " href="dashboard_resident.php">
                            <img src="assets/img/logo.png" style="max-width: 60px;border-radius: 50%;">
                            <span class="d-inline-block align-middle mx-3">Condominium Management</span>
                        </a>
                        <div class="navbar-nav ms-auto h-100">
                            <li class="nav-item dropdown h-100">
                                <a class="nav-link dropdown-toggle h-100" href="#" id="navbarDropdown" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src='assets/php/read_img.php?PicNum=<?php echo $dados['usu_id']; ?>'
                                        alt="Imagem do Usuário" class="rounded-circle" width="50" height="50">
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="profile_resident.php">Perfil</a></li>

                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="assets/PHP/logout.php">Sair</a></li>
                                </ul>
                            </li>
                        </div>
                    </div>
                </nav>

                <div class="d-md-none d-flex justify-content-center align-items-center mt-3 ">
                    <a href="dashboard_resident.php"><i class="gg-home mx-2" id=></i></a>
                    <label>Voltar ao index</label>

                </div>
                <div class="d-flex flex-column" id="content-wrapper">
                    <div class="container mt-3"
                        style='background-image: url("assets/php/read_img.php?PicNum=<?php echo $dados['usu_id']; ?>");padding:5px; height: 100px; width: 100px;background-position: center; background-size: cover; background-repeat: no-repeat; border-radius: 100%;'>

                    </div>
                    <p class="h5 mt-3 text-center"><b>
                            <?php echo $dados['usu_nome']; ?>
                        </b></p>
                    <p class="h5 text-center">Meu cadastro:
                        <?php echo $dados['usu_tipo']; ?>
                    </p>
                    <form action="assets/PHP/update_manager_and_resident.php" method="POST"
                        enctype="multipart/form-data" class="d-flex justify-content-center">
                        <input type="hidden" name="id" value="<?PHP echo $dados['usu_id']; ?>">
                        <div class="card h-100 w-75 ">
                            <div class="card-body ">
                                <div class="row gutters">
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <h6 class=" text-center text-primary">Atualizar Dados</h6>
                                        <p class=" d-flex justify-content-center">Por favor, preencha todos os campos
                                            antes de enviar</p>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="name">Nome</label>
                                            <input type="text" class="form-control" id="nome"
                                                value="<?php echo $dados["usu_nome"]; ?>" name="nome"
                                                onkeyup="this.value = formatNome(this.value)" maxlength="50">
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control" id="email"
                                                value="<?php echo $dados["usu_email"]; ?>" name="email"
                                                onkeyup="this.value = formatEmail(this.value)" maxlength="80">
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="password">Senha</label>
                                            <input type="text" class="form-control" id="password" name="password">
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="cpf">CPF</label>
                                            <input type="text" class="form-control" id="cpf"
                                                value="<?php echo $dados["usu_cpf"]; ?>" name="cpf"
                                                onkeyup="this.value = formatCPF(this.value)" maxlength="14">
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="telFixo">Telefone Fixo</label>
                                            <input type="text" class="form-control" id="fixo"
                                                value="<?php echo $dados["usu_telFixo"]; ?>" name="telFixo"
                                                onkeyup="this.value = formatTel(this.value)" maxlength="13">
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="telMovel">Telefone Movél</label>
                                            <input type="text" class="form-control" id="movel"
                                                value="<?php echo $dados["usu_telMovel"]; ?>" name="telMovel"
                                                onkeyup="this.value = formatTelM(this.value)" maxlength="14">
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="foto">foto</label>
                                            <input type="file" class="form-control" id="inputFoto" name="foto">
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                        <label for="selectTipo" class="form-label">Tipo</label>
                                        <select class="form-select" id="selectTipo" name="tipo">
                                            <option value="" hidden>Selecione uma opção</option>
                                            <option value="morador" <?php if ($dados['usu_tipo'] == "morador") {
                                                echo "SELECTED";
                                            } ?>>Morador</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button type="submit" id="btnAtualizar" name="btnAtualizar"
                                        class="btn btn-secondary mt-4 ">Atualizar</button>
                                    <a href="dashboard_resident.php"> <button type="button"
                                            class=" d-none d-md-block btn btn-primary mt-4">Voltar</button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>

</html>